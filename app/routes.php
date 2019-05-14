<?php
// Routes

$app->get('/', App\Controllers\PagesController::class . ':home')
    ->setName('home');
$app->get('/services', App\Controllers\PagesController::class . ':services') //TODO: Frontend
    ->setName('services');
$app->get('/subscriptions', App\Controllers\PagesController::class . ':subscriptions') //TODO: Frontend
    ->setName('subscriptions');


$app->get('/login', App\Controllers\LoginController::class . ':get')
    ->setName('login_get');
$app->post('/login', App\Controllers\LoginController::class . ':login')
    ->setName('login');

$app->get('/register', App\Controllers\RegisterController::class . ':get')
    ->setName('register_get');
$app->get('/register/[{token}]', App\Controllers\RegisterController::class . ':validate');

$app->post('/register', App\Controllers\RegisterController::class . ':post')
    ->setName('register');



$app->get('/newsletter', App\Controllers\NewsletterController::class . ':infos')
    ->setName('newsletter');
$app->post('/newsletter', App\Controllers\NewsletterController::class . ':register')
    ->setName('newsletter');
$app->delete('/newsletter/[{email}]', App\Controllers\NewsletterController::class . ':delete')
    ->setName('newsletter');