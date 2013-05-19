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

namespace Ringo\PhpRedmon\File\Repository;

use Ringo\PhpRedmon\Model\Instance;
use Gaufrette\Filesystem;

/**
 * Class AbstractRepository
 *
 * Abstract class to save entity into serialize format into a file
 * 
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
abstract class AbstractRepository 
{
    /**
     * File manager
     * 
     * @var mixed 
     */
    protected $fileManager;
    
    /**
     * Object class
     * 
     * @var string 
     */
    protected $class;
    
    /**
     * Hash associated to the class
     * 
     * @var string
     */
    protected $hash;
    
    /**
     * Constructor
     * 
     * @param mixed $fileManager
     */
    public function __construct(Filesystem $fileManager)
    {
        $this->fileManager = $fileManager;
    }
    
    /**
     * Get file manager
     * 
     * @return Filesystem
     */
    public function getFileManager()
    {
        return $this->fileManager;
    }
    
    /**
     * Set file manager
     * 
     * @param Filesystem $fileManager
     */
    public function setFileManager(Filesystem $fileManager)
    {
        $this->fileManager = $fileManager;
    }
    
    /**
     * Get current entity class
     * 
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }
    
    /**
     * Set current entity class
     * 
     * @param string $class
     */
    public function setClass($class)
    {
        $this->class = $class;
        $this->setHash(md5($class));                                                                                                                                                                                         
    }
    
    /**
     * Get hash
     * 
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }
    
    /**
     * Set hash
     * 
     * @param string $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }
    
    /**
     * Load an entity by key
     * 
     * @param string $key
     * @return mixed|null
     */
    protected function loadEntity($key)
    {
        $content = $this->getFileManager()->read($key);
        if($content) {
            return unserialize($content);
        }
        
        return null;
    }

    /**
     * Save an object entity
     * 
     * @param mixed $object
     */
    protected function persist($object)
    {
        if(!$object->getId()) {
            $object->setId($this->getNextId());
        }
        $key = $this->getHash().$object->getId();
        $content = serialize($object);
        
        $this->getFileManager()->write($key, $content, true);
    }
    
    /**
     * Get next ID for an object class
     * 
     * @return int
     */
    protected function getNextId()
    {
        $keys = $this->getFileManager()->keys();
        $ids = array();
        foreach($keys as $key) {
            if(preg_match('/^'.$this->getHash().'/', $key)) {
                $ids[] = str_replace($this->getHash(), '', $key);
            }
        }
        if(empty($ids)) {
            return 1;
        }
        
        $maxId = max($ids);
        
        return $maxId + 1;
    }
}