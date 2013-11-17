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

namespace Ringo\PhpRedmon\Model;


/**
 * Class Database
 *
 * @author Pascal DENIS <pascal.denis@businessdecision.com>
 */
class Database
{
    /**
     * DB Id
     *
     * @var string
     */
    protected $id;

    /**
     * Db Name
     *
     * @var string
     */
    protected $name;

    /**
     * Instance
     *
     * @var Ringo\PhpRedmon\Model\Instance
     */
    protected $instance;

    /**
     * Getter id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Getter name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Setter id
     *
     * @param $id Db id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Setter name
     *
     * @param $name db name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get instance
     *
     * @return Instance
     */
    public function getInstance()
    {
        return $this->instance;
    }

    /**
     * Set instance
     *
     * @param Instance $instance
     */
    public function setInstance(Instance $instance)
    {
        $this->instance = $instance;
    }
}