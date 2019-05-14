<?php
/**
 * Created by IntelliJ IDEA.
 * User: seemyping
 * Date: 08/05/19
 * Time: 22:59
 */

namespace App\Controllers;

use Slim\Views\Twig;
use Slim\Http\Request;
use Slim\Http\Response;


final class LoginController extends Controller
{
    public function get(Request $request, Response $response, $args) {
        $this->view->render($response, 'login.twig', [
            'csrf' =>   $this->csrf,
            'data' => $_SESSION,
            'pagetitle' => 'Le Relais - Connexion',
            'lang' => $this->lang
        ]);
    }

    public function login(Request $request, Response $response, $args)
    {
        if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $r = $this->db->prepare('SELECT * FROM `users` WHERE email = :e');
            $r->execute(['e' => $_POST['email']]);
            $r = $r->fetch(\PDO::FETCH_LAZY);
            if ($this->decrypt($r['password']) === $_POST['password']) {
                $this->_login($r, $response);
            } else {
                $errors['type'] = 'danger';
                $errors['message'] = 'Mot de passe erroné';
                $this->view->render($response, 'login.twig', [
                    'csrf' => $this->csrf,
                    'errors' => $errors,
                    'form' => $_POST,
                    'data' => $_SESSION,
                    'pagetitle' => 'Le Relais - Connexion',
                    'lang' => $this->lang
                ]);
            }
        } else {
            $errors['type'] = 'warning';
            $errors['message'] = 'Email non valide';
            $this->view->render($response, 'login.twig', [
                'csrf' => $this->csrf,
                'errors' => $errors,
                'form' => $_POST,
                'data' => $_SESSION,
                'pagetitle' => 'Le Relais - Connexion',
                'lang' => $this->lang
            ]);
        }
    }

    private function _login($u, $response) {
        if($u['business'] != null) {
            $_SESSION['name'] = $u['business'];
        } else {
            $_SESSION['name'] = $u['firstname'].' '.$u['lastname'];
        }
        $_SESSION['uid']    = $u['id'];
        $_SESSION['email']  = $u['email'];
        $_SESSION['logged'] = true;
        $t = bin2hex(openssl_random_pseudo_bytes(16));
        $this->db->prepare("UPDATE `users` SET `token` = ?, `last_ip` = ? WHERE id = ?")
        ->execute([$t, $_SERVER['REMOTE_ADDR'], $_SESSION['uid']]);
        $errors['title'] = "Vous êtes connecté ! ";
        $errors['message'] = "Ouais c'est ok ma gueule";
        $errors['type'] = 'success';
        $this->view->render($response, 'error.twig', [
            'pagetitle' => 'LeRelais - Newsletter',
            'data'  => $_SESSION,
            'errors' => $errors,
            'lang' => $this->lang
        ]);
    }
}