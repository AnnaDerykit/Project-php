<?php

namespace Templates;

use App\Controllers\ReportsController;
use App\Model\ClientRepository;
use App\Model\ProjectRepository;
use App\Model\TaskRepository;

class ReportsView
{
    public static function render($params = [])
    {
        ob_start();
        ?>
        <?= Layout::header($params) ?>
        <?= Layout::navbar() ?>
        <div class="thing">
            <div class="nag_task">
                <h2>Reports</h2>
            </div>

            <div class="f-form d-flex">
                <form method="GET" id="form" action="index.php?action=reports-filter">
                    <div class="project-name d-flex f-wrap">
                    <div class="f-header">Aggregation</div>
                        <label for="aggregation"></label><input type="checkbox" id="aggregation" name="aggregation" value="Aggregation">
                    </div>
                    <div class="project-name d-flex f-wrap">
                        <div class="f-header">Project Name</div>
                        <?php
                        $projectsRep = new ProjectRepository();
                        $projects = $projectsRep->findByUserId($_SESSION['uid']);
                        foreach ($projects as $project):
                            ?>
                            <div class="item"><label for="<?= $project->getId() ?>"></label><input type="checkbox" id="<?= $project->getId() ?>" name="<?= 'p' . $project->getId() ?>"><?= $project->getProjectName() ?></div>
                        <?php endforeach; ?>

                    </div>
                    <div class="client-name d-flex f-wrap">
                        <div class="f-header">Client name</div>
                        <?php
                        $clientsRep = new ClientRepository();
                        $clients = $clientsRep->findByUserId($_SESSION['uid']);
                        foreach ($clients as $client):
                            ?>
                            <div class="item"><label for="<?= $client->getId() ?>"></label><input type="checkbox" id="<?= $client->getId() ?>" name="<?= 'c' . $client->getId() ?>"><?= $client->getClientName() ?></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="started d-flex">
                        <div class="f-header">Started</div>
                        <div class="item"><input type="datetime-local" name="startFrom"></div>
                        <div class="item"><input type="datetime-local" name="startTo"></div>
                    </div>
                    <div class="ended d-flex">
                        <div class="f-header">Ended</div>
                        <div class="item"><input type="datetime-local" name="stopFrom"></div>
                        <div class="item"><input type="datetime-local" name="stopTo"></div>
                    </div>

                </form>
            </div>

            <div class="btn-re">
                <input class="register btn btn-purple" type="submit" value="Filter" onclick="getResults()">
            </div>
        <div class="task-table">
            <table id="task">
                <thead>
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
                        $timeFormatted = $durationInSec ? sprintf('%02d:%02d:%02d', ($durationInSec / 3600), intval($durationInSec / 60) % 60, $durationInSec % 60) : null;
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
                    </tbody>
                <?php endforeach; ?>
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