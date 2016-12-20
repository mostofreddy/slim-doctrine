<?php
/**
 * Entity
 *
 * PHP version 7+
 *
 * Copyright (c) 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * @category  Resty
 * @package   Resty\Doctrine
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
namespace Resty\Slim\Doctrine;

/**
 * Entity
 *
 * @category  Resty
 * @package   Resty\Doctrine
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
abstract class Entity implements \JsonSerializable
{
    /**************************************************************
     * Serialización
     *************************************************************/

    /**
     * Serializa la entidad
     * 
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
    /**
     * Transforma el objeto a array
     *
     * @return array
     */
    public function toArray():array
    {
        $return = [];
        foreach (get_object_vars($this) as $attrName => $attrValue) {
            $return[$attrName] = $attrValue;
        }
        return $return;
    }
}
