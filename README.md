Resty-Doctrine
==============

[![Build Status](https://travis-ci.org/mostofreddy/resty-doctrine.svg?branch=development)](https://travis-ci.org/mostofreddy/resty-doctrine)

Service provider para integrar Doctrine y DBAL en proyectos basados en [Resty](https://github.com/mostofreddy/resty)

Versión estable
---------------

0.1.0

License
-------

The MIT License (MIT). Ver el archivo [LICENSE](LICENSE.md) para más información

Features
--------

* Entidad base
* Provider para instanciar DBAL
* Provider para instanciar Doctrine

Documentación
-------------

### Entidad base

Clase base para entidades de doctrine que permite transformar la entidad en json o array

```
use Resty\Doctrine\Entity;
/**
 * @Entity @Table(name="dummy")
 **/
class EntityDummy extends Entity
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    /** @Column(type="string") **/
    protected $name;
    /** @Column(type="string") **/
    protected $lastName;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
    public function getLastName()
    {
        return $this->lastName;
    }
    public function setLastName($name)
    {
        $this->lastName = $name;

        return $this;
    }
}

$e = new EntityDummy();
$e->setName("John");
$e->setLastName('Doe');

// transformar a array
var_dump($e->toArray());

// transformar a json
var_dump($e->jsonSerialize());

// internamente invoca al metodo jsonSerialize
var_dump(json_encode($e));
```

### DBAL

Genera el factory para instanciar DBAL

__Cargar el provider___

En el archivo de configuración agregar la siguiente linea

```
// Providers
$config['servicesproviders'] = [
    '\Resty\Doctrine\Providers\DbalServiceProvider'
];
```

__Configuración__

```
$config['dbal'] = [
    'dbname' => 'mydb',
    'user' => 'root',
    'password' => 'root',
    'host' => '127.0.0.1',
    'driver' => 'pdo_mysql',
    'port' => 3306
    'debug' => true
];

// otra opción

$config['dbal'] = [
    'url' => 'mysql://root:root@localhost/mydb',
    'debug' => true
];
```

__Ejemplo de uso__

```
use Resty\Api;
use Resty\CommandController;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\RequestInterface as Request;

class IndexController extends CommandController
{
    public function __invoke(Request $req, Response $res, array $params = []):Response
    {
        $db = $this->container->get('db');
        $clients = $db->fetchAll("SELECT * FROM clients");
        return $this->ok($clients);
    }
}
$config = [];
$config['settings'] = [];
// Providers
$config['servicesproviders'] = [
    '\Resty\Doctrine\Providers\DbalServiceProvider'
];
$config['dbal'] = [
    'url' => 'mysql://root:root@127.0.0.1/points'
];
$api = new Api($config);
$api->get('/', 'IndexController');
$api->run();
```


