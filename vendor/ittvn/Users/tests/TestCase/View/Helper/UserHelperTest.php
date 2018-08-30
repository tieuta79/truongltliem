<?php
namespace Users\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use Users\View\Helper\UserHelper;

/**
 * Users\View\Helper\UserHelper Test Case
 */
class UserHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Users\View\Helper\UserHelper
     */
    public $User;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->User = new UserHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->User);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
