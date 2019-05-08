<?php
namespace App\Controllers;
define('ENCRYPT_METHOD', 'aes-256-cbc');
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
    protected $env;
    protected $lang;
    protected $db;
    protected $mail;
    protected $csrf;

    private $secret;
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->view = $container['view'];
        $this->logger = $container['logger'];
        $this->lang = 'fr';
        $this->csrf = $container['csrf'];
        $this->db = $container['database'];
        $transport = (new \Swift_SmtpTransport('smtp.relight.xyz', 465, 'ssl'))
            ->setUsername('rkezal@relight.xyz')
            ->setPassword('Alinea141'); //TODO: .htsmtp
        $this->mail = new \Swift_Mailer($transport);
        if($container['debug'])
            $container['logger']->info("CLIENT : " . $_SERVER['REMOTE_ADDR'] . " requested ".$_SERVER['REQUEST_METHOD']." ".$_SERVER['REQUEST_URI']);
        $this->secret = "abcdefghijklmnopqrstuvwxyz"; //TODO: ENV VAR
    }

    protected function sendemail($to, $sub, $msg) {
        $message = (new \Swift_Message($sub))
            ->setFrom(['rkezal@relight.xyz' => 'Le Relais Robot'])
            ->setTo($to)
            ->setBody($msg);
       try {
            $this->mail->send($message, $failure);
            return true;
        }
        catch (\Swift_TransportException $e) {
            $this->container['logger']->error($e->getMessage());
            return false;
        }
    }

    function encrypt($to_crypt) {
        $salt = openssl_random_pseudo_bytes(openssl_cipher_iv_length(ENCRYPT_METHOD));
        $to_crypt = openssl_encrypt($to_crypt, ENCRYPT_METHOD, $this->secret, 0, $salt);
        return $salt.$to_crypt;
    }

    function decrypt($to_decrypt) {
        $saltlen = openssl_cipher_iv_length(ENCRYPT_METHOD);
        return rtrim(openssl_decrypt(substr($to_decrypt, $saltlen), ENCRYPT_METHOD, $this->secret, 0, substr($to_decrypt, 0, $saltlen)), "\0");
    }
}