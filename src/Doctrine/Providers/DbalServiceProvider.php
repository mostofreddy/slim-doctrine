<?php
/**
 * DbalServiceProvider
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
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Logging\DebugStack;
// Slim
use Slim\Container;
/**
 * DbalServiceProvider
 *
 * @category  Resty
 * @package   Resty\Slim\Doctrine\Providers
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 *
 * @codeCoverageIgnore
 */
class DbalServiceProvider extends AbstractServiceProvider
{
    const ERROR_CONFIG_NOT_FOUND = "DBAlonfig: No found";
    const DEFAULT_CONFIG = [
        'debug' => false,
        'connection' => []
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
        $container['db'] = function ($container) {

            if (!isset($container['dbal'])) {
                throw new \Exception(static::ERROR_CONFIG_NOT_FOUND);
            }

            $configParams = $container['dbal'] + static::DEFAULT_CONFIG;

            $config = new Configuration();

            if ($configParams['debug'] === true) {
                $config->setSQLLogger(new DebugStack());
            }
            
            return \Doctrine\DBAL\DriverManager::getConnection($configParams['connection'], $config);

        };
    }
}
