<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Users Controller
 *
 * @property UsersTable $Users
 */
class PolicyController extends AppController
{
    
    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['index', 'policy', 'encourage']);
    }
    
    public function index(){
        $this->viewBuilder()->layout("nekoderu");
    }
    
      public function contact(){
        $this->viewBuilder()->layout("nekoderu");
    }
    
    public function policy(){
        $this->viewBuilder()->layout("plain");
    }
    
     public function encourage(){
        
        $this->viewBuilder()->layout("plain");
    }
}
