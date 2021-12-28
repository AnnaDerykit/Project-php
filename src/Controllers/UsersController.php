<?php
namespace App\Controllers;

use App\Model\UserRepository;
use Templates\UsersView;

class UsersController {
    public static function index() {
        if (self::checkIfAdmin()) {
            echo UsersView::render();
        } else {
            header('Location: index.php?action=show-profile');
        }
        return;
    }

    public static function checkIfAdmin() {
        if (isset($_SESSION['uid'])) {
            $usersRep = new UserRepository();
            $user = $usersRep->findById($_SESSION['uid']);
            if ($user->getRole() == 'admin') {
                return true;
            }
        }
        return false;
    }
}