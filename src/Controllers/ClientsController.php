<?php

namespace App\Controllers;

use App\Framework\Response;
use App\Model\ClientRepository;
use Templates\ClientsView;

class ClientsController
{
    public static function index()
    {
        $response = new Response();
        $response->setContent(ClientsView::render([
                'script' => '../../public/javascript/Clients.js'
            ]
        ));
        return $response;
    }


    public static function editClient()
    {
        $id = $_POST['id'];
        $repository = new ClientRepository();
        $clientName = $_POST['clientName'];
        $client = $repository->findById($id);
        $client->setClientName($clientName);
        $repository->save($client);
        $response = new Response();
        $response->addHeader('Location', 'index.php?action=show-clients');
        return $response;
    }
}