<?php
// Routes

$app->get('/', App\Controllers\HomeController::class . ':get')
    ->setName('home');
$app->get('/login', App\Controllers\AccountController::class . ':get')
    ->setName('login');
