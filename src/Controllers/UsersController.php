<?php
namespace App\Controllers;

use App\Framework\Response;
use App\Model\UserRepository;
use Templates\UsersView;

class UsersController {
    public static function index() {
        $response = new Response();
        if (self::checkIfAdmin()) {
            $response->setContent(UsersView::render());
        } else {
            $response->addHeader('Location', 'index.php?action=show-profile');
        }
        return $response;
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