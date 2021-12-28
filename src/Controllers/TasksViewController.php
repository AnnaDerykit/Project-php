<?php

namespace App\Controllers;
use Templates\TasksView;

class TasksViewController {
    public static function index() {
        echo TasksView::render();
        return;
    }
}