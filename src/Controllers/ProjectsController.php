<?php

namespace App\Controllers;

use App\Framework\Response;
use Templates\ProjectsView;

class ProjectsController
{
    public static function index()
    {
        $response = new Response();
        $response->setContent(ProjectsView::render());
        return $response;
    }
}