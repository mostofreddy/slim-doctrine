<?php
/**
 * DoctrineServiceProvider
 *
 * PHP version 7+
 *
 * Copyright (c) 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * @category  Resty
 * @package   Resty\Slim\Doctrine\Providers
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
namespace Resty\Slim\Doctrine\Providers;
// Resty
use Resty\Slim\AbstractServiceProvider;
// Doctrine
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
// Slim
use Slim\Container;
/**
 * DoctrineServiceProvider
 *
 * @category  Resty
 * @package   Resty\Slim\Doctrine\Providers
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar}
 * 
 * @codeCoverageIgnore
 */
class DoctrineServiceProvider extends AbstractServiceProvider
{
    const ERROR_CONFIG_NOT_FOUND = "Doctrine config: No found";
    const DEFAULT_CONNECTION = [
        'driver'   => 'pdo_mysql',
        'user'     => 'root',
        'password' => 'root',
        'dbname'   => 'mydb',
        'host'   => 'localhost',
        'port'   => 3306
    ];
    const DEFAULT_META = [
        'paths' => [],
        'isDevMode' => false,
        'proxyDir' => null,
        'cache' => null,
        'useSimpleAnnotationReader' => true
    ];
    /**
     * Registra el servicio
     *
     * @param Container $container Instancia de la aplicacion
     *
     * @return void
     */
    public static function register(Container $container)
    {
        $container['em'] = function ($container) {

            if (!isset($container['doctrine'])) {
                throw new \Exception(static::ERROR_CONFIG_NOT_FOUND);
            }

            if (isset($container['doctrine']['meta'])) {
                $meta = $container['doctrine']['meta'] + static::DEFAULT_META;
            } else {
                $meta = static::DEFAULT_META;
            }

            if (isset($container['doctrine']['connection'])) {
                $connection = $container['doctrine']['connection'];
            } else {
                $connection = static::DEFAULT_CONNECTION;
            }

            $config = Setup::createAnnotationMetadataConfiguration(
                $meta['paths'],
                $meta['isDevMode'],
                $meta['proxyDir'],
                $meta['cache'],
                $meta['useSimpleAnnotationReader']
            );
            return EntityManager::create($connection, $config);
        };
    }
}
