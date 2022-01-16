<?php
namespace App\Controllers;
use App\Framework\Response;
use App\Model\User;
use App\Model\UserRepository;
use Templates\ChangePasswordView;

class ChangePasswordController
{
    const PASSWORD_LENGTH = 6;

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
        $uid = $_SESSION['uid'];
        if ($id == $uid) {
            $password = $_POST['password'];
            $repeated_password = $_POST['repeat_password'];
            $response = new Response();
            $message = '';
            if (empty($password) || empty($repeated_password)) {
                $message = 'Please fill all the fields.';
            } else if (strlen($password) < self::PASSWORD_LENGTH) {
                $message = 'Password must be at least ' . self::PASSWORD_LENGTH . ' characters long.';
            } else if ($password !== $repeated_password) {
                $message = 'Passwords must match.';
            } else {
                $user = new User();
                $password = trim(htmlspecialchars($password));
                $password = password_hash($password, PASSWORD_BCRYPT);
                $user
                    ->setId($id)
                    ->setPassword($password);
                $repository = new UserRepository();
                $repository->savePassword($user);
                $response->addHeader('Location', 'index.php?action=show-profile');

                return $response;
            }

            $response->setContent(ChangePasswordView::render([
                'message' => $message
            ]));

        } else {
            if (UsersController::checkIfAdmin()) {
                $password = $_POST['password'];
                $repeated_password = $_POST['repeat_password'];
                $response = new Response();
                $message = '';
                if (empty($password) || empty($repeated_password)) {
                    $message = 'Please fill all the fields.';
                } else if (strlen($password) < self::PASSWORD_LENGTH) {
                    $message = 'Password must be at least ' . self::PASSWORD_LENGTH . ' characters long.';
                } else if ($password !== $repeated_password) {
                    $message = 'Passwords must match.';
                } else {
                    $user = new User();
                    $password = trim(htmlspecialchars($password));
                    $password = password_hash($password, PASSWORD_BCRYPT);
                    $user
                        ->setId($id)
                        ->setPassword($password);
                    $repository = new UserRepository();
                    $repository->savePassword($user);
                    $response->addHeader('Location', 'index.php?action=show-profile');

                    return $response;
                }

                $response->setContent(ChangePasswordView::render([
                    'message' => $message
                ]));

            } else {
                $message = 'Insufficient rights to perform the action';
            }

            $response->setContent(ChangePasswordView::render([
                'message' => $message
            ]));
        }

        return $response;
    }
}
