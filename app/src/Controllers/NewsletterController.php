<?php
/**
 * Created by IntelliJ IDEA.
 * User: seemyping
 * Date: 08/05/19
 * Time: 17:18
 */

namespace App\Controllers;


use Slim\Http\Request;
use Slim\Http\Response;

final class NewsletterController extends Controller
{

    public function register(Request $request, Response $response, $args)
    {
        $r = $this->db->prepare('INSERT INTO newsletter (firstname, lastname, email) VALUES (:f, :l, :e)');
        //if(defined($_POST['e']) && defined($_POST['f']) && defined($_POST['l'])) {

            if ($r->execute(['e' => $_POST['e'], 'f' => $_POST['f'], 'l' => $_POST['l']])) {
                $errors['title'] = "Merci de vous êtes enregistré !";
                $errors['message'] = "Vous êtes maintenant enregistré sur notre newsletter";
                $errors['type'] = 'success';
                $this->view->render($response, 'error.twig', [
                    'pagetitle' => 'LeRelais - Newsletter',
                    'errors' => $errors,
                    'lang' => $this->lang
                ]);
            } else {
                $this->view->render($response, 'newsletter.twig', [
                    'pagetitle' => 'Newsletter - Erreur !',
                    'lang' => $this->lang,
                    'status' => 'KO'
                ]);
            }
        /*} else {
            $this->view->render($response, 'newsletter.twig', [
                'pagetitle' => 'Newsletter - Erreur !',
                'lang' => $this->lang,
                'status' => 'KO'
            ]);
        }*/

        return $response;
    }
}