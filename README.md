Resty-Doctrine
==============

[![Build Status](https://travis-ci.org/mostofreddy/slim-doctrine.svg)](https://travis-ci.org/mostofreddy/slim-doctrine)

Service provider para integrar Doctrine y DBAL en proyectos basados en Slim 3.

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

Requisitos
----------

* PHP >= 7
* restyphp/slim-service-provider

Instalación
-----------

```
{
    require: {
        "restyphp/slim-doctrine": "*"
    }

}
```

Documentación
-------------

### Entidad base

Clase base para entidades de doctrine que permite transformar la entidad en json o array

```
use Resty\Doctrine\Entity;
/**
 * @Entity @Table(name="clients")
 **/
class Client extends Entity
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    /** @Column(type="string") **/
    protected $name;

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
}

$e = new Client();
$e->setName("John");

// transformar a array
var_dump($e->toArray());

// transformar a json
var_dump($e->jsonSerialize());

// internamente invoca al metodo jsonSerialize
var_dump(json_encode($e));
```

### DBAL

```
use Slim\App;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Resty\ServiceProviderMiddleware;

$config = [];
$config['settings'] = [
    // slim config
];
$config['services'] = [
    '\Resty\Doctrine\Providers\DbalServiceProvider'
];
$config['dbal'] = [
    'connection' => [
        'url' => 'mysql://root:root@127.0.0.1/points'
    ],
    'debug' => true
];
$api = new App($config);
$api->add('\Resty\ServiceProviderMiddleware');

$api->get('/dbal', function (ServerRequestInterface $request, ResponseInterface $response) {

    $db = $this->get('db');
    $clients = $db->fetchAll('SELECT * FROM clients');

    $body = $response->getBody();
    return $body->write(json_encode($clients));
});

$api->run();

```

### Doctrine


```
use Slim\App;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Resty\ServiceProviderMiddleware;

$config = [];
$config['settings'] = [
    // slim config
];
$config['services'] = [
    '\Resty\Doctrine\Providers\DbalServiceProvider'
];
$config['doctrine'] = [
    'meta' => [
        'paths' => [],
        'isDevMode' => false,
        'proxyDir' => null,
        'cache' => null,
        'useSimpleAnnotationReader' => true
    ],
    'connection' => [
        'url' => 'mysql://root:root@127.0.0.1/points'
    ]
];
$api = new App($config);
$api->add('\Resty\ServiceProviderMiddleware');

$api->get('/doctrine', function (ServerRequestInterface $request, ResponseInterface $response) {

    $em = $this->get('em');
    $query = $em->createQuery('SELECT c FROM \Client c');
    $clients = $query->getResult();

    $body = $response->getBody();
    return $body->write(json_encode($clients));
});

$api->run();

```
