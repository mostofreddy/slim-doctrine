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
 * @package   Resty\Doctrine\Providers
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
namespace Resty\Doctrine\Providers;

use Resty\Api;
use Resty\Interfaces\ServiceProviderInterface;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Logging\DebugStack;

/**
 * DbalServiceProvider
 *
 * @category  Resty
 * @package   Resty\Doctrine\Providers
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class DbalServiceProvider implements ServiceProviderInterface
{
    const ERROR_CONFIG_NOT_FOUND = "DBAlonfig: No found";
    const DEFAULT_CONFIG = [
        'debug' => true
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

        $container['db'] = function ($container) {

            if (!isset($container['dbal'])) {
                throw new \Exception(static::ERROR_CONFIG_NOT_FOUND);
            }

            $connectionParams = $container['dbal'] + static::DEFAULT_CONFIG;

            $config = new Configuration();

            if ($connectionParams['debug'] === true) {
                $config->setSQLLogger(new DebugStack());
            }
            
            return \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);

        };
    }
}
