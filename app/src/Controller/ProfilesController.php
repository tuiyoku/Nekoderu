<?php
namespace App\Controller;

use CakeDC\Users\Controller\AppController;
use CakeDC\Users\Controller\Component\UsersAuthComponent;
use CakeDC\Users\Controller\Traits\LoginTrait;
use CakeDC\Users\Controller\Traits\ProfileTrait;
use CakeDC\Users\Controller\Traits\ReCaptchaTrait;
use CakeDC\Users\Controller\Traits\RegisterTrait;
use CakeDC\Users\Controller\Traits\SimpleCrudTrait;
use CakeDC\Users\Controller\Traits\SocialTrait;
use CakeDC\Users\Model\Table\UsersTable;
use Cake\Core\Configure;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

/**
 * Users Controller
 *
 * @property UsersTable $Users
 */
class ProfilesController extends AppController
{
    use LoginTrait;
    use ProfileTrait;
    use ReCaptchaTrait;
    use RegisterTrait;
    use SimpleCrudTrait;
    use SocialTrait;
    
    public $paginate = [
        // その他のキーはこちら
        'maxLimit' => 5
    ];
    
    public $components = ['CatsCommon'];
    
    public function user($username = null){
        $this->Users = TableRegistry::get('Users');
        $user = $this->Users->find('all')
        ->where([
            'username =' => $username
        ])
        ->first();
        
        $this->profile($user->id);
        $data = $this->CatsCommon->listCats($user->id);
        $cats = $this->paginate($data);

        $this->set(compact('cats'));
        $this->set('_serialize', ['cats']);
        
        
    }
    
}
