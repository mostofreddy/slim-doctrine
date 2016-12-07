<?php
/**
 * EntityTest
 *
 * PHP version 7+
 *
 * Copyright (c) 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * @category  Resty
 * @package   Resty\Test\Doctrine
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
namespace Resty\Test\Doctrine;

use Resty\Doctrine\Entity;
use Resty\Test\Helpers\EntityDummy;
/**
 * EntityTest
 *
 * @category  Resty
 * @package   Resty\Test\Doctrine
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class EntityTest extends \PHPUnit_Framework_TestCase
{
    protected static $entity = null;
    protected static $expected = [
        "name" => "Juan",
        "lastName" => "Perez",
        "id" => 1
    ];

    /**
     * Testea la creacion de la entidad
     * 
     * @return void
     */
    public function testCreateEntity()
    {
        $e = new EntityDummy();
        $e->setName(static::$expected['name']);
        $e->setLastName(static::$expected['lastName']);
        $e->setId(static::$expected['id']);
        static::$entity = $e;

        $this->assertEquals(
            static::$expected['name'],
            $e->getName()
        );
        $this->assertEquals(
            static::$expected['lastName'],
            $e->getLastName()
        );
    }

    /**
     * Metodo que testea la transformación de la entidad a array
     *
     * @depends testCreateEntity
     * 
     * @return void
     */
    public function testToArray()
    {
        $this->assertEquals(
            static::$expected,
            static::$entity->toArray()
        );
    }

    /**
     * Metodo que testea la transformación de la entidad a array
     *
     * @depends testCreateEntity
     * 
     * @return void
     */
    public function testToJson()
    {
        $this->assertEquals(
            static::$expected,
            static::$entity->jsonSerialize()
        );
    }
}
