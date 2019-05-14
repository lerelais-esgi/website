<?php
// DIC configuration

$container = $app->getContainer();

// -----------------------------------------------------------------------------
// Service providers
// -----------------------------------------------------------------------------

// Twig
$container['view'] = function ($c) {
    $settings = $c->get('settings');
    $view = new Slim\Views\Twig($settings['view']['template_path'], $settings['view']['twig']);

    // Add extensions
    $view->addExtension(new Slim\Views\TwigExtension($c->get('router'), $c->get('request')->getUri()));
    $view->addExtension(new Twig_Extension_Debug());

    return $view;
};

// Flash messages
$container['flash'] = function ($c) {
    return new Slim\Flash\Messages;
};

$container['database'] = function ($c) {
    try {
        $pdo = new PDO("mysql:dbname=lerelais;host=localhost", 'finley', 'alinea141');//TODO:getenv('mysql_password')
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
    catch (PDOException $e) {
        $c->logger->error($e->getMessage());
        die();
    }
};

// -----------------------------------------------------------------------------
// Service factories
// -----------------------------------------------------------------------------

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings');
    $logger = new Monolog\Logger($settings['logger']['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['logger']['path'], Monolog\Logger::DEBUG));
    return $logger;
};

$container['csrf'] = function ($c) {
    return new \Slim\Csrf\Guard;
};
// -----------------------------------------------------------------------------
// Errors handler
// -----------------------------------------------------------------------------
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        $c->view->render($response, '404.twig',[
            'pagetitle' => 'Erreur 404'
        ]);
        return $response->withStatus(404);
    };
};

// -----------------------------------------------------------------------------
// Configurations
// -----------------------------------------------------------------------------

$container['debug'] = function ($c) { return true; };