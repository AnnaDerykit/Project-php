<?php
namespace App\Service;

class Router {
    public static function resolveRoute($action) {
        switch ($action) {
            case 'login-set':
                $controllerName = 'App\Controllers\LoginController';
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
            case 'register-set':
                $controllerName = 'App\Controllers\RegisterController';
                $actionName = 'set';
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
        return array($controllerName, $actionName);
    }
}