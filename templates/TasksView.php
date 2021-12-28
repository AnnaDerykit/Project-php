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
                    <td><?= $task->getTitle() ?></td>
                    <td><?= $tasksRep->getProjectNameById($task->getId()) ?></td>
                    <td><?= $tasksRep->getClientNameById($task->getId()) ?></td>
                    <td><?= $tasksRep->getWageById($task->getId()) ?></td>
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