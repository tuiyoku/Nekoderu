<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;

/**
 * Users Controller
 *
 * @property UsersTable $Users
 */
class PolicyController extends AppController
{

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['index', 'policy', 'encourage', 'contact']);
    }

    public function index(){
        $this->viewBuilder()->layout("nekoderu");
    }

    public function contact()
    {
        if ($this->request->is('post') && $this->request->data) {
            $this->sendContact($this->request->data);
            $this->Flash->success('お問い合わせを受け付けました。');
        }
        $this->viewBuilder()->layout("nekoderu");
    }

    private function sendContact($content)
    {
        $email = new Email('production');
        $email->viewVars($content);
        $email->template("contact", "contact");
        $email->subject("Nekoderuにお問合せがありました");
        $email->to(['stagesp1+nekoderu@gmail.com', 'kei4eva4@gmail.com']);
        $email->send();
    }
    
    public function policy(){
        $this->viewBuilder()->layout("plain");
    }
    
     public function encourage(){
        
        $this->viewBuilder()->layout("plain");
    }
}
