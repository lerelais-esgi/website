<?php
/**
 * Created by IntelliJ IDEA.
 * User: seemyping
 * Date: 08/05/19
 * Time: 22:40
 */

namespace App\Controllers;


class PagesController extends Controller
{
    public function home(Request $request, Response $response, $args)
    {
        $this->view->render($response, 'home.twig',[
            'pagetitle' => 'Accueil #FightFoodWaste',
            'lang'  => $this->lang,
        ]);
        return $response;
    }

    public function services(Request $request, Response $response, $args)
    {
        $this->view->render($response, 'services.twig',[
            'pagetitle' => 'Nos Services #FightFoodWaste',
            'lang'  => $this->lang,
        ]);
        return $response;
    }
    public function subscriptions(Request $request, Response $response, $args)
    {
        $this->view->render($response, 'subscriptions.twig',[
            'pagetitle' => 'Nos Services #FightFoodWaste',
            'lang'  => $this->lang,
        ]);
        return $response;
    }
}