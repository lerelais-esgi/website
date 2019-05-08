<?php
/**
 * Created by IntelliJ IDEA.
 * User: seemyping
 * Date: 02/04/19
 * Time: 08:11
 */

namespace App\Controllers;

use Slim\Views\Twig;
use Slim\Http\Request;
use Slim\Http\Response;


final class RegisterController extends Controller
{

    public function get(Request $request, Response $response, $args) {
        $this->view->render($response, 'register.twig', [
            'csrf' =>   $this->csrf,
            'pagetitle' => 'Le Relais - Inscription',
            'lang' => $this->lang
        ]);
    }

    public function post(Request $request, Response $response, $args) {
        $errors = [];
        if(empty($_POST['email']) || (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false))
            $errors['email'] = 1;
        if(empty($_POST['firstname']))
            $errors['firstname'] = 1;
        if(empty($_POST['lastname']))
            $errors['lastname'] = 1;
        if(empty($_POST['password'])) {
            if($_POST['password1'] != $_POST['password2'])
                $errors['password'] = 1;
        }
        if(empty($_POST['address']))
            $errors['address'] = 1;
        if($errors != null) {
            $errors['message'] = "Des erreurs sont présentes dans le formulaire : ";
        } else {
            $r = $this->db->prepare('SELECT id FROM users WHERE email = :email');
            $r->execute(['email' => $_POST['email']]);
            if(!empty($r->fetchAll())) {
                $errors['message'] = "Un compte existe déjà avec cette adresse email";
            } else {
                $this->_register($_POST['email'], $_POST['firstname'], $_POST['lastname'], $_POST['password1'], $_POST['address']);
                $errors['valide'] = "Vous êtes bien enregistré";
            }
        }
        $this->view->render($response, 'register.twig', [
            'pagetitle' => 'LeRelais - Inscription',
            'errors' => $errors,
            'form'  => $_POST,
            'lang' => $this->lang
        ]);
    }
    private function _register($e, $f, $l, $p, $a, $b = null) {
        $p = $this->encrypt($p);
        $t = bin2hex(openssl_random_pseudo_bytes(16));
        $r = $this->db->prepare('INSERT INTO users (email, firstname, lastname, password, address, business, email_token) VALUES (:e, :f, :l, :p, :a, :b, :t)');
        $r->execute(['e' => $e, 'f' => $f, 'l' => $l, 'p' => $p, 'a' => $a, 'b' => $b, 't' => $t]);
        $this->sendemail([$e], 'Votre compte Le Relais', "Bonjour $f $l\ nVotre compte Le Relais a bien été créée ! \nPour activer votre compte rendez-vous sur http://lerelais.ved/register/$t ");
    }
    public function validate(Request $request, Response $response, $args) {
        $t = $args['token'];
        $r = $this->db->prepare('UPDATE `users` SET `validate` = ?, email_token = null WHERE email_token = ?');
        $r->execute(['1', $t]);
        $errors['title'] = "Merci de vous êtes enregistré !";
        $errors['message'] = "Votre email a bien été validé, vous pouvez maintenant vous connecter";
        $errors['type'] = 'success';
        $this->view->render($response, 'error.twig', [
            'pagetitle' => 'LeRelais - Inscription',
            'errors' => $errors,
            'lang' => $this->lang
        ]);
    }

}