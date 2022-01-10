<?php
namespace App\Controllers;

use App\Framework\Response;
use App\Model\UserRepository;
use Templates\ProfileView;

class ProfileController
{
    public static function index()
    {
        $response = new Response();
        $response->setContent(ProfileView::render([
                'script' => '../../public/javascript/Profile.js'
            ]
        ));
        return $response;
    }


    public static function editProfile()
    {
        //TODO: walidacja czy faktycznie $_POST ma to co trzeba
        $id = $_POST['id'];
        $repository = new UserRepository();
        $oldUser = $repository->findById($id);
        $oldPassword = $oldUser->getPassword();
        $password = $_POST['password'];
        if ($oldPassword != $password) {
            $password = trim(htmlspecialchars($password));
            $password = password_hash($password, PASSWORD_BCRYPT);
        }
        $username = $_POST['username'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $row = [
            'id' => $id,
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'role' => $role
        ];
        $user = UserRepository::userFromRow($row);
        $repository->save($user);
        $response = new Response();
        $response->addHeader('Location', 'index.php?action=show-profile');
        return $response;
    }

    //TODO
    public static function changePassword()
    {

    }
}
