<?php

namespace Templates;

use App\Model\TaskRepository;

class TasksView
{
    public static function render($params = [])
    {
        ob_start();
        ?>
        <?= Layout::header() ?>
        <?= Layout::navbar() ?>

        <div class="thing">
            <div class="tasks">
                <div class="new-task d-flex">
                    <div class="task-name">Do roboty team!</div>
                    <div class="task-controls d-flex">
                        <div class="btn btn-peach"><img
                                    src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGhlaWdodD0iNTEycHgiIGlkPSJMYXllcl8xIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MTIgNTEyOyIgdmVyc2lvbj0iMS4xIiB2aWV3Qm94PSIwIDAgNTEyIDUxMiIgd2lkdGg9IjUxMnB4IiB4bWw6c3BhY2U9InByZXNlcnZlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj48Zz48cGF0aCBkPSJNMTQ0LDEyNC45TDM1My44LDI1NkwxNDQsMzg3LjFWMTI0LjkgTTEyOCw5NnYzMjBsMjU2LTE2MEwxMjgsOTZMMTI4LDk2eiIvPjwvZz48L3N2Zz4="
                                    class="icon"> Start
                        </div>
                        <div class="btn btn-purple "><img
                                    src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgaWQ9IkNhcGFfMSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMTAwIDEwMDsiIHZlcnNpb249IjEuMSIgdmlld0JveD0iMCAwIDEwMCAxMDAiIHhtbDpzcGFjZT0icHJlc2VydmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPjxwYXRoIGQ9Ik04MC4xLDgxaC02MGMtMC42LDAtMS0wLjQtMS0xVjIwYzAtMC42LDAuNC0xLDEtMWg2MGMwLjYsMCwxLDAuNCwxLDF2NjBDODEuMSw4MC42LDgwLjcsODEsODAuMSw4MXogTTIxLjEsNzloNThWMjFoLTU4Vjc5ICB6Ii8+PC9zdmc+"
                                    class="icon"> Stop
                        </div>
                    </div>
                </div>
            </div>

            <div class="task-table">
                <table id="task">
                    <thead>
                    <th><form method="POST" action="index.php?action=Show-Add-Task">
                                <input type="submit" id="submit" class="btn-peach" name="submit" value="Add">
                        </form></th>
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
                            $timeFormatted = $durationInSec ? sprintf('%02d:%02d:%02d', ($durationInSec / 3600), ($durationInSec / 60 % 60), $durationInSec % 60) : null;
                            ?>
                            <td class="del">
                                <a href="#" class="del_link" onclick=deleteOnClick()><img class="icon icon-table" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDQ4IDQ4IiBoZWlnaHQ9IjQ4cHgiIHZlcnNpb249IjEuMSIgdmlld0JveD0iMCAwIDQ4IDQ4IiB3aWR0aD0iNDhweCIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+PGcgaWQ9IkV4cGFuZGVkIj48Zz48Zz48cGF0aCBkPSJNNDEsNDhIN1Y3aDM0VjQ4eiBNOSw0NmgzMFY5SDlWNDZ6Ii8+PC9nPjxnPjxwYXRoIGQ9Ik0zNSw5SDEzVjFoMjJWOXogTTE1LDdoMThWM0gxNVY3eiIvPjwvZz48Zz48cGF0aCBkPSJNMTYsNDFjLTAuNTUzLDAtMS0wLjQ0Ny0xLTFWMTVjMC0wLjU1MywwLjQ0Ny0xLDEtMXMxLDAuNDQ3LDEsMXYyNUMxNyw0MC41NTMsMTYuNTUzLDQxLDE2LDQxeiIvPjwvZz48Zz48cGF0aCBkPSJNMjQsNDFjLTAuNTUzLDAtMS0wLjQ0Ny0xLTFWMTVjMC0wLjU1MywwLjQ0Ny0xLDEtMXMxLDAuNDQ3LDEsMXYyNUMyNSw0MC41NTMsMjQuNTUzLDQxLDI0LDQxeiIvPjwvZz48Zz48cGF0aCBkPSJNMzIsNDFjLTAuNTUzLDAtMS0wLjQ0Ny0xLTFWMTVjMC0wLjU1MywwLjQ0Ny0xLDEtMXMxLDAuNDQ3LDEsMXYyNUMzMyw0MC41NTMsMzIuNTUzLDQxLDMyLDQxeiIvPjwvZz48Zz48cmVjdCBoZWlnaHQ9IjIiIHdpZHRoPSI0OCIgeT0iNyIvPjwvZz48L2c+PC9nPjwvc3ZnPg=="</a>
                            </td>
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
                    <?php endforeach ?>
                </table>
            </div>
        </div>
        </div>
        <?= Layout::footer() ?>
        <?php
        $html = ob_get_clean();
        return $html;
    }
}