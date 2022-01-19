<?php

namespace App\Controllers;

use App\Framework\Response;
use Templates\ReportsView;

class ReportsController
{
    public static function index()
    {
        $response = new Response();
        $response->setContent(ReportsView::render());
        return $response;
    }
}