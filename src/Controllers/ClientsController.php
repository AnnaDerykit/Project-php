<?php
namespace App\Controllers;

use Templates\ClientsView;

class ClientsController {
    public static function index() {
        echo ClientsView::render();
        return;
    }
}