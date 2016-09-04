<?php

namespace App\Controller\Admin;

use Cake\Controller\Controller;
use Cake\Mailer\Email;
use Cake\Event\Event;

class CatsController extends \App\Controller\AppController
{
    public $components = array('NekoUtil');
    
    public function index()
    {
        $this->viewBuilder()->layout('default');
        // $this->Crud->on('beforePaginate', function($e) {
        //     $e->subject->query = $this->Cats->find(
        //         'search',
        //         $this->Cats->filterParams($this->request->query)
        //     );
        // });
        // return $this->Crud->execute();
        
        $cats = $this->paginate($this->Cats);
        
        $this->set(compact('cats'));
        $this->set('_serialize', ['cats']);
       
    }
    
    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['index', 'uploadImage']);
    }
    
    // /**
    //  * Before render callback.
    //  *
    //  * @param \Cake\Event\Event $event The beforeRender event.
    //  * @return void
    //  */
    // public function beforeRender(Event $event)
    // {
    //     if (!array_key_exists('_serialize', $this->viewVars) &&
    //         in_array($this->response->type(), ['application/json', 'application/xml'])
    //     ) {
    //         $this->set('_serialize', true);
    //     }

    //     if ($this->viewBuilder()->className() === null) {
    //         $this->viewBuilder()->className('CrudView\View\CrudView');
    //     }
    // }
}