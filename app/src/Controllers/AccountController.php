<?php
/**
 * Created by IntelliJ IDEA.
 * User: seemyping
 * Date: 02/04/19
 * Time: 08:11
 */

namespace App\Controllers;


use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;


class AccountController extends Controller
{
    public function get(Request $request, Response $response, $args)
    {
        $this->view->render($response, 'login.twig',[
            'pagetitle' => 'Accueil'
        ]);
        return $response;
    }
    public function post(Request $request, Response $response, $args) {

    }
}