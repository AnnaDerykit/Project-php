<?php

namespace App\Controllers;

use App\Framework\Response;
use Templates\TasksView;

class TasksController
{
    public static function index()
    {
        $response = new Response();
        $response->setContent(TasksView::render());
        return $response;
    }
}