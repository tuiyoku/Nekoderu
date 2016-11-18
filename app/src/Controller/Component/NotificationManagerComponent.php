<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class NotificationManagerComponent extends Component {
    
    public function initialize(array $config) {
        $this->Controller = $this->_registry->getController();
        $this->Notifications = TableRegistry::get("Notifications");
    }
   
   public function notify($users_id, $title, $description, $url){
       
       
       $notification = $this->Notifications->newEntity();
       $notification->title = $title;
       $notification->users_id = $users_id;
       $notification->description = $description;
       $notification->url = $url;
       $notification->unread = true;
       
       if($this->Notifications->save($notification)){
           // $this->Flash->success('通知を保存しました');
       }
   }
   
   public function notifications($users_id){
       
       return $this->Notifications
        ->find('all', ['order' => ['Notifications.created' => 'DESC']])
        ->where([
            'users_id =' => $users_id
        ])
        ->limit(50);
   }
   
   public function countUnread($users_id){
       
       return $this->Notifications
        ->find('all')
        ->where([
            'users_id =' => $users_id,
            'unread =' => true
        ])
        ->count();
   }
   
   public function markRead($id){
       $not = $this->Notifications->get($id);
       if($this->Controller->isCurrentUser($not->users_id)){
           $not->unread = false;
           if($this->Notifications->save($not)){
               // $this->Flash->success('通知を保存しました');
           }
       }
   }
}