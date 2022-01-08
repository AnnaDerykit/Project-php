<?php

namespace App\Controllers;

use App\Framework\Response;
use App\Model\UserRepository;
use Templates\UsersView;

class UsersController
{
    public static function index()
    {
        $response = new Response();
        if (self::checkIfAdmin()) {
            $response->setContent(UsersView::render([
                    'script' => '../../public/javascript/Users.js'
                ]
            ));
        } else {
            $response->addHeader('Location', 'index.php?action=show-profile');
        }
        return $response;
    }

    public static function editUser()
    {
        //TODO: walidacja czy faktycznie $_POST ma to co trzeba
        $id = $_POST['id'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        $row = [
            'id' => $id,
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'role' => $role
        ];
        $user = UserRepository::userFromRow($row);
        $repository = new UserRepository();
        $repository->save($user);
        $response = new Response();
        $response->addHeader('Location', 'index.php?action=show-users');
        return $response;
    }

    public static function deleteUser()
    {
        //TODO: walidacja czy faktycznie $_POST ma to co trzeba
        $id = $_POST['id'];
        $repository = new UserRepository();
        $repository->deleteById($id);
        $response = new Response();
        $response->addHeader('Location', 'index.php?action=show-users');
        return $response;
    }

    public static function checkIfAdmin()
    {
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