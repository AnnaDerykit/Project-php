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
                <th>Duration</th>
                <th>Payout</th>
            </tr>
            <?php
            $tasksRep = new TaskRepository();
            $tasks = $tasksRep->findByUserId($_SESSION['uid']);
            foreach ($tasks as $task): ?>
                <tr>
                    <?php
                    $project = $tasksRep->getProjectByTaskId($task->getId());
                    $client = $tasksRep->getClientByTaskId($task->getId());
                    $wage = $project ? $project->getWage() : null;
                    $durationInSec = $task->getStopTime() ? strtotime($task->getStopTime()) - strtotime($task->getStartTime()) : null;
                    $payout = ($durationInSec && $wage) ? number_format(round($wage * $durationInSec / 3600, 2), 2) : null;
                    $timeFormatted = $durationInSec ? sprintf('%02d:%02d:%02d', ($durationInSec/3600),($durationInSec/60%60), $durationInSec%60) : null;
                    ?>
                    <td><?= $task->getTitle() ?></td>
                    <td><?= $project ? $project->getProjectName() : '' ?></td>
                    <td><?= $client ? $client->getClientName() : '' ?></td>
                    <td><?= $wage ?: '' ?></td>
                    <td><?= $task->getStartTime() ?></td>
                    <td><?= $task->getStopTime() ?></td>
                    <td><?= $timeFormatted ?: '' ?></td>
                    <td><?= $payout ?: '' ?></td>
                </tr>
            <?php endforeach ?>
        </table>
        <?= Layout::footer() ?>
        <?php
        $html = ob_get_clean();
        return $html;
    }
}