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
        $this->Auth->allow(['index', 'policy']);
    }
    
    public function index(){
        $this->viewBuilder()->layout("nekoderu");
    }
    
    public function policy(){
        $this->viewBuilder()->autoLayout = false;
        $this->viewBuilder()->layout(null);
    }
}
