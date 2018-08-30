<?php
namespace Menus\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Menus\Model\Table\MenutypesTable;

/**
 * Menus\Model\Table\MenutypesTable Test Case
 */
class MenutypesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.menus.menutypes',
        'plugin.menus.menus',
        'plugin.menus.categories',
        'plugin.menus.contents'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Menutypes') ? [] : ['className' => 'Menus\Model\Table\MenutypesTable'];
        $this->Menutypes = TableRegistry::get('Menutypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Menutypes);

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
