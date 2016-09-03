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
    public $components = ['NekoUtil'];

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
        $this->viewBuilder()->layout('nekoderu');
        $cats = $this->paginate($this->Cats);

        $this->set(compact('cats'));
        $this->set('_serialize', ['cats']);
    }


    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->layout('nekoderu');

        if ($this->request->is('post')) {

            $data = $this->request->data;
            
            // debug($this->request->data);

            $err = "";

            $time = time();
            $locate = (string)$data['locate'];
            $comment = (string)$data['comment'];
            $ear_shape = $data['ear_shape'];
            
            // ユーザーIDを付与
            $uid = 0;
            if(!is_null($this->Auth->user('id'))){
                $uid = $this->Auth->user('id');
            }
            
            if ($err === "") {
                $image_url = "";
                
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
                            // debug($result);
        
                            // 書きだした画像を削除
                            @unlink($savePath);
        
                            if ($result) {
                                $image_url .= $result['ObjectURL'].",";
                            }
                        }
                    }
                }
                // debug($image_url);
                
                $query = array(
                    "latlng" => h($locate),
                    "language" => "ja",
                    "sensor" => false
                );
                $res = $this->NekoUtil->callApi("GET", "https://maps.googleapis.com/maps/api/geocode/json", $query);

                $address = $res["results"][0]["formatted_address"];

                $query = TableRegistry::get('Cats')->query();
                $query->insert(['time', 'locate', 'comment', 'ear_shape', 'image_url', 'address', 'flg', 'user_id'])
                    ->values([
                        "time" => $time,
                        "locate" => $locate,
                        "comment" => $comment,
                        "image_url" => $image_url,
                        "address" => $address,
                        "ear_shape" => $ear_shape,
                        "flg" => 4,
                        "user_id" => $uid,
                    ])
                    ->execute();
            }
            
            return $this->redirect('/');
        }
    }

}
