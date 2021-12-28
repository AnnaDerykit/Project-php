<?php

namespace App\Controllers;
use Templates\TasksView;

class TasksController {
    public static function index() {
        echo TasksView::render();
        return;
    }
}