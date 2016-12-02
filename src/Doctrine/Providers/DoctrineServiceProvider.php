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
 * @package   Resty\Doctrine\Providers
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
namespace Resty\Doctrine\Providers;
// Resty
use Resty\Api;
use Resty\Interfaces\ServiceProviderInterface;
// Doctrine
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

/**
 * DoctrineServiceProvider
 *
 * @category  Resty
 * @package   Resty\Doctrine\Providers
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class DoctrineServiceProvider implements ServiceProviderInterface
{
    const ERROR_CONFIG_NOT_FOUND = "Doctrine config: No found";
    const DEFAULT_CONFIG = [
        'driver'   => 'pdo_mysql',
        'user'     => 'root',
        'password' => '',
        'dbname'   => '',
        'host'   => 'localhost',
        'port'   => 3306,
        'isDevMode' => true,
        'entitiesFiles' => ''
    ];
    /**
     * Registra el servicio
     *
     * @param Api $app Instancia de la aplicacion
     *
     * @return void
     */
    public static function register(Api $app)
    {
        $container = $app->getContainer();

        $container['em'] = function ($container) {

            if (!isset($container['doctrine'])) {
                throw new \Exception(static::ERROR_CONFIG_NOT_FOUND);
            }

            $connectionParams = $container['doctrine'] + static::DEFAULT_CONFIG;

            // the connection configuration
            $dbParams = [
                'driver'   => $connectionParams['driver'],
                'user'     => $connectionParams['user'],
                'password' => $connectionParams['password'],
                'dbname'   => $connectionParams['dbname'],
                'host'   => $connectionParams['host'],
            ];

            $config = Setup::createAnnotationMetadataConfiguration(
                $connectionParams['entitiesFiles'],
                $connectionParams['isDevMode']
            );
            return EntityManager::create($dbParams, $config);
        };
    }
}
