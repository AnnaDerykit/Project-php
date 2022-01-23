<?php

namespace App\Controllers;

use App\Framework\Response;
use App\Model\ProjectRepository;
use App\Model\TaskRepository;
use Templates\TasksView;

class TasksController
{
    public static function index()
    {
        $response = new Response();
        $response->setContent(TasksView::render([
                'script' => '../../public/javascript/Tasks.js'
            ]
        ));
        return $response;
    }


    public static function editTask()
    {
        //TODO: dokończyć walideację żeby się wyświetlało że projekt nie istnieje
        $id = $_POST['id'];
        $response = new Response();
        $repository = new TaskRepository();
        $projectRep = new ProjectRepository();
        $projectId = $_POST['project'];
        $project = $projectRep->findById($projectId);
        if ($project) {
            $title = $_POST['title'];
            $startTime = $_POST['start'];
            $stopTime = $_POST['stop'];
            $task = $repository->findById($id);
            $task
                ->setProjectId($projectId)
                ->setTitle($title)
                ->setStartTime($startTime)
                ->setStopTime($stopTime);
            $repository->save($task);
        } else {
            $message = 'Selected project must exist.';
            $response->setContent(TasksView::render([
                'message' => $message
            ]));
            return $response;
        }
        $response->addHeader('Location', 'index.php?action=show-tasks');
        return $response;
    }
}