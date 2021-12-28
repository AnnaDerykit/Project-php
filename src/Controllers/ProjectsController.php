<?php

namespace App\Controllers;

use Templates\ProjectsView;

class ProjectsController {
    public static function index() {
        echo ProjectsView::render();
        return;
    }
}