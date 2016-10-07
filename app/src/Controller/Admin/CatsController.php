<?php

namespace App\Controller\Admin;

use Cake\Controller\Controller;
use Cake\Event\Event;

class CatsController extends \App\Controller\AppController
{
    public $components = array('NekoUtil');
    
    public function index()
    {
        $data = $this->Cats->find('all')
            ->contain(['CatImages', 'Comments']);
            
        $cats = $this->paginate($data);
        
        $this->set(compact('cats'));
        $this->set('_serialize', ['cats']);
    }
    
    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['index']);
    }

}