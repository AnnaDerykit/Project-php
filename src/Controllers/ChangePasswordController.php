<?php
namespace App\Controllers;
use App\Framework\Response;
use App\Model\User;
use App\Model\UserRepository;
use Templates\ChangePasswordView;

class ChangePasswordController
{
    public static function index()
    {
        $response = new Response();
        $response->setContent(ChangePasswordView::render([
                'script' => '../../public/javascript/ChangePassword.js'
            ]
        ));
        return $response;
    }

    public static function changePassword()
    {
        //TODO: tylko admin/użytkownik zalogowany na siebie może to zrobić
        $id = $_POST['id'];
        $password = $_POST['password'];
        $password = trim(htmlspecialchars($password));
        $password = password_hash($password, PASSWORD_BCRYPT);
        $user = new User();
        $user
            ->setId($id)
            ->setPassword($password);
        $repository = new UserRepository();
        $repository->savePassword($user);
        $response = new Response();
        $response->addHeader('Location', 'index.php?action=show-profile');
        return $response;
    }
}
