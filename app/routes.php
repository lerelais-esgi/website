<?php
// Routes

$app->get('/', App\Controllers\HomeController::class . ':get')
    ->setName('home');
