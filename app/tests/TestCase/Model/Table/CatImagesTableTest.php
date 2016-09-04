<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CatImagesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CatImagesTable Test Case
 */
class CatImagesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CatImagesTable
     */
    public $CatImages;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cat_images',
        'app.cats'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('CatImages') ? [] : ['className' => 'App\Model\Table\CatImagesTable'];
        $this->CatImages = TableRegistry::get('CatImages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CatImages);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
