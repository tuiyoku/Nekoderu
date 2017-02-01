<?php
namespace App\Controller;

// use CakeDC\Users\Controller\AppController;
use CakeDC\Users\Controller\Component\UsersAuthComponent;
use CakeDC\Users\Controller\Traits\LoginTrait;
use CakeDC\Users\Controller\Traits\ProfileTrait;
use CakeDC\Users\Controller\Traits\ReCaptchaTrait;
use CakeDC\Users\Controller\Traits\RegisterTrait;
use CakeDC\Users\Controller\Traits\SimpleCrudTrait;
use CakeDC\Users\Controller\Traits\SocialTrait;
use App\Controller\Traits\ResignTrait;
use CakeDC\Users\Model\Table\UsersTable;
use Cake\Core\Configure;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Log\Log;


/**
 * Users Controller
 *
 * @property UsersTable $Users
 */
class ProfilesController extends AppController
{
    use LoginTrait;
    use ProfileTrait;
    use ReCaptchaTrait;
    use RegisterTrait;
    use SimpleCrudTrait;
    use SocialTrait;
    use ResignTrait;
    
    public $paginate = [
        // その他のキーはこちら
        'maxLimit' => 5
    ];
    
    public $components = ['RequestHandler', 'CatsCommon', 'NekoUtil', 'NotificationManager'];
    
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
         //TODO: きっとやり方違う
        if($this->Auth->user()){
            $this->Auth->allow();
        }else{
            $this->Auth->allow(['user','thumbnail','image', 'uploadAvatar', 'avatar', 'registration']);
        }
        
        // $this->eventManager()->on(UsersAuthComponent::EVENT_AFTER_LOGOUT, function ($e) {
            
        // }
    }
    
    public function edit(){
        $user = $this->CatsCommon->currentUser();
        
        $this->Users = TableRegistry::get('Users');
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
          
            if ($this->Users->save($user)) {
                $this->Flash->success(__('ユーザ情報を保存しました'));
                return $this->redirect(['action' => 'user']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user', 'user'));
        $this->set('_serialize', ['user']);
        
    }
    
    public function withdrawal(){
        return $this->resign();
    }
    
    public function uploadAvatar(){
        
        if ($this->request->is('ajax')) {
            $img = $this->request->data['data'];
            
            $img = str_replace('data:image/jpeg;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);
            //saving
            $fileName = TMP."/". $this->NekoUtil->generateUniqueFileName();
            file_put_contents($fileName, $fileData);
            
            $savePath = $this->NekoUtil->safeImage($fileName, TMP);
            if ($savePath === "") {
                die("不正な画像がuploadされました");
            }
            $url = $this->NekoUtil->s3Upload($savePath, '');
            // 書きだした画像を削除
            @unlink($savePath);
            
            //サムネイルを作成
            $savePath = $this->NekoUtil->createThumbnail($fileName, TMP);
            if ($savePath === "") {
                die("不正な画像がuploadされました");
            }
            $thumbnail = $this->NekoUtil->s3Upload($savePath, '');
            // 書きだした画像を削除
            @unlink($savePath);
            
            $uid = $this->Auth->user('id');
            
            $this->Avatars = TableRegistry::get('Avatars');
            $avatar = $this->Avatars->find('all')
            ->where([
                'users_id =' => $uid
            ])
            ->first();
            
            if($avatar === null){
                $avatar  = $this->Avatars->newEntity();
            }
            $avatar->users_id = $uid;
            $avatar->url = $url['ObjectURL'];
            $avatar->thumbnail = $thumbnail['ObjectURL'];
            if ($this->Avatars->save($avatar)) {
                // $this->Flash->success('プロファイル画像を保存しました');
            }
        }
    }
    
    public function avatar($username){
        $this->Users = TableRegistry::get('Users');
        $this->Avatars = TableRegistry::get('Avatars');
        $user = $this->Users->find('all')
        ->where([
            'username =' => $username
        ])
        ->first();
        
        $avatar = $this->Avatars->find('all')
        ->where([
            'users_id =' => $user->id
        ])
        ->first();

        $this->set(compact('avatar'));
        $this->set('_serialize', ['avatar']);
    }
    
    public function image($uid){ 
        $this->Avatars = TableRegistry::get('Avatars');
        $avatar = $this->Avatars->find('all')
        ->where([
            'users_id =' => $uid
        ])
        ->first();
        
        $this->autoRender = false;
        if($avatar !== null){
            print($avatar->url);
        }else{
            print("/tapatar/img/default.svg");
        }
    }
    
    public function thumbnail($uid){
        $this->Avatars = TableRegistry::get('Avatars');
        $avatar = $this->Avatars->find('all')
        ->where([
            'users_id =' => $uid
        ])
        ->first();
        
        $this->autoRender = false;
        
        if($avatar !== null){
            print($avatar->thumbnail);
        }else{
            print("/tapatar/img/default.svg");
        }
    }
    
    public function user($username = null){
        $this->Users = TableRegistry::get('Users');
        $user = $this->Users->find('all')
        ->where([
            'username =' => $username
        ])
        ->first();
        
        $this->Avatars = TableRegistry::get('Avatars');
        $avatar = $this->Avatars->find('all')
        ->where([
            'users_id ='=> $user->id
        ])
        ->first();
        
        $this->set(compact('avatar'));
        $this->set('_serialize', ['avatar']);
        
        $this->profile($user->id);
        $data = $this->CatsCommon->listCats($user->id, null);
        $cats = $this->paginate($data);

        $this->set(compact('cats'));
        $this->set('_serialize', ['cats']);
        
    }
    
     /**
     * Register a new user
     *
     * @throws NotFoundException
     * @return type
     */
    public function registration()
    {
        $this->eventManager()->on(UsersAuthComponent::EVENT_AFTER_REGISTER, function ($e) {
            $session = $this->request->session();
            $cat = $session->read('Last.Submit.Cat.Data');
            if(!is_null($cat)){
                $this->Cats = TableRegistry::get('Cats');
                $cat->users_id = $e->data['user']->id;
                if ( $this->Cats->save($cat)) {
                    $this->Flash->success('登録前に投稿した猫を保存しました');
                }
                $session->delete('Last.Submit.Cat.Data');
                $session->delete('Last.Submit.Cat.Shown');
            }
        });
        
        return $this->register();
       
    }
    
    public function notifications($limit=0){
        if($limit <=0)
            $unreadOnly = false;
        else
            $unreadOnly = true;
            
        $notifications = $this->NotificationManager->notifications($this->CatsCommon->currentUser()->id, $limit, $unreadOnly);  
        
        $this->set(compact('notifications'));
        $this->set('_serialize', ['notifications']);
    }
    
    public function markRead($id){
        $this->NotificationManager->markRead($id);  
    }
    
    public function countUnread(){
         $count = $this->NotificationManager->countUnread($this->CatsCommon->currentUser()->id);  
        
        $this->set(compact('count'));
        $this->set('_serialize', ['count']);
    }
    
    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);
        $this->viewBuilder()->layout('nekoderu');
    }

    public function archivements($id){
    
        $this->Users = TableRegistry::get('Users');
        $this->Archives = TableRegistry::get('Archives');
        $this->Cats = TableRegistry::get('Cats');
        $this->Comments = TableRegistry::get('Comments');
        $this->Favorites = TableRegistry::get('Favorites');
        $this->Notifications = TableRegistry::get('Notifications');
   
       
        $pushCount = $this->Cats->find('all')->select(['id'])->where(['users_id =' => $this->Auth->user('id')])->count();
        $commentsCount = $this->Comments->find('all')->select(['id'])->where(['users_id =' => $this->Auth->user('id')])->count();
        $favoritesCount = $this->Favorites->find('all')->select(['id'])->where(['users_id =' => $this->Auth->user('id')])->count();
        $popularCount = $this->Notifications->find('all')->select(['id'])->where(['users_id =' => $this->Auth->user('id'),'title =' => "あなたの猫ちゃんに「いいね」がありました！"])->count();
        // $dateCount = $today->diff($this->Users->find('all')->select(['activation_date'])->where(['users_id =' => $this->Auth->user('id')]));
      
        
       
    

      
      
        $pushData = $this->Archives->find('all',array('order' => array('requirements ASC')))->where(['requirements >' => $pushCount ])->where(['types =' => 'push'])->first();
        $commentsData = $this->Archives->find('all',array('order' => array('requirements ASC')))->where(['requirements >' => $commentsCount ])->where(['types =' => 'comments'])->first();
        $favoritesData = $this->Archives->find('all',array('order' => array('requirements ASC')))->where(['requirements >' => $favoritesCount ])->where(['types =' => 'favorites'])->first();
        $popularData = $this->Archives->find('all',array('order' => array('requirements ASC')))->where(['requirements >' => $popularCount ])->where(['types =' => 'popular'])->first();
        
        $pushArchives = $this->Archives->find('all',array('order' => array('requirements ASC')))->where(['requirements <=' => $pushCount ])->where(['types =' => 'push']);
        $commentsArchives = $this->Archives->find('all',array('order' => array('requirements ASC')))->where(['requirements <=' => $commentsCount ])->where(['types =' => 'comments']);
        $favoritesArchives = $this->Archives->find('all',array('order' => array('requirements ASC')))->where(['requirements <=' => $favoritesCount ])->where(['types =' => 'favorites']);
        $popularArchives = $this->Archives->find('all',array('order' => array('requirements ASC')))->where(['requirements <=' => $popularCount ])->where(['types =' => 'popular']);
        $otherArchives = $this->Archives->find('all',array('order' => array('requirements ASC')))->where(['requirements <=' => $otherCount ])->where(['types =' => 'other']);
        
        if($id==0){$archives = $this->Archives->find('all');}
        else if($id==1){$archives = $this->Archives->find('all',array('order' => array('requirements ASC')))->where(['types =' => 'push']);$counts=$pushCount;}
        else if($id==2){$archives = $this->Archives->find('all',array('order' => array('requirements ASC')))->where(['types =' => 'comments']);$counts=$commentsCount;}
        else if($id==3){$archives = $this->Archives->find('all',array('order' => array('requirements ASC')))->where(['types =' => 'favorites']);$counts=$favoritesCount;}
        else if($id==4){$archives = $this->Archives->find('all',array('order' => array('requirements ASC')))->where(['types =' => 'popular']);$counts=$popularCount;}
        else if($id==5){$archives = $this->Archives->find('all',array('order' => array('requirements ASC')))->where(['types =' => 'date']);$counts=$dateCount;}
       
    
        $this->set(compact('pushCount'));$this->set('_serialize', ['pushCount']);
        $this->set(compact('commentsCount'));$this->set('_serialize', ['commentsCount']);
        $this->set(compact('favoritesCount'));$this->set('_serialize', ['favoritesCount']);
        $this->set(compact('popularCount'));$this->set('_serialize', ['popularCount']);
        $this->set(compact('otherCount'));$this->set('_serialize', ['otherCount']);
        
        $this->set(compact('pushData'));$this->set('_serialize', ['pushData']);
        $this->set(compact('commentsData'));$this->set('_serialize', ['commentsData']);
        $this->set(compact('favoritesData'));$this->set('_serialize', ['favoritesData']);
        $this->set(compact('popularData'));$this->set('_serialize', ['popularData']);
        $this->set(compact('otherData'));$this->set('_serialize', ['otherData']);
        
        $this->set(compact('pushArchives'));$this->set('_serialize', ['pushArchives']);
        $this->set(compact('commentsArchives'));$this->set('_serialize', ['commentsArchives']);
        $this->set(compact('favoritesArchives'));$this->set('_serialize', ['favoritesArchives']);
        $this->set(compact('popularArchives'));$this->set('_serialize', ['popularArchives']);
        $this->set(compact('otherArchives'));$this->set('_serialize', ['otherArchives']);
        
        $this->set(compact('counts'));$this->set('_serialize', ['counts']);
        $this->set(compact('archives'));$this->set('_serialize', ['archives']);
        $this->set(compact('id'));$this->set('_serialize', ['id']);
       
        
        
        //称号設定
        // $users = $this-> Users->get($this->Auth->user('id'));
        // if($id!=null){
        //         $users->archives_id = $id;
        //         $this->Users->save($users);
        // }
        // $now = $this->Archives->find('all')->select(['reward'])->where(['id =' => $users->archives_id]);
        // $this->set(compact('now'));
        // $this->set('_serialize', ['now']);
        
    }
    
    
}
