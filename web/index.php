<?php

// web/index.php
require_once __DIR__ . '/../vendor/autoload.php';

$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../views',
));

$app->get('/', function (Silex\Application $app) {
    return $app['twig']->render('list.html.twig', array(
                'countries' => array(),
    ));
});

$app->get('/country/create', function (Silex\Application $app) {
    return $app['twig']->render('create.html.twig', array(
                'countries' => array(),
    ));
});

$app->run();
