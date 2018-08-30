<?php
namespace ItThemes\Test\TestCase\View\Cell;

use Cake\TestSuite\TestCase;
use ItThemes\View\Cell\ThemeCell;

/**
 * ItThemes\View\Cell\ThemeCell Test Case
 */
class ThemeCellTest extends TestCase
{

    /**
     * Request mock
     *
     * @var \Cake\Network\Request|\PHPUnit_Framework_MockObject_MockObject
     */
    public $request;

    /**
     * Response mock
     *
     * @var \Cake\Network\Response|\PHPUnit_Framework_MockObject_MockObject
     */
    public $response;

    /**
     * Test subject
     *
     * @var \ItThemes\View\Cell\ThemeCell
     */
    public $Theme;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->request = $this->getMock('Cake\Network\Request');
        $this->response = $this->getMock('Cake\Network\Response');
        $this->Theme = new ThemeCell($this->request, $this->response);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Theme);

        parent::tearDown();
    }

    /**
     * Test display method
     *
     * @return void
     */
    public function testDisplay()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
