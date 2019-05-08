<?php
$app->add(new App\Middlewares\TwigCSRFMiddleware($container->view->getEnvironment(), $container->csrf));
$app->add($container->get('csrf'));


// Twig CSRF Miidleware

