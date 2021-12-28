<?php

namespace App\Controllers;

use App\Model\UserRepository;
use Templates\LoginView;
use Templates\RegisterView;

class RegisterController {
    public static function index() {
        echo RegisterView::render();
        return;
    }
    
    public static function set() {
        $userRep = new UserRepository();
        $user = $userRep->findOneByEmail($_REQUEST['email']);
        if ($user) {
            var_dump("This email is already taken");
        } elseif ($_REQUEST['rep-password'] == $_REQUEST['password']) {
            var_dump('ok');
//            $_SESSION['uid'] = $user->getId();
//            header('Location: index.php?action=show-profile');
        } else {
            var_dump('Wrong password');
        }

        //die("Tu jest ustawianie sesji");
    }

    public static function logout() {
        session_unset();
        session_destroy();
        header('Location: index.php?action=front-page');
    }
}