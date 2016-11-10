<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Validation\Validator;

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

    public function index()
    {
        $this->viewBuilder()->layout("nekoderu");
    }

    public function contact()
    {
        if ($this->request->is('post') && $this->request->data) {

            $validator = new Validator();
            $validator
                ->requirePresence('email')
                ->notEmpty('name', 'メールアドレスは必須です。')
                ->add('email', 'validFormat', [
                    'rule' => 'email',
                    'message' => '正しいメールアドレスを入力してください。'
                ])
                ->requirePresence('name')
                ->notEmpty('name', 'お名前は必須です。')
                ->requirePresence('subject')
                ->notEmpty('subject', 'ご用件は必須です。')
                ->requirePresence('body')
                ->notEmpty('body', 'お問い合わせ内容は必須です。');

            $errors = $validator->errors($this->request->data);
            if (empty($errors)) {
                $this->sendContact($this->request->data);
                $this->Flash->success('お問い合わせを受け付けました。');
            } else {

                $errorMessages = [];
                array_walk_recursive($errors, function ($a) use (&$errorMessages) {
                    $errorMessages[] = $a;
                });

                $this->Flash->error('入力内容に不備があります。', ['params' => ['errors' => $errorMessages]]);
            }
        }
        $this->viewBuilder()->layout("nekoderu");
    }

    private function sendContact($content)
    {
        $email = new Email('production');
        $email->viewVars($content);
        $email->template("contact", "contact");
        $email->subject("Nekoderuにお問合せがありました");
        $email->to([env('CONTACT_TO')]);
        $email->send();
    }

    public function policy()
    {
        $this->viewBuilder()->layout("plain");
    }

    public function encourage()
    {

        $this->viewBuilder()->layout("plain");
    }
}
