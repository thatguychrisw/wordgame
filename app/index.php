<?php
    use Phalcon\Mvc\Micro\Collection as MicroCollection;

    $loader = new \Phalcon\Loader();

    $loader->registerDirs(array(
        'controllers/',
        'providers/',
        'vendor/wordnik-php/wordnik/',
    ))->register();

    $di = new \Phalcon\DI\FactoryDefault();

    $di->set('wordServiceProvider', 'WordnikWordProvider');
    $di->set('WordController', array(
        'className' => 'WordController',
        'calls'     => array(
            array(
                'method'    => 'setWordServiceProvider',
                'arguments' => array(
                    array('type' => 'service', 'name' => 'wordServiceProvider')
                )
            )
        )
    ));

    $app = new Phalcon\Mvc\Micro();

    $wordApi = new MicroCollection();
    $wordApi->setHandler($di->get('WordController')); // prefer di over the magic __get() to the IOC
    $wordApi->setPrefix('/word');
    $wordApi->get('/random', 'getRandomWords');

    $app->mount($wordApi);

    // Take any output from the controller and pass it back via json
    //
    $app->after(function () use ( $app ) {
        echo json_encode(array('result' => $app->getReturnedValue()));
    });

    $app->handle();
