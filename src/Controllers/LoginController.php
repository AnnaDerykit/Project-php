<?php

namespace App\Controllers;

use App\Framework\Response;
use App\Model\UserRepository;
use Templates\LoginView;

class LoginController
{
    public static function index()
    {
        $response = new Response();
        $response->setContent(LoginView::render());
        return $response;
    }

    public static function set()
    {
        $message = '';
        $response = new Response();

        // trim usuwa space z początku i końca stringu
        // htmlspecialchars zamienia tagi HTML na encje
        $email = trim(htmlspecialchars($_POST['email']));
        $password = trim(htmlspecialchars($_POST['password']));

        if (empty($email) || empty($password)) {
            $message = 'Please fill all the fields.';
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = 'Your e-mail address is invalid.';
        } else {
            $repository = new UserRepository();
            $user = $repository->findOneByEmail($email);
            if (is_null($user)) {
                $message = 'This user does not exist.';
            } else if (password_verify($password, $user->getPassword())) {
                $_SESSION['uid'] = $user->getId();
                header('Location: index.php?action=show-profile');
            } else {
                $message = 'Your password is incorrect.';
            }
        }

        $response->setContent(LoginView::render([
            'message' => $message,
            'values' => [
                'email' => $email,
            ],
        ]));

        return $response;
    }

    public static function logout()
    {
        $response = new Response();

        session_unset();
        session_destroy();

        $response->addHeader('Location', 'index.php?action=front-page');

        return $response;
    }
}