<?php

namespace App\Controller\Component;
use Cake\Controller\Component;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class CatsCommonComponent extends Component {
    
    // public $components = ["Cookie"];
    
    public function listCats($users_id = null, $order = null){
        $this->Cats = TableRegistry::get('Cats');
        
        // $this->Cookie->write("Order.Preference", $order);
        if($order == null)
            $order = "popular";
        
        if($order === "popular"){
            $query = $this->Cats->find('all');
            $query ->leftJoinWith('Favorites')
                // ->leftJoinWith('Comments')
                ->select($this->Cats)
                ->select($this->Cats->Users)
                ->select(['count' => $query->func()->count('Favorites.id')])
                // ->select(['count2' => $query->func()->count('Comments.id')])
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
                ->group('Cats.id')
                ->order(['count' => 'DESC'])
                ;
                
                // debug($query->first());
        } else if($order === "commented") {
            $query = $this->Cats->find('all');
            $query 
                // ->leftJoinWith('Favorites')
                ->leftJoinWith('Comments')
                ->select($this->Cats)
                ->select($this->Cats->Users)
                // ->select(['count' => $query->func()->count('Favorites.id')])
                ->select(['last' => $query->func()->max('Comments.created')])
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
                ->group('Cats.id')
                ->order(['last' => 'DESC'])
                ;
                
                // debug($query->first());
        } else if($order === "recent")  { 
            $query = $this->Cats->find('all')
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
        }
            
        if(!is_null($users_id)){ 
            $query = $query ->where([
                'Users.id =' => $users_id
            ]);
        }
        
        return $query;
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