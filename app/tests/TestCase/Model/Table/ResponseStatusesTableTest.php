<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResponseStatusesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResponseStatusesTable Test Case
 */
class ResponseStatusesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ResponseStatusesTable
     */
    public $ResponseStatuses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        $config = TableRegistry::exists('ResponseStatuses') ? [] : ['className' => 'App\Model\Table\ResponseStatusesTable'];
        $this->ResponseStatuses = TableRegistry::get('ResponseStatuses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ResponseStatuses);

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
