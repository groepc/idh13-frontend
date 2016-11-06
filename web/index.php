<?php

// web/index.php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../IDH13SDK.php';

$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

$app = new Silex\Application();
$app['debug'] = true;
$app['current_url'] = $_SERVER['REQUEST_URI'];

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../views',
));

$app->get('/', function (Silex\Application $app) {
    $test = new IDH13SDK('http://localhost:7101/reference/CountryService?wsdl', array('trace'=> 1));
    $countries = $test->find();
    return $app['twig']->render('list.html.twig', array(
                'countries' => $countries,
    ));
});

$app->get('/country/create', function (Silex\Application $app) {
    return $app['twig']->render('create.html.twig', array(
                'countries' => array(),
    ));
});

$app->post('/country/create', function (Silex\Application $app) {
    $test = new IDH13SDK('http://localhost:7101/reference/CountryService?wsdl', array('trace'=> 1));
    $createCountry = $test->create($_POST['code'],$_POST['name'],$_POST['tailcode']);
    return $app->redirect('/');
});

$app->run();
