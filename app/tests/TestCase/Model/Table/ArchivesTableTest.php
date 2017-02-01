<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ArchivesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ArchivesTable Test Case
 */
class ArchivesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ArchivesTable
     */
    public $Archives;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.archives'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Archives') ? [] : ['className' => 'App\Model\Table\ArchivesTable'];
        $this->Archives = TableRegistry::get('Archives', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Archives);

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
}
