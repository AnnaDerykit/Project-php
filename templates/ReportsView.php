<?php

namespace Templates;

use App\Controllers\ReportsController;
use App\Model\ClientRepository;
use App\Model\ProjectRepository;

class ReportsView
{
    public static function render($params = [])
    {
        ob_start();
        ?>
        <?= Layout::header($params) ?>
        <?= Layout::navbar() ?>
        <div class="thing">
        <div class="task-table">
            <table id="task">
                <thead>
                <th></th>
                <th>Clients</th>
                <th>Projects</th>
                </tr>
                </thead>
                <?php
                $tasksRep = new TaskRepository();
                $tasks = $tasksRep->findByUserId($_SESSION['uid']);
                foreach ($tasks as $task): ?>
                    <tbody>
                    <tr>
                        <?php
                        $project = $tasksRep->getProjectByTaskId($task->getId());
                        $client = $tasksRep->getClientByTaskId($task->getId());
                        $wage = $project ? $project->getWage() : null;
                        $durationInSec = $task->getStopTime() ? strtotime($task->getStopTime()) - strtotime($task->getStartTime()) : null;
                        $payout = ($durationInSec && $wage) ? number_format(round($wage * $durationInSec / 3600, 2), 2) : null;
                        $timeFormatted = $durationInSec ? sprintf('%02d:%02d:%02d', ($durationInSec / 3600), ($durationInSec / 60 % 60), $durationInSec % 60) : null;
                        ?>
                        <td><?= $project ? $project->getProjectName() : '' ?></td>
                        <td><?= $client ? $client->getClientName() : '' ?></td>
                        <td><?= $wage ?: '' ?></td>
                        <td><?= $task->getStartTime() ?></td>
                        <td><?= $task->getStopTime() ?></td>
                        <td><?= $timeFormatted ?: '' ?></td>
                        <td><?= $payout ?: '' ?></td>
                    </tr>
                    </tbody>
                <?php endforeach ?>
            </table>
        </div>
        </div>
        </div>
        </div>

        <?= Layout::footer() ?>
        <?php
        $html = ob_get_clean();
        return $html;
    }
}