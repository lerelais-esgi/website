<?php
/**
 * Created by IntelliJ IDEA.
 * User: seemyping
 * Date: 08/05/19
 * Time: 22:40
 */

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

final class PagesController extends Controller
{

    public function get(Request $request, Response $response, $args)    {
        $this->view->render($response, 'backend/dashboard.twig',[
            'pagetitle' => 'Le Relais - Dashboard',
            'lang'  => $this->lang,
        ]);
        return $response;
    }

}