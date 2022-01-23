<?php

namespace App\Controllers;

use App\Framework\Response;
use App\Model\ClientRepository;
use App\Model\ProjectRepository;
use Templates\ProjectsView;

class ProjectsController
{
    public static function index()
    {
        $response = new Response();
        $response->setContent(ProjectsView::render([
                'script' => '../../public/javascript/Projects.js'
            ]
        ));
        return $response;
    }


    public static function editProject()
    {
        //TODO: zrobić żeby się wyświetlało że nie ma klienta
        $id = $_POST['id'];
        $response = new Response();
        $repository = new ProjectRepository();
        $clientRep = new ClientRepository();
        $projectName = $_POST['projectName'];
        $clientId = $_POST['client'];
        $client = $clientRep->findById($clientId);
        if ($client) {
            $wage = $_POST['wage'];
            $project = $repository->findById($id);
            $project
                ->setProjectName($projectName)
                ->setClientId($clientId)
                ->setWage($wage);
            $repository->save($project);
        } else {
            $message = 'Selected client must exist.';
            $response->setContent(ProjectsView::render([
                'message' => $message
            ]));
            return $response;
        }
        $response->addHeader('Location', 'index.php?action=show-projects');
        return $response;
    }
}