<?php

namespace App\Controller\Admin;

use Cake\Controller\Controller;
use Cake\Event\Event;

class CatsController extends AdminAppController
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

}