<?php
namespace Templates;

use App\Model\TaskRepository;

class TasksView {
    public static function render($params = []) {
        ob_start();
        ?>
        <?= Layout::header() ?>
        <?= Layout::navbar() ?>
        <h1>List of tasks</h1>
        <table>
            <tr>
                <th>Title</th>
                <th>Project name</th>
                <th>Client name</th>
                <th>Wage</th>
                <th>Started</th>
                <th>Ended</th>
            </tr>
            <?php
            $tasksRep = new TaskRepository();
            $tasks = $tasksRep->findByUserId($_SESSION['uid']);
            foreach ($tasks as $task): ?>
                <tr>
                    <?php
                    $project = $tasksRep->getProjectByTaskId($task->getId());
                    $client = $tasksRep->getClientByTaskId($task->getId());
                    ?>
                    <td><?= $task->getTitle() ?></td>
                    <td><?= $project ? $project->getProjectName() : '' ?></td>
                    <td><?= $client ? $client->getClientName() : '' ?></td>
                    <td><?= $project ? $project->getWage() : '' ?></td>
                    <td><?= $task->getStartTime() ?></td>
                    <td><?= $task->getStopTime() ?></td>
                </tr>
            <?php endforeach ?>
        </table>
        <?= Layout::footer() ?>
        <?php
        $html = ob_get_clean();
        return $html;
    }
}