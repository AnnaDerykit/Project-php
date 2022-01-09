<?php

namespace App\Controllers;

use App\Framework\Response;
use Templates\ClientsView;

class ClientsController
{
    public static function index()
    {
        $response = new Response();
        $response->setContent(ClientsView::render());
        return $response;
    }
}