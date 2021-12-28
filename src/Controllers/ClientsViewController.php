<?php
namespace App\Controllers;

use Templates\ClientsView;

class ClientsViewController {
    public static function index() {
        echo ClientsView::render();
        return;
    }
}