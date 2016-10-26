<?php

namespace App\Controller\Component;
use Cake\Controller\Component;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class CatsCommonComponent extends Component {
   
    public function listCats($users_id = null){
        $this->Cats = TableRegistry::get('Cats');
        $data = $this->Cats->find('all')
            ->contain(['CatImages', 'Comments', 'Users', 'Favorites'])
            ->order(['Cats.created' => 'DESC']);
            
        if(!is_null($users_id)){ 
            $data = $data ->where([
                'Users.id =' => $users_id
            ]);
        }
        
        return $data;
    }
}