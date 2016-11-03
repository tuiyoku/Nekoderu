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
use CakeDC\Users\Model\Table\UsersTable;
use Cake\Core\Configure;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

use App\Controller\AppController;
use Cake\Event\Event;

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
    
    public $paginate = [
        // その他のキーはこちら
        'maxLimit' => 5
    ];
    
    public $components = ['RequestHandler', 'CatsCommon', 'NekoUtil'];
    
    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['user','thumbnail','image', 'uploadAvatar', 'avatar']);
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
        $data = $this->CatsCommon->listCats($user->id);
        $cats = $this->paginate($data);

        $this->set(compact('cats'));
        $this->set('_serialize', ['cats']);
        
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

    
}
