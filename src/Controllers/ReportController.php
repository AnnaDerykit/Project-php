<?php
namespace App\Controllers;

use App\Framework\Response;
use App\Model\ClientRepository;
use App\Model\ProjectRepository;
use App\Model\Task;
use App\Model\TaskRepository;
use Templates\ReportView;

class ReportController
{
    public static function index()
    {
        $response = new Response();
        $response->setContent(ReportView::render([]));
        return $response;
    }

    public static function generate()
    {
        unset($_SESSION['reports']);

        $response = new Response();

        if (!empty($_POST) && isset($_POST['report_type'])) {
            switch ($_POST['report_type']) {
                case 'client':
                    $response->setContent(ReportView::render([
                        'client' => self::prepareClientData()
                    ]));
                break;

                case 'tasks_in_time':
                    $response->setContent(ReportView::render([
                        'tasks_in_time' => self::prepareTasksInTime()
                    ]));
                break;

                case 'task_payout':
                    $response->setContent(ReportView::render([
                        'task_payout' => self::prepareTasksInPayoutRange()
                    ]));
                break;
            }
        }

        return $response;
    }

    private static function prepareClientData()
    {
        if (empty($_POST['client_name'])) {
            $_SESSION['reports']['client_name_required'] = 'Client name must be filled.';
            return 0;
        }

        $clientName = trim(htmlspecialchars($_POST['client_name']));

        $clientRepository = new ClientRepository();
        $clientData = $clientRepository->findByName($clientName);

        if (empty($clientData)) {
            return [
                'projects' => [],
            ];
        }

        $projectRepository = new ProjectRepository();
        $projects = $projectRepository->findByClientAndUserId((int)$clientData->getId(), (int)$_SESSION['uid']);

        return [
            'projects' => $projects,
        ];
    }

    private static function prepareTasksInTime()
    {
        if (empty($_POST['date_from']) || empty($_POST['date_to'])) {
            $_SESSION['reports']['date_required'] = 'All fields are required';
            return 0;
        }

        $date_from = (new \DateTime($_POST['date_from']))->format('Y-m-d H:i:s');
        $date_to = (new \DateTime($_POST['date_to']))->format('Y-m-d H:i:s');

        $taskRepository = new TaskRepository();
        $tasks = $taskRepository->filterTasksByTime($date_from, $date_to, (int) $_SESSION['uid']);

        return [
            'tasks' => $tasks,
        ];
    }

    private static function prepareTasksInPayoutRange()
    {
        if (empty($_POST['payout_min']) || empty($_POST['payout_max'])) {
            $_SESSION['reports']['payout_required'] = 'All fields are required';
            return 0;
        }

        $payout_min = floatval(trim($_POST['payout_min']));
        $payout_max = floatval(trim($_POST['payout_max']));

        $taskRepository = new TaskRepository();
        $tasks = $taskRepository->findByUserId((int) $_SESSION['uid']);

        $userTasks = [];

        /** @var Task $task */
        foreach ($tasks as $task) {
            $project = $taskRepository->getProjectByTaskId($task->getId());
            $wage = $project ? $project->getWage() : null;

            if (is_null($wage) || empty($task->getStopTime())) {
                continue;
            }

            $durationInSec = strtotime($task->getStopTime()) - strtotime($task->getStartTime());

            $taskPayout = round($wage * $durationInSec / 3600, 2);

            if ($payout_min <= $taskPayout && $payout_max >= $taskPayout) {
                $userTasks[] = [
                    'id' => $task->getId(),
                    'projectName' => $project->getProjectName(),
                    'title' => $task->getTitle(),
                    'wage' => $project->getWage(),
                    'payout' => $taskPayout,
                ];
            }
        }

        return [
            'tasks' => $userTasks,
        ];
    }
}
