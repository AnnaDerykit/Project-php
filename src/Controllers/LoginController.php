<?php

namespace App\Controllers;

use App\Framework\Response;
use App\Model\UserRepository;
use Templates\LoginView;

class LoginController {
    public static function index() {
        $response = new Response();
        $response->setContent(LoginView::render());
        return $response;
    }

    //TODO: walidacja wejścia, żeby się wszystko nie wywaliło na głupi ryj
    public static function set() {
        $response = new Response();
        $userRep = new \App\Model\UserRepository();
        $user = $userRep->findOneByEmail($_REQUEST['email']);
        if ($user && $user->getPassword() == $_REQUEST['password']) {
            $_SESSION['uid'] = $user->getId();
            $response->addHeader('Location', 'index.php?action=show-profile');
        } elseif ($user) {
            var_dump('Wrong password');
        } else {
            var_dump('This user does not exist');
        }
        return $response;
        //die("Tu jest ustawianie sesji");
    }

    public static function logout() {
        $response = new Response();
        session_unset();
        session_destroy();
        $response->addHeader('Location', 'index.php?action=front-page');
        return $response;
    }
}