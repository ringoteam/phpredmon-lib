<?php

/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace Ringo\PhpRedmon\Worker;

use Ringo\PhpRedmon\Model\Instance;
use Predis\Client;
use Ringo\PhpRedmon\Model\Info;


/**
 * Class InstanceWorker
 *
 * A worker to call Redis commands through redis instance
 * 
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class InstanceWorker 
{
    /** 
     * Redis instance
     * 
     * @var \Ringo\PhpRedmon\Model\Instance
     */
    protected $instance;
    
    /**
     * Redis client
     * 
     * @var \Predis\Client
     */
    protected $client;
    
    /**
     * Potential exception
     * 
     * @var \Exception
     */
    protected $exception;
    
    /**
     * Constructor
     */
    public function __construct()
    {}
    
    /**
     * Ping the server
     * 
     * @return boolean
     */
    public function ping()
    {
        return $response = $this->execute('ping');
    }
    
    /**
     * Flush an instance Database
     * @param int $db Database index
     */
    public function flushDB($db)
    {
        $this->execute('select', array($db));
        $this->execute('flushDB');
    }
    
    /**
     * Get infos from server
     * 
     * @return array
     */
    public function getInfos()
    {
        return new Info($this->execute('info'));
    }
    
    /**
     * Get slow logs
     * 
     * @return array
     */
    public function getSlowLogs()
    {
        return $this->execute(
            'slowlog', 
            array(
                'get',
                '20'
            )
        );
    }
    
    /**
     * Get keyspace
     *  
     * @return array
     */
    public function getKeyspace()
    {
        return $this->execute('info', array('keyspace'));
    }
    
    /**
     * Get clients list
     * 
     * @return array
     */
    public function getClients()
    {
        return $this->execute('client', array('list'));
    }

    /**
     * Get config
     * 
     * @return array
     */
    public function getConfiguration()
    {
        return new Info($this->execute('config', array('get','*')));
    }

    /**
     * Delete keys
     *
     * @param $keys Keys to delete
     * @param int $db Database index
     * @return mixed
     */
    public function delete(array $keys, $db = -1)
    {
        if(-1 != $db) {
            $this->execute('select', array($db));
        }

        return $this->execute('del', $keys);
    }
    
    /**
     * Get exception
     * 
     * @return \Exception|null
     */
    public function getException()
    {
        return $this->exception;
    }
    
    /**
     * Get error message
     * 
     * @return string
     */
    public function getMessage()
    {
        if($this->exception) {
            return $this->exception->getMessage();
        }
        return '';
    }
    
    /**
     * Get current instance
     * 
     * @return \Ringo\PhpRedmon\Model\Instance|null
     */
    public function getInstance()
    {
        return $this->instance;
    }

    /**
     * Get value
     *
     * @param $key Key
     * @param int|string $db Database index
     * @return mixed
     */
    public function get($key, $db = -1)
    {
        if(-1 != $db) {
            $this->execute('select', array($db));
        }

        return $this->execute('get', array($key));
    }

    /**
     * Get time to live
     * @param $key Key
     * @param int|string $db Database index
     * @return mixed
     */
    public function ttl($key, $db = -1)
    {
        if(-1 != $db) {
            $this->execute('select', array($db));
        }

        return $this->execute('ttl', array($key));
    }

    /**
     * Search keys into db / all dbs
     *
     *
     * @param $key Keyword
     * @param int|string $db Database index
     * @return mixed
     */
    public function keys($key, $db = -1)
    {
        if(-1 != $db) {
            $this->execute('select', array($db));
        }

        return $this->execute('keys', array($key));
    }
    
    /**
     * Set current instance
     * 
     * @param \Ringo\PhpRedmon\Model\Instance $instance
     * @return \Ringo\PhpRedmon\Worker\InstanceWorker
     */
    public function setInstance(Instance $instance)
    {
        $this->instance = $instance;
        $this->exception = null;
        $this->connect();
        
        return $this;
    }
    
    /**
     * Connect redis client to the server
     */
    protected function connect()
    {
        $this->client = new Client(array(
            'host'   => $this->instance->getHost(),
            'port'   => $this->instance->getPort(),
        ));
    }
    
    /**
     * Execute commands
     * 
     * @param string $command
     * @param array $parameters
     * 
     * @return mixed
     */
    public function execute($command, $parameters = array())
    {
        try {
            $cmdSet = $this->client->createCommand($command, $parameters);
            return $this->client->executeCommand($cmdSet);
        }catch(\Exception $e) {
            $this->exception = $e;
            return false;
        }
    }
}