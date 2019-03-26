<?php
namespace App\Controllers;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class Controller
{
    protected $view;
    protected $logger;

    public function __construct(Twig $view, LoggerInterface $logger)
    {
        $this->view = $view;
        $this->logger = $logger;
        $this->logger->info("CLIENT : " . $_SERVER['REMOTE_ADDR'] . " requested ".$_SERVER['REQUEST_METHOD']." ".$_SERVER['REQUEST_URI']." => ".$_SERVER['REDIRECT_STATUS']);
    }
}