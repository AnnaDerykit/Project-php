<?php

namespace App\Controllers;

use App\Dictionary\UserRoles;
use App\Framework\Response;
use App\Model\User;
use App\Model\UserRepository;
use Templates\RegisterView;

class RegisterController
{
    const PASSWORD_LENGTH = 6;

    public static function index()
    {
        $response = new Response();
        $response->setContent(RegisterView::render());

        return $response;
    }

    public static function register()
    {
        $message = '';
        $response = new Response();

        $username = trim(htmlspecialchars($_POST['username']));
        $email = trim(htmlspecialchars($_POST['email']));
        $password = trim(htmlspecialchars($_POST['password']));
        $repeated_password = trim(htmlspecialchars($_POST['repeat_password']));

        if (empty($username) || empty($email) || empty($password) || empty($repeated_password)) {
            $message = 'Uzupełnij wszystkie pola formularza';
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = 'Wprowadź poprawny adres E-mail';
        } else if (strlen($password) < self::PASSWORD_LENGTH) {
            $message = 'Hasło musi zawierać co najmniej ' . self::PASSWORD_LENGTH . ' znaków.';
        } else if ($password !== $repeated_password) {
            $message = 'Wprowadzone hasła różnią się';
        } else {
            $repository = new UserRepository();
            $user = $repository->findOneByEmail($email);

            // Sprawdzamy czy E-mail istnieje
            if (!is_null($user)) {
                $message = 'Podany adres E-mail jest zajęty.';
            } else if (!is_null($repository->findByName($username))) {
                $message = 'Podana nazwa użytkownika jest już w użyciu.';
            } else {
                $user = new User();
                $user->setUsername($username);
                $user->setEmail($email);
                $user->setPassword(password_hash($password, PASSWORD_BCRYPT));
                $user->setRole(UserRoles::USER);

                $newUser = $repository->save($user);

                $_SESSION['uid'] = $newUser->getId();
                header('Location: index.php?action=show-profile');
            }
        }

        $response->setContent(RegisterView::render([
            'message' => $message,
            'values' => [
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'repeat_password' => $repeated_password,
            ],
        ]));

        return $response;
    }
}
