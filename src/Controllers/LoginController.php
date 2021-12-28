<?php

namespace App\Controllers;

use App\Model\UserRepository;
use Templates\LoginView;

class LoginController {
    public static function index() {
        echo LoginView::render();
        return;
    }

    public static function set() {
        $userRep = new \App\Model\UserRepository();
        $user = $userRep->findOneByEmail($_REQUEST['email']);
        if ($user && $user->getPassword() == $_REQUEST['password']) {
            $_SESSION['uid'] = $user->getId();
            header('Location: index.php?action=show-tasks');
        } elseif ($user) {
            var_dump('Wrong password');
        } else {
            var_dump('This user does not exist');
        }

        //die("Tu jest ustawianie sesji");
    }

    public static function logout() {
        session_unset();
        session_destroy();
        header('Location: index.php?action=front-page');
    }
}