<?php
namespace Contents\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Contents\Model\Table\CategoryContentsTable;

/**
 * Contents\Model\Table\CategoryContentsTable Test Case
 */
class CategoryContentsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.contents.category_contents',
        'plugin.contents.contents',
        'plugin.contents.meta_types',
        'plugin.contents.content_metas',
        'plugin.contents.categories',
        'plugin.contents.meta_categories',
        'plugin.contents.category_metas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('CategoryContents') ? [] : ['className' => 'Contents\Model\Table\CategoryContentsTable'];
        $this->CategoryContents = TableRegistry::get('CategoryContents', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CategoryContents);

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
