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
use Aws\S3\S3Client;
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

    public function addNeko()
    {
        $this->viewBuilder()->layout('nekoderu');

        if ($this->request->is('post')) {

            $data = $this->request->data;
            

            $err = "";

            $time = time();
            $locate = (string)$data['locate'];
            $comment = (string)$data['comment'];
            $ear_shape = $data['ear_shape'];
            
            if ($err === "") {
                $image_url = "";
                
                if (isset($data["image"]) && $data["image"].length > 0 && is_uploaded_file($data["image"]["tmp_name"])) {
                    // アップロード処理
                    $file = $data["image"];

                    $savePath = $this->safeImage($file["tmp_name"], TMP);
                    if ($savePath === "") {
                        die("不正な画像がuploadされました");
                    }
                 
                    $result = $this->s3Upload($savePath, '');

                    // 書きだした画像を削除
                    @unlink($savePath);

                    if ($result) {
                        $image_url = $result['ObjectURL'];
                    }
                }
                
                $query = array(
                    "latlng" => h($locate),
                    "language" => "ja",
                    "sensor" => false
                );
                $res = $this->callApi("GET", "https://maps.googleapis.com/maps/api/geocode/json", $query);

                $address = $res["results"][0]["formatted_address"];

                $query = TableRegistry::get('Cats')->query();
                $query->insert(['time', 'locate', 'comment', 'ear_shape', 'image_url', 'address', 'flg'])
                    ->values([
                        "time" => $time,
                        "locate" => $locate,
                        "comment" => $comment,
                        "image_url" => $image_url,
                        "address" => $address,
                        "ear_shape" => $ear_shape,
                        "flg" => 4,
                    ])
                    ->execute();
            }
            
            return $this->redirect('/');
        }

    }

    /**
     *
     * CurlでAPIを叩きます。
     * @param            $method
     * @param            $url
     * @param bool|false $data
     *
     * @return mixed
     */
    function callApi($method, $url, $data = false){
        $curl = curl_init();

        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return json_decode($result, true);
    }

    // 拡張子を取得する
    function extension($filename) {
        $str = strrchr($filename, '.');
        if ($str === FALSE) {
            return NULL;
        } else {
            return substr($str, 1);
        }
    }

    function s3Upload($file, $s3Dir) {
        $ext = $this->extension($file);
        $srcPath = $file;

        $timestamp = uniqid();
        $name = $timestamp . "_file." . $ext;
        
        $s3 = new S3Client([
            'version'     => getenv('AWS_BUCKET_VERSION'),
            'region'      => getenv('AWS_BUCKET_REGION'),
            'credentials' => [
                'key'    => getenv('AWS_BUCKET_KEY'),
                'secret' => getenv('AWS_BUCKET_SECRET')
            ]
        ]);

        try {
            // Upload a file.
            $result = $s3->putObject(array(
                'Bucket'       => getenv('AWS_BUCKET_NAME'),
                'Key'        => $name,
                'SourceFile' => $srcPath,
                'ACL'          => 'public-read',
            ));

            return $result;
        }catch (\RuntimeException $e){
            throw $e;
        }

    }

    /**
     * 一度画像を別の形式に変換し、jpg形式に変換する
     * TODO: @utsumi-k PHP Parserを使うかは場合は別途用意する
     * @param $orgFilePath
     * @param $exportFilePath
     *
     * @return string
     */
    function safeImage($orgFilePath, $exportFilePath) {
        // 書き出しファイル名を生成
        $outputFilePath = $exportFilePath . "/" . $this->generateUniqueFileName();

        // 元画像情報を取得
        $size = getimagesize($orgFilePath);
        if ($size === false) {
            // 画像として認識できなかった
            return "";
        }
        list($w, $h, $type) = $size;
        list($width, $height) = $this->getSaveFileSize($w, $h);

        // 1回最初にリサイズする
        $res = new \Imagick($orgFilePath);
        if (!$res->thumbnailImage($width, $height, true, true)) {
            // リサイズ失敗
            return "";
        }

        if ($type == IMG_JPEG) {
            // 一度pngにする
            if (!$res->setImageFormat('png')) {
                // 1回PNGに出来なかった
                return "";
            }
        }
        // 問題なかったのでjpgにしましょう。
        if (!$res->setImageFormat("jpg")) {
            // JPGへの変換失敗
            return "";
        }
        if (!$res->writeImage($outputFilePath)) {
            // 書き込み失敗
            return "";
        }

        return $outputFilePath;
    }

    /**
     * Uniqueなファイル名を生成する
     * TODO: 絶対かぶらない保証もないし、非同期で保存されるけど、今んとこそこは危惧するレベルではないと判断
     * @return string
     */
    function generateUniqueFileName() {
        return md5(uniqid(rand(),1)) . ".jpg";
    }


    /**
     * 保存するサイズを計算する
     * 960*540 までのサイズにする
     * @param $orgWidth
     * @param $orgHeight
     *
     * @return array
     */
    function getSaveFileSize($orgWidth, $orgHeight) {
        $maxWidth = 960;
        $maxHeight = 540;
        $w = $orgWidth;
        $h = $orgHeight;

        if ($orgWidth > $maxWidth || $orgHeight > $maxHeight) {
            // リサイズ必要
            if ($orgWidth > $orgHeight) {
                // 横長
                $rate = $maxWidth / $orgWidth;

            } elseif ($orgHeight > $orgWidth) {
                // 縦長
                $rate = $maxHeight / $orgHeight;
            } else {
                // 正方形
                $rate = $maxHeight / $orgHeight;
            }
            $w = (int)($orgWidth * $rate);
            $h = (int)($orgHeight * $rate);
        }
        return [$w,$h];
    }
}
