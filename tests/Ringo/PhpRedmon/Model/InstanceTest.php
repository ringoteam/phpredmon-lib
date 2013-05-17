<?php

namespace Ringo\PhpRedmon\Model;

use Ringo\PhpRedmon\Model\Instance;
use Ringo\PhpRedmon\Model\Log;
use Doctrine\Common\Collections\ArrayCollection;

class InstanceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Instance
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Instance();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

   
    /**
     * @covers Ringo\PhpRedmon\Model\Instance::addLog
     * @covers Ringo\PhpRedmon\Model\Instance::getLogs
     */
    public function testAddLog()
    {
        $this->assertEquals(new ArrayCollection(), $this->object->getLogs());
        $log = new Log();
        $this->object->addLog($log);
        $this->assertEquals(1, sizeof($this->object->getLogs()));

        $logs = $this->object->getLogs();
        $this->assertEquals($log, $logs[0]);
    }

    /**
     * @covers Ringo\PhpRedmon\Model\Instance::removeLog
     * @covers Ringo\PhpRedmon\Model\Instance::getLogs
     */
    public function testRemoveLog()
    {
        $log = new Log();
        $this->object->addLog($log);
        $this->assertEquals(1, sizeof($this->object->getLogs()));
        $this->object->removeLog($log);
        $this->assertEquals(new ArrayCollection(), $this->object->getLogs());
    }

    /**
     * @covers Ringo\PhpRedmon\Model\Instance::getId
     * @covers Ringo\PhpRedmon\Model\Instance::setId
     */
    public function testGetId()
    {
        $this->assertEmpty($this->object->getId());
        $this->object->setId(2);
        $this->assertEquals(2, $this->object->getId());
    }

    /**
     * @covers Ringo\PhpRedmon\Model\Instance::getName
     * @covers Ringo\PhpRedmon\Model\Instance::setName
     */
    public function testGetName()
    {
        $this->assertEmpty($this->object->getName());
        $this->object->setName("instance");
        $this->assertEquals("instance", $this->object->getName());
    }

    /**
     * @covers Ringo\PhpRedmon\Model\Instance::getHost
     * @covers Ringo\PhpRedmon\Model\Instance::setHost
     */
    public function testGetHost()
    {
        $this->assertEmpty($this->object->getHost());
        $this->object->setHost("localhost");
        $this->assertEquals("localhost", $this->object->getHost());
    }

    /**
     * @covers Ringo\PhpRedmon\Model\Instance::getPort
     * @todo   Implement testGetPort().
     */
    public function testGetPort()
    {
        $this->assertEmpty($this->object->getPort());
        $this->object->setPort("1234");
        $this->assertEquals("1234", $this->object->getPort());
    }

    /**
     * @covers Ringo\PhpRedmon\Model\Instance::getError
     * @covers Ringo\PhpRedmon\Model\Instance::setError
     */
    public function testGetError()
    {
        $this->assertEmpty($this->object->getError());
        $this->object->setError("error message");
        $this->assertEquals("error message", $this->object->getError());
    }

    /**
     * @covers Ringo\PhpRedmon\Model\Instance::isWorking
     * @covers Ringo\PhpRedmon\Model\Instance::setWorking
     */
    public function testIsWorking()
    {
        $this->assertEquals(false, $this->object->isWorking());
        $this->object->setWorking(true);
        $this->assertEquals(true, $this->object->isWorking());
    }

    /**
     * @covers Ringo\PhpRedmon\Model\Instance::setLogs
     * @todo   Implement testSetLogs().
     */
    public function testSetLogs()
    {
        $logs = array(
            new Log(),
        );
        $logs = new ArrayCollection($logs);
        $this->object->setLogs($logs);
        $this->assertEquals($logs, $this->object->getLogs());
    }
}
