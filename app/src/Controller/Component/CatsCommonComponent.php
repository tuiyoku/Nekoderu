<?php

namespace App\Controller\Component;
use Cake\Controller\Component;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class CatsCommonComponent extends Component {
    
   
    public function listCats($users_id = null){
        $this->Cats = TableRegistry::get('Cats');
        $data = $this->Cats->find('all')
            ->contain(['CatImages', 
            'Comments'=> function ($q) {
                return $q->order(['Comments.created' => 'DESC']);
            }, 
            'Users', 'Favorites', 
            'Answers'=> function ($q) {
               return $q
                    ->where([
                        'Questions.name =' => 'name'
                    ])
                    ->contain(['Questions']);
            }])
            ->where([
                'hidden =' => 0
            ])
            ->order(['Cats.created' => 'DESC']);
            
        if(!is_null($users_id)){ 
            $data = $data ->where([
                'Users.id =' => $users_id
            ]);
        }
        
        return $data;
    }
    
     public function listCatsByTag($tag){
        $this->Cats = TableRegistry::get('Cats');
        
        $this->Tags = TableRegistry::get('Tags');
            
        $data = $this->Cats->find('all')
        ->contain(['CatImages',  
        'Comments'=> function ($q) {
            return $q->order(['Comments.created' => 'DESC']);
        },  
        'Users', 'Favorites',
        'Answers'=> function ($q) {
          return $q
                ->where([
                    'Questions.name =' => 'name'
                ])
                ->contain(['Questions']);
        }])
        ->where([
            'hidden =' => 0
        ])
        ->matching('Tags', function ($q) use ($tag) {
            return $q->where(['Tags.tag =' => $tag]);
        })
        ->order(['Cats.created' => 'DESC']);
        
        return $data;
    }
}