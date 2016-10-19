<?php
namespace App\Controller;

use Cake\ORM\TableRegistry;
use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Cats Controller
 *
 * @property \App\Model\Table\CatsTable $Cats
 */
class CatsController extends AppController
{
    
    public $components = ['NekoUtil', 'RequestHandler'];

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['index', 'add', 'view', 'data', 'grid', 'addComment', 'comments']);
    }
    
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        
        $q = $this->request->query;
        
        $data = $this->Cats->find('all')
            ->contain(['CatImages', 'Comments', 'Users']);
        if($q != null){
            $data = $data
                ->where(['created >' => new \DateTime($q['map_start'])])
                ->where(['Cats.created <' => new \DateTime($q['map_end'])]);
        }
        $cats = $this->paginate($data);

        $this->set(compact('cats'));
        $this->set('_serialize', ['cats']);
    }
    
        /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function grid()
    {
        
        $q = $this->request->query;
        
        $query = $this->Cats->find('all')
            ->contain(['CatImages', 'Comments', 'Users']);
        if($q != null){
            $query = $query
                ->where(['created >' => new \DateTime($q['map_start'])])
                ->where(['Cats.created <' => new \DateTime($q['map_end'])]);
        }
        $cats = $query; //$this->paginate($data);

        $this->set(compact('cats'));
        $this->set('_serialize', ['cats']);
    }
    
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function data()
    {
        
        $q = $this->request->query;
        
        $data = $this->Cats->find('all')->contain([
                'CatImages', 
                'Comments' => function($q) {
                    return $q
                        ->order('created DESC')
                        ->limit(5);
                }
        ]);
        if($q != null){
            $data = $data
                ->where(['created >' => new \DateTime($q['map_start'])])
                ->where(['Cats.created <' => new \DateTime($q['map_end'])]);
        }
        $cats = $this->paginate($data);

        $this->set(compact('cats'));
        $this->set('_serialize', ['cats']);
    }
    
    public function view($id = null)
    {
        
        $cat = $this->Cats->get($id, [
            'contain' => ['CatImages', 'Comments', 'Users']
        ]);

        $this->set('cat', $cat);
        $this->set('_serialize', ['cat']);
    }



    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->CatImages = TableRegistry::get('CatImages');
        
        if ($this->request->is('post')) {

            $data = $this->request->data;
            
            $this->log($this->request->data);

            $time = time();
            $locate = (string)$data['locate'];
            $comment = (string)$data['comment'];
            $ear_shape = $data['ear_shape'];
            
            // ユーザーIDを付与
            $uid = 0;
            if(!is_null($this->Auth->user('id'))){
                $uid = $this->Auth->user('id');
            }
            
            $query = array(
                "latlng" => h($locate),
                "language" => "ja",
                "sensor" => false
            );
            
            $res = $this->NekoUtil->callApi("GET", "https://maps.googleapis.com/maps/api/geocode/json", $query);
            if(count($res["results"])>0)
                $address = $res["results"][0]["formatted_address"];
            else
                $address = "";

            $cat = $this->Cats->newEntity();
            $cat->locate = $locate;
            $cat->address = $address;
            $cat->ear_shape = $ear_shape;
            $cat->flg = 4;
            $cat->user_id = $uid;
            if ($this->Cats->save($cat)) {
                $this->Flash->success('猫を保存しました。');
            }
            
            $commentDO = $this->Cats->Comments->newEntity();
            $commentDO->comment = $comment;
            $commentDO->users_id = $uid;
            $commentDO->cats_id = $cat->id;
            if ($this->Cats->Comments->save($commentDO)) {
                // $this->Flash->success('コメントを保存しました。');
            }
           
            if (isset($data["image"])) {
                for($i=0; $i<count($data["image"]); $i++){
                    if(is_uploaded_file($data["image"][$i]["tmp_name"])){
                    
                        // アップロード処理
                        $file = $data["image"][$i];
    
                        $savePath = $this->NekoUtil->safeImage($file["tmp_name"], TMP);
                        if ($savePath === "") {
                            die("不正な画像がuploadされました");
                        }
                     
                        $result = $this->NekoUtil->s3Upload($savePath, '');
                        // 書きだした画像を削除
                        @unlink($savePath);
    
                        if ($result) {
                            
                            $catImage = $this->Cats->CatImages->newEntity();
                            $catImage->url = $result['ObjectURL'];
                            $catImage->users_id = $uid;
                            $catImage->cats_id = $cat->id;
                            if ($this->Cats->CatImages->save($catImage)) {
                                // $this->Flash->success('画像を保存しました。');
                            }
                        }
                    }
                }
            }
            
            return $this->redirect('/');
        }
    }
    
    public function comments($cats_id){
        
        if ($this->request->is('ajax')) {
            if(isset($this->request->data['limit'])){
                $limit = $this->request->data['limit'];
            }else{
                $limit = 20;
            }
            
            $comments = $this->Cats->Comments
                ->find('all', ['order' => ['Comments.created' => 'DESC']])
                ->where(['Comments.cats_id =' => $cats_id])
                ->contain(['Users'])
                ->limit(20)
                ->all();
        
            $this->set(compact('comments'));
            $this->set('_serialize', ['comments']);
            
        }
        
    }
    
    public function addComment(){
            
        if ($this->request->is('ajax')) {
            
            $param = $this->request->data['data'];
            parse_str($param, $data);
            
            $comment = $data['comment'];
            $cat_id = $data['cat_id'];
            
            // ユーザーIDを付与
            $uid = 0;
            if(!is_null($this->Auth->user('id'))){
                $uid = $this->Auth->user('id');
            }else{
                return;
            }
            
            $commentDO = $this->Cats->Comments->newEntity();
            $commentDO->comment = $comment;
            $commentDO->cats_id = $cat_id;
            $commentDO->users_id = $uid;
            if ($this->Cats->Comments->save($commentDO)) {
                // $this->Flash->success('コメントを保存しました。');
            }
            
            $comments = $this->Cats->Comments
                ->find('all', ['order' => ['Comments.created' => 'DESC']])
                ->where(['Comments.cats_id =' => $cat_id])
                ->contain(['Users'])
                ->limit(20)
                ->all();
                
            $this->log($comments);
        
            $this->set(compact('comments'));
            $this->set('_serialize', ['comments']);
        }
        
       
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
