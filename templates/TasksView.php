<?php

namespace Templates;

use App\Model\ProjectRepository;
use App\Model\Task;
use App\Model\TaskRepository;

class TasksView
{
    public static function render($params = [])
    {
        ob_start();
        ?>
        <?= Layout::header($params) ?>
        <?= Layout::navbar() ?>
        <?php
        $tasksRep = new TaskRepository();
        $activeTask = $tasksRep->getUsersCurrentTask($_SESSION['uid']);
        $projectsRep = new ProjectRepository();
        $projectId = $activeTask ? $activeTask->getProjectId() : null;
        $activeProject = $projectId ? $projectsRep->findById($projectId) : null;
        ?>

        <div class="thing">
            <div class="tasks">
                <form method="POST" action="index.php?action=Add-Current-Task">
                    <div class="new-task d-flex">

                        <div class="task-controls d-flex">

                            <div class="task-name m0">
                                <input type="text" name="Task-Title" id="Task-Title" class="input-compact-text"
                                       placeholder="What are you doing?" maxlength="200"
                                       value="<?= $activeTask ? $activeTask->getTitle() : null ?>">
                            </div>
                            <div class="project-name m0">
                                <input type="text" list="Projects" name="Project_Name" id="Project_Name"
                                       class="input-compact-text"
                                       placeholder="Find your project here..."
                                       value="<?= $activeProject ? $activeProject->getProjectName() : null ?>">
                                <datalist id="Projects">
                                    <?php
                                    $projectsRep = new ProjectRepository();
                                    $projects = $projectsRep->findByUserId($_SESSION['uid']);
                                    foreach ($projects as $project): ?>
                                        <option><?= $project->getProjectName() ?></option>
                                    <?php endforeach ?>
                                </datalist>
                            </div>
                        </div>
                        <div class="task-controls d-flex">

                            <div class="btn btn-peach">
                                <input type="image"
                                       src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGhlaWdodD0iNTEycHgiIGlkPSJMYXllcl8xIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MTIgNTEyOyIgdmVyc2lvbj0iMS4xIiB2aWV3Qm94PSIwIDAgNTEyIDUxMiIgd2lkdGg9IjUxMnB4IiB4bWw6c3BhY2U9InByZXNlcnZlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj48Zz48cGF0aCBkPSJNMTQ0LDEyNC45TDM1My44LDI1NkwxNDQsMzg3LjFWMTI0LjkgTTEyOCw5NnYzMjBsMjU2LTE2MEwxMjgsOTZMMTI4LDk2eiIvPjwvZz48L3N2Zz4="
                                       class="icon" name="submit" formaction="index.php?action=Add-Current-Task"> Start
                            </div>
                            <form name="form_main">
                                <div class="counter">
                                    <span id="hour">00</span>:<span id="minute">00</span>:<span id="second">00</span>
                                </div>
                                <br/>
                            </form>
                            <div class="btn btn-purple "><input type="image"
                                                                src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgaWQ9IkNhcGFfMSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMTAwIDEwMDsiIHZlcnNpb249IjEuMSIgdmlld0JveD0iMCAwIDEwMCAxMDAiIHhtbDpzcGFjZT0icHJlc2VydmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPjxwYXRoIGQ9Ik04MC4xLDgxaC02MGMtMC42LDAtMS0wLjQtMS0xVjIwYzAtMC42LDAuNC0xLDEtMWg2MGMwLjYsMCwxLDAuNCwxLDF2NjBDODEuMSw4MC42LDgwLjcsODEsODAuMSw4MXogTTIxLjEsNzloNThWMjFoLTU4Vjc5ICB6Ii8+PC9zdmc+"
                                                                class="icon" name="submit"
                                                                formaction="index.php?action=Stop-Task"> Stop
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="d-flex f-wrap">
                <form method="POST" action="index.php?action=filter-tasks" class="d-flex">
                    <input type="text" name="ttitle" id="ttitle" class="input-compact-text" maxlength="200"
                           placeholder="Type here to search..."
                           value="<?= isset($params['phrase']) ? $params['phrase'] : null ?>">
                    <input type="submit" class="btn-rep" name="submit" value="Search">
                </form>
                <div class="filler"></div>
                <form method="POST" action="index.php?action=Show-Add-Task">
                    <input type="submit" id="submit" class="btn-rep" name="submit" value="Add">
                </form>
            </div>
            <p></p>
            <div class="task-table">
                <table id="task">
                    <thead>
                    <th class="trash"></th>
                    <th>Title</th>
                    <th>Project</th>
                    <th>Client</th>
                    <th>Wage</th>
                    <th>Started</th>
                    <th>Ended</th>
                    <th>Duration</th>
                    <th>Payout</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($params['tasks'])) {
                        $tasks = $params['tasks'];
                        $tasksRep = new TaskRepository();
                    } else {
                        $tasksRep = new TaskRepository();
                        $tasks = $tasksRep->getUsersDoneTasks($_SESSION['uid']);
                    }
                    foreach ($tasks as $task):
                        $id = $task->getId();
                        ?>

                        <tr contenteditable="true" onfocusout=editOnFocusOut(<?= $id ?>) id=<?= $id ?>>
                            <?php
                            $project = $tasksRep->getProjectByTaskId($task->getId());
                            $client = $tasksRep->getClientByTaskId($task->getId());
                            $wage = $project ? $project->getWage() : null;
                            $durationInSec = $task->getStopTime() ? strtotime($task->getStopTime()) - strtotime($task->getStartTime()) : null;
                            $payout = ($durationInSec && $wage) ? number_format(round($wage * $durationInSec / 3600, 2), 2) : null;
                            $timeFormatted = $durationInSec ? sprintf('%02d:%02d:%02d', intval($durationInSec / 3600), intval($durationInSec / 60) % 60, $durationInSec % 60) : null;
                            $startTime = $task->getStartTime();
                            $startTime = substr_replace($startTime, 'T', 10, 1);
                            $stopTime = $task->getStopTime();
                            $stopTime = $stopTime ? substr_replace($stopTime, 'T', 10, 1) : 'T';
                            ?>
                            <td contenteditable="false" class="del">
                                <a href="#" class="del_link" onclick=deleteOnClick(<?= $id ?>)><img
                                            class="icon icon-table"
                                            src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDQ4IDQ4IiBoZWlnaHQ9IjQ4cHgiIHZlcnNpb249IjEuMSIgdmlld0JveD0iMCAwIDQ4IDQ4IiB3aWR0aD0iNDhweCIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+PGcgaWQ9IkV4cGFuZGVkIj48Zz48Zz48cGF0aCBkPSJNNDEsNDhIN1Y3aDM0VjQ4eiBNOSw0NmgzMFY5SDlWNDZ6Ii8+PC9nPjxnPjxwYXRoIGQ9Ik0zNSw5SDEzVjFoMjJWOXogTTE1LDdoMThWM0gxNVY3eiIvPjwvZz48Zz48cGF0aCBkPSJNMTYsNDFjLTAuNTUzLDAtMS0wLjQ0Ny0xLTFWMTVjMC0wLjU1MywwLjQ0Ny0xLDEtMXMxLDAuNDQ3LDEsMXYyNUMxNyw0MC41NTMsMTYuNTUzLDQxLDE2LDQxeiIvPjwvZz48Zz48cGF0aCBkPSJNMjQsNDFjLTAuNTUzLDAtMS0wLjQ0Ny0xLTFWMTVjMC0wLjU1MywwLjQ0Ny0xLDEtMXMxLDAuNDQ3LDEsMXYyNUMyNSw0MC41NTMsMjQuNTUzLDQxLDI0LDQxeiIvPjwvZz48Zz48cGF0aCBkPSJNMzIsNDFjLTAuNTUzLDAtMS0wLjQ0Ny0xLTFWMTVjMC0wLjU1MywwLjQ0Ny0xLDEtMXMxLDAuNDQ3LDEsMXYyNUMzMyw0MC41NTMsMzIuNTUzLDQxLDMyLDQxeiIvPjwvZz48Zz48cmVjdCBoZWlnaHQ9IjIiIHdpZHRoPSI0OCIgeT0iNyIvPjwvZz48L2c+PC9nPjwvc3ZnPg=="</a>
                            </td>
                            <td contenteditable="true" onfocusout=editOnFocusOut(<?= $id ?>)
                                class="title_tsk"><?= $task->getTitle() ?></td>
                            <td onfocusout=editOnFocusOut(<?= $id ?>)>
                                <input class="project_tsk input-compact" list="Projects"
                                       value="<?= $project ? $project->getProjectName() : '' ?>">
                                <datalist id="Projects">
                                    <?php
                                    $ProjectsRep = new ProjectRepository();
                                    $Projects = $ProjectsRep->findByUserId($_SESSION['uid']);
                                    foreach ($Projects as $Project): ?>
                                        <option><?= $Project->getProjectName() ?></option>
                                    <?php endforeach ?>
                                </datalist>
                            </td>
                            <td contenteditable="false"
                                class="client_tsk"><?= $client ? $client->getClientName() : '' ?></td>
                            <td contenteditable="false" class="wage_tsk"><?= $wage ?: '' ?></td>
                            <td>
                                <input type="datetime-local" class="start_tsk input-compact" name="startTime"
                                       onfocusout=editOnFocusOut(<?= $id ?>) value="<?= $startTime ?>" step="1">
                            </td>
                            <td>
                                <?php if ($stopTime == 'T') {
                                    echo '';
                                } else { ?>
                                    <input type="datetime-local" class="stop_tsk input-compact" name="stopTime"
                                           onfocusout=editOnFocusOut(<?= $id ?>) value="<?= $stopTime ?>" step="1">
                                <?php } ?>
                            </td>
                            <td contenteditable="false" class="duration_tsk"><?= $timeFormatted ?: '' ?></td>
                            <td contenteditable="false" class="payout_tsk"><?= $payout ?: '' ?></td>
                        </tr>

                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
        <script>
            <?php
            $uid = $_SESSION['uid'];
            $repository = new TaskRepository();
            $tasks = $repository->findByUserId($uid);
            $Task = 0;
            $flag = 0;
            foreach ($tasks as $task):
                if ($task->getProgress() == 'active') {
                    $flag = 1;
                    $Task = $task->getStartTime();
                }
            endforeach;
            if ($flag == 1) {
                date_default_timezone_set("Europe/Warsaw");
                $date = date('Y-m-d H:i:s');
                $durationInSec = strtotime($date) - strtotime($Task);
                $timeFormatted = $durationInSec ? sprintf('%02d:%02d:%02d', intval($durationInSec / 3600), intval($durationInSec / 60) % 60, $durationInSec % 60) : null;
                $sec = substr($timeFormatted, -2);
                $min = substr($timeFormatted, -5, -3);
                $sep = 0;
                for ($i = 0; $i < strlen($timeFormatted); $i++) {
                    if ($timeFormatted[$i] == ":") {
                        $sep = $i;
                        $i = strlen($timeFormatted);
                    }
                }
                $hours = substr($timeFormatted, 0, $sep);
            }

            ?>
            var flag = "<?php echo $flag; ?>";
            if (flag == 1) {
                var php_sec = "<?php echo $sec; ?>";
                var php_min = "<?php echo $min; ?>";
                var php_hour = "<?php echo $hours; ?>";

                "use strict";

                let hour = parseInt(php_hour);
                let minute = parseInt(php_min);
                let second = parseInt(php_sec);
                let millisecond = 0;

                let cron;
                start();

                function start() {
                    cron = setInterval(() => {
                        timer();
                    }, 1000);
                }

                function timer() {
                    if ((second += 1) == 60) {
                        second = 0;
                        minute++;
                    }
                    if (minute == 60) {
                        minute = 0;
                        hour++;
                    }
                    document.getElementById('hour').innerText = returnData(hour);
                    document.getElementById('minute').innerText = returnData(minute);
                    document.getElementById('second').innerText = returnData(second);
                }

                function returnData(input) {
                    return input >= 10 ? input : `0${input}`
                }

            }


        </script>
        <?= Layout::footer() ?>
        <?php
        $html = ob_get_clean();
        return $html;
    }
}