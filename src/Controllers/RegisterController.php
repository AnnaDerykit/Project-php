<?php

namespace App\Controllers;

use App\Framework\Response;
use App\Model\UserRepository;
use Templates\RegisterView;

class RegisterController {
    public static function index() {
        $response = new Response();
        $response->setContent(RegisterView::render());
        return $response;
    }

    //TODO: walidacja, bo to się wywali
    public static function set() {
        $response = new Response();
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
        return $response;
        //die("Tu jest ustawianie sesji");
    }
}