<?php
namespace BakeTemplates\Test\TestCase\Shell;

use BakeTemplates\Shell\FooShell;
use Cake\TestSuite\TestCase;

/**
 * BakeTemplates\Shell\FooShell Test Case
 */
class FooShellTest extends TestCase
{

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->io = $this->getMock('Cake\Console\ConsoleIo');
        $this->Foo = new FooShell($this->io);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Foo);

        parent::tearDown();
    }

    /**
     * Test main method
     *
     * @return void
     */
    public function testMain()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
