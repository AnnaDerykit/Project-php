<?php
namespace App\Controllers;

use Templates\ProfileView;

class ProfileController {
    public static function index() {
        echo ProfileView::render();
        return;
    }
}
