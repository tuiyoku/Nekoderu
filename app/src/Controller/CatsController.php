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
        $this->Auth->allow(['index', 'add']);
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
            ->contain('CatImages');
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
        $user = $this->Cats->get($id, [
            'contain' => []
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
        
        $this->viewBuilder()->layout('nekoderu');

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
            $cat->comment = $comment;
            $cat->address = $address;
            $cat->ear_shape = $ear_shape;
            $cat->flg = 4;
            $cat->user_id = $uid;
            if ($this->Cats->save($cat)) {
                $this->Flash->success('猫を保存しました。');
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
                            
                            $catImage = $this->CatImages->newEntity();
                            $catImage->url = $result['ObjectURL'];
                            $catImage->users_id = $uid;
                            $catImage->cats_id = $cat->id;
                            if ($this->CatImages->save($catImage)) {
                                $this->Flash->success('画像を保存しました。');
                            }
                        }
                    }
                }
            }
            
            return $this->redirect('/');
        }
    }

}
