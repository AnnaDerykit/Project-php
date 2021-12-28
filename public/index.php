<?php

//load config

require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'autoload.php';
require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';

session_start();
ini_set('display_errors', 1);
$action = isset($_GET['action']) ? $_GET['action'] : null;

switch ($action) {
    case 'front-page':
        \App\Controllers\FrontpageController::index();
        break;
    case 'login-set':
        \App\Controllers\LoginController::set();
        break;
    case 'login':
        \App\Controllers\LoginController::index();
        break;
    case 'logout':
        \App\Controllers\LoginController::logout();
        break;
    case 'register-set':
        \App\Controllers\RegisterController::set();
        break;
    case 'register':
        \App\Controllers\RegisterController::index();
        break;
    case 'show-clients':
        \App\Controllers\ClientsController::index();
        break;
    case 'show-profile':
        \App\Controllers\ProfileController::index();
        break;
    case 'show-projects':
        \App\Controllers\ProjectsController::index();
        break;
    case 'show-tasks':
        \App\Controllers\TasksController::index();
        break;
    case 'show-users':
        \App\Controllers\UsersController::index();
        break;
    default:
        header('Location: index.php?action=front-page');
        break;
}