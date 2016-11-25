<?php
namespace App\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use App\Controller\CatsController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\CatsController Test Case
 */
class CatsControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cats'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
         $this->get('/cats');

        $this->assertResponseOk();
        // 他のアサート
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->get('/cats/view/1');

        $this->assertResponseOk();
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $data = [
            'user_id' => '',
            'locate' => '32.79958,130.70033569999998',
            'address' => '日本, 〒860-0805 熊本県熊本市中央区桜町２−３２',
            'ear_shape' => 2,
            'comment' => 'これはコメントです',
            
        ];
        $this->post('/cats/add', $data);

        $this->assertResponseSuccess();
        $cats = TableRegistry::get('Cats');
        $query = $cats->find('all');
        $this->assertEquals(1, $query->count());
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
