<?php

namespace Ringo\PhpRedmon\Model;

use Ringo\PhpRedmon\Model\Log;

class LogTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Log
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Log();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Ringo\PhpRedmon\Model\Log::getId
     * @covers Ringo\PhpRedmon\Model\Log::setId
     */
    public function testGetId()
    {
        $this->assertEmpty($this->object->getId());
        $this->object->setId(2);
        $this->assertEquals(2, $this->object->getId());
    }

    /**
     * @covers Ringo\PhpRedmon\Model\Log::getCreatedAt
     * @covers Ringo\PhpRedmon\Model\Log::setCreatedAt
     */
    public function testGetCreatedAt()
    {
        $date = new \DateTime();
        $this->assertNull($this->object->getCreatedAt());
        $this->object->setCreatedAt($date);
        $this->assertEquals($date, $this->object->getCreatedAt());
    }

    /**
     * @covers Ringo\PhpRedmon\Model\Log::getMemory
     * @covers Ringo\PhpRedmon\Model\Log::setMemory
     */
    public function testGetMemory()
    {
        $this->assertEmpty($this->object->getMemory());
        $this->object->setMemory(2);
        $this->assertEquals(2, $this->object->getMemory());
    }

    /**
     * @covers Ringo\PhpRedmon\Model\Log::getCpu
     * @covers Ringo\PhpRedmon\Model\Log::setCpu
     */
    public function testGetCpu()
    {
        $this->assertEmpty($this->object->getCpu());
        $this->object->setCpu(2);
        $this->assertEquals(2, $this->object->getCpu());
    }

}
