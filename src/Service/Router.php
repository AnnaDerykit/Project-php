<?php
namespace App\Service;

use App\Controllers\ChangePasswordController;
use App\Controllers\LoginController;
use App\Controllers\ProfileController;
use App\Controllers\RegisterController;
use App\Controllers\UsersController;

class Router
{
    public static function resolveRoute($action)
    {
        switch ($action) {
            case 'delete-user':
                $controllerName = UsersController::class;
                $actionName = 'deleteUser';
                break;
            case 'edit-profile':
                $controllerName = ProfileController::class;
                $actionName = 'editProfile';
                break;
            case 'edit-user':
                $controllerName = UsersController::class;
                $actionName = 'editUser';
                break;
            case 'login-set':
                $controllerName = LoginController::class;
                $actionName = 'set';
                break;
            case 'login':
                $controllerName = 'App\Controllers\LoginController';
                $actionName = 'index';
                break;
            case 'logout':
                $controllerName = 'App\Controllers\LoginController';
                $actionName = 'logout';
                break;
            case 'password-change-form':
                $controllerName = ChangePasswordController::class;
                $actionName = 'index';
                break;
            case 'register-set':
                $controllerName = RegisterController::class;
                $actionName = 'register';
                break;
            case 'register':
                $controllerName = 'App\Controllers\RegisterController';
                $actionName = 'index';
                break;
            case 'show-clients':
                $controllerName = 'App\Controllers\ClientsController';
                $actionName = 'index';
                break;
            case 'show-profile':
                $controllerName = 'App\Controllers\ProfileController';
                $actionName = 'index';
                break;
            case 'show-projects':
                $controllerName = 'App\Controllers\ProjectsController';
                $actionName = 'index';
                break;
            case 'show-tasks':
                $controllerName = 'App\Controllers\TasksController';
                $actionName = 'index';
                break;
            case 'show-users':
                $controllerName = 'App\Controllers\UsersController';
                $actionName = 'index';
                break;
            default:
                $controllerName = 'App\Controllers\FrontpageController';
                $actionName = 'index';
                break;
        }

        return [$controllerName, $actionName];
    }
}