<?php
namespace App\Controller\Traits;

use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;

/**
 * Impersonate Trait
 */
trait ResignTrait
{
    /**
     * Adding a new feature as an example: Impersonate another user
     *
     * @param type $userId
     */
    public function resign()
    {
        $uid = $this->Auth->user()['id'];
        if(!empty($uid)){
            $this->Users = TableRegistry::get('Users');
            $user = $this->Users->get($uid);
            
            if ($this->Users->delete($user))  {
                $this->Flash->success(__('退会しました'));
            } else {
                $this->Flash->error(__('退会に失敗しました。お手数ですがお問い合わせフォームよりご連絡ください。'));
            }
        }
        return $this->redirect('/');
    }
}