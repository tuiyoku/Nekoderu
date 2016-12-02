<?php
namespace App\Controller\Api;

use App\Controller\Api\AppController;

class CatsController extends AppController
{
    
    public $components = [ 'CatsCommon' ];
    
    public $paginate = [
        'page' => 1,
        'limit' => 5,
        'maxLimit' => 15,
        'sortWhitelist' => [
            'id', 'name'
        ]
    ];
    
    public function add()
    {
        debug("dummy");
        exit;
    }
    
    public function addSheltered()
    {
        $this->CatsCommon->add(2, "#保護してます"); // 2 - 保護してます
    }
    
    public function addSearching()
    {
        $this->CatsCommon->add(1, "#迷子猫探してます"); // 1 - 迷子猫探してます
    }
}