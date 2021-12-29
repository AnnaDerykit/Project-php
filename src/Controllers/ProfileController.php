<?php
namespace App\Controllers;

use App\Framework\Response;
use Templates\ProfileView;

class ProfileController {
    public static function index() {
        $response = new Response();
        $response->setContent(ProfileView::render());
        return $response;
    }
}
