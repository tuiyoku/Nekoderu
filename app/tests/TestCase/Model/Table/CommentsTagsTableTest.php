<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CommentsTagsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CommentsTagsTable Test Case
 */
class CommentsTagsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CommentsTagsTable
     */
    public $CommentsTags;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.comments_tags',
        'app.comments',
        'app.users',
        'app.cats',
        'app.cat_images',
        'app.favorites',
        'app.answers',
        'app.questions',
        'app.response_statuses',
        'app.tags',
        'app.cats_tags'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('CommentsTags') ? [] : ['className' => 'App\Model\Table\CommentsTagsTable'];
        $this->CommentsTags = TableRegistry::get('CommentsTags', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CommentsTags);

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
