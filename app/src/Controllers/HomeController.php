<?php
namespace App\Controllers;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class HomeController extends Controller
{
    public function get(Request $request, Response $response, $args)
    {
        var_dump($_SERVER);
        //$this->view->render($response, 'home.twig');
        return $response;
    }
}