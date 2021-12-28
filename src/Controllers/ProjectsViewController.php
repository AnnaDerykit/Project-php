<?php

namespace App\Controllers;

use Templates\ProjectsView;

class ProjectsViewController {
    public static function index() {
        echo ProjectsView::render();
        return;
    }
}