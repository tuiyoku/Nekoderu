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

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    
    use \Crud\Controller\ControllerTrait;
    
    public $components = ["Cookie"];
    
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('CakeDC/Users.UsersAuth');

        $this->loadComponent('Crud.Crud', [
            'actions' => [
                'Crud.Index',
                'Crud.View',
                'Crud.Add',
                'Crud.Edit',
                'Crud.Delete',
//                'Crud.Lookup',
            ],
            'listeners' => [
                'Crud.Api',
                'Crud.ApiPagination',
                'Crud.ApiQueryLog',
                'CrudView.View',
                'Crud.Redirect',
                'Crud.RelatedModels',
            ]
        ]);
        
        // $this->loadComponent('Security', ['blackHoleCallback' => 'forceSSL']);
      
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
       
        //TODO:フレンドリーログインの実装 
        // $this->storeRedirectPath();
       
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
        
        $this->log($this->Auth->user());
        $this->set('auth', $this->Auth->user());
        
       
    }
    
    private function storeRedirectPath() {
        $current_path = Router::url();
        if ( !in_array($current_path, [
                '/login',     // ログインページ
                '/profiles/registration'   // ユーザー登録ページ  
            ])
        ) {
            $this->request->session()->write('Auth.redirect', $current_path);
        }
    }
    
    public function beforeFilter(Event $event) 
    {
        parent::beforeFilter($event); 
        // $this->Security->requireSecure();
        
        $this->set('cookieHelper', $this->Cookie);
    }
    
    // public function forceSSL()
    // {
    //     return $this->redirect('https://' . env('SERVER_NAME') . $this->request->here);
    // }
}
