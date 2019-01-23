<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConnectsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ConnectsTable Test Case
 */
class ConnectsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ConnectsTable
     */
    public $Connects;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        $config = TableRegistry::getTableLocator()->exists('Connects') ? [] : ['className' => ConnectsTable::class];
        $this->Connects = TableRegistry::getTableLocator()->get('Connects', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Connects);

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
