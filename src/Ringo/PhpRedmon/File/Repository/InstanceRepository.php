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
use Ringo\PhpRedmon\Mapper\InstanceMapperInterface;

/**
 * Class InstanceRepository
 *
 * Save Instance in serialize format into a file
 * 
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class InstanceRepository extends AbstractRepository implements InstanceMapperInterface
{
    /**
     * File manager
     * 
     * @var Filesystem 
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
    public function __construct($fileManager, $class)
    {
        $this->fileManager = $fileManager;
        $this->setClass($class);
    }
    
    /**
     * Find an entity by ID
     * 
     * @param string $id
     * @return null|mixed
     */
    public function find($id)
    {
        $key = $this->getHash().$id;
        if($this->getFileManager()->has($key)) {
            return $this->loadEntity($key);
        }
        
        return null;
    }
    
    /**
     * Create an instance
     * 
     * @param Instance $instance
     */
    public function create(Instance $instance)
    {
        $this->persist($instance);
    }

    /**
     * Update an instance
     * 
     * @param Instance $instance
     */
    public function update(Instance $instance)
    {
        $this->persist($instance);
    }

    
    /**
     * Find all entities for a specific class
     * 
     * @return array
     */
    public function findAll()
    {
        $keys = $this->getFileManager()->keys();
        $entities = array();
        if(is_array($keys)) {
            foreach($keys as $key) {
                if(preg_match('/^'.$this->getHash().'/', $key)) {
                    $entities[] = $this->loadEntity($key);
                }
            }
        }
        
        return $entities;
    }
    
    /**
     * Remove an instance
     * 
     * @param Instance $instance
     */
    public function remove(Instance $instance)
    {
        $key = $this->getHash().$instance->getId();
        if($this->getFileManager()->has($key)) {
            $this->getFileManager()->delete($key);
        }
    }
}