<?php
namespace BannersManager\Test\TestCase\Model\Table;

use BannersManager\Model\Table\PositionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * BannersManager\Model\Table\PositionsTable Test Case
 */
class PositionsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'Positions' => 'plugin.banners_manager.positions',
        'Banners' => 'plugin.banners_manager.banners'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Positions') ? [] : ['className' => 'BannersManager\Model\Table\PositionsTable'];
        $this->Positions = TableRegistry::get('Positions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Positions);

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
