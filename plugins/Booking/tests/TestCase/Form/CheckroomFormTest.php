<?php
namespace Booking\Test\TestCase\Form;

use Booking\Form\CheckroomForm;
use Cake\TestSuite\TestCase;

/**
 * Booking\Form\CheckroomForm Test Case
 */
class CheckroomFormTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Booking\Form\CheckroomForm
     */
    public $Checkroom;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Checkroom = new CheckroomForm();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Checkroom);

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
