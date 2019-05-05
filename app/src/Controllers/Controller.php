<?php
namespace App\Controllers;

use Slim\Container;
use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class Controller
{
    protected $view;
    protected $logger;
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->view = $container['view'];
        $this->logger = $container['logger'];
        $this->logger->info("CLIENT : " . $_SERVER['REMOTE_ADDR'] . " requested ".$_SERVER['REQUEST_METHOD']." ".$_SERVER['REQUEST_URI']." => ".$_SERVER['REDIRECT_STATUS']);
    }

}