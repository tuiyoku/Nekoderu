<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CatsTagsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CatsTagsTable Test Case
 */
class CatsTagsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CatsTagsTable
     */
    public $CatsTags;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cats_tags',
        'app.cats',
        'app.cat_images',
        'app.users',
        'app.favorites',
        'app.comments',
        'app.tags',
        'app.comments_tags',
        'app.answers',
        'app.questions',
        'app.response_statuses'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('CatsTags') ? [] : ['className' => 'App\Model\Table\CatsTagsTable'];
        $this->CatsTags = TableRegistry::get('CatsTags', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CatsTags);

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
