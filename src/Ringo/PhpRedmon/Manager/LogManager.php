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

namespace Ringo\PhpRedmon\Manager;

use Ringo\PhpRedmon\Model\Log;
use Ringo\PhpRedmon\Mapper\LogMapperInterface;

/**
 * Class LogManager
 *
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 */
class LogManager
{
    /**
     * Mapper
     * 
     * @var mixed
     */
    protected $mapper;
    
    /**
     * Log class
     * 
     * @var string
     */
    protected $class;
    
    /**
     * Constructor
     * 
     * @param string $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }
    
    /**
     * Create an empty Redis Log
     * 
     * @return \Ringo\PhpRedmon\Model\Log
     */
    public function createNew()
    {
        $class = $this->class;
        
        return new $class;
    }
}