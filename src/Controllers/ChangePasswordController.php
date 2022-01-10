<?php
namespace App\Controllers;
use App\Framework\Response;
use Templates\ChangePasswordView;

class ChangePasswordController
{
    public static function index()
    {
        $response = new Response();
        $response->setContent(ChangePasswordView::render());
        return $response;
    }

    public static function changePassword()
    {
        //TODO: tylko admin/użytkownik zalogowany na siebie może to zrobić
    }
}
