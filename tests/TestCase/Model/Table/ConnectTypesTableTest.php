<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConnectTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ConnectTypesTable Test Case
 */
class ConnectTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ConnectTypesTable
     */
    public $ConnectTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ConnectTypes',
        'app.Connects'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ConnectTypes') ? [] : ['className' => ConnectTypesTable::class];
        $this->ConnectTypes = TableRegistry::getTableLocator()->get('ConnectTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ConnectTypes);

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
