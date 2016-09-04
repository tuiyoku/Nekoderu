<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

use Cake\ORM\TableRegistry;
use Cake\Controller\Controller;
use Cake\Event\Event;


/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
    
    public $components = ['NekoUtil'];

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['index', 'addNeko', 'display']);
    }
    
    /**
     * Displays a view
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
    public function display()
    {
        $path = func_get_args();

        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));

    
        try {
            $this->render(implode('/', $path));
        } catch (MissingTemplateException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }
    }

    public function index()
    {
        $this->viewBuilder()->layout('nekoderu');

        $now = time();
        $from_time = 1460559600;

        $this->set(compact('now', 'from_time'));
    }

    // public function addNeko()
    // {
    //     $this->viewBuilder()->layout('nekoderu');

    //     if ($this->request->is('post')) {

    //         $data = $this->request->data;
            

    //         $err = "";

    //         $time = time();
    //         $locate = (string)$data['locate'];
    //         $comment = (string)$data['comment'];
    //         $ear_shape = $data['ear_shape'];
            
    //         if ($err === "") {
    //             $image_url = "";
                
    //             if (isset($data["image"]) && $data["image"].length > 0 && is_uploaded_file($data["image"]["tmp_name"])) {
    //                 // アップロード処理
    //                 $file = $data["image"];

    //                 $savePath = $this->NekoUtil->safeImage($file["tmp_name"], TMP);
    //                 if ($savePath === "") {
    //                     die("不正な画像がuploadされました");
    //                 }
                 
    //                 $result = $this->NekoUtil->s3Upload($savePath, '');

    //                 // 書きだした画像を削除
    //                 @unlink($savePath);

    //                 if ($result) {
    //                     $image_url = $result['ObjectURL'];
    //                 }
    //             }
                
    //             $query = array(
    //                 "latlng" => h($locate),
    //                 "language" => "ja",
    //                 "sensor" => false
    //             );
    //             $res = $this->NekoUtil->callApi("GET", "https://maps.googleapis.com/maps/api/geocode/json", $query);

    //             $address = $res["results"][0]["formatted_address"];

    //             $query = TableRegistry::get('Cats')->query();
    //             $query->insert(['time', 'locate', 'comment', 'ear_shape', 'image_url', 'address', 'flg'])
    //                 ->values([
    //                     "time" => $time,
    //                     "locate" => $locate,
    //                     "comment" => $comment,
    //                     "image_url" => $image_url,
    //                     "address" => $address,
    //                     "ear_shape" => $ear_shape,
    //                     "flg" => 4,
    //                 ])
    //                 ->execute();
    //         }
            
    //         return $this->redirect('/');
    //     }
    //
    // }

}
