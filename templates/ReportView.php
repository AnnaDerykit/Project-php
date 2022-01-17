<?php

namespace Templates;

use App\Model\Task;

class ReportView
{
    public static function render($params = [])
    {
        ob_start();
        ?>
        <?= Layout::header($params) ?>
        <?= Layout::navbar() ?>
        <div class="thing report-container">
            <div class="nag_task">
                <h2>My reports</h2>
            </div>
            <div class="task-table">
                <form method="POST" action="index.php?action=reports-generator">
                    <h3 class="search-form-header">Projects of specific client</h3>

                    <input type="hidden" name="report_type" value="client">

                    <div class="mail_log">
                        <input type="text" name="client_name" placeholder="Client name" required>
                        <?php
                        if (isset($_SESSION['reports']['client_name_required'])) {
                            echo '<p class="text-center">' . $_SESSION['reports']['client_name_required'] . '</p>';
                        }
                        ?>
                    </div>
                    <input type="submit" name="search_by_client" value="Search" class="btn btn-purple report-search-submit">
                </form>

                <form method="POST" action="index.php?action=reports-generator">
                    <h3 class="search-form-header">Tasks by time</h3>

                    <input type="hidden" name="report_type" value="tasks_in_time">

                    <div class="mail_log">
                        <label for="date_from">Date from</label>
                        <input type="datetime-local" id="date_from" name="date_from" placeholder="Date from" required>

                        <label for="date_from">Date to</label>
                        <input type="datetime-local" id="date_to" name="date_to" placeholder="Date to" required>
                        <?php
                        if (isset($_SESSION['reports']['date_required'])) {
                            echo '<p class="text-center">' . $_SESSION['reports']['date_required'] . '</p>';
                        }

                        ?>
                    </div>

                    <input type="submit" name="search_by_tasks_in_time" value="Search" class="btn btn-purple report-search-submit">
                </form>

                <form method="POST" action="index.php?action=reports-generator">
                    <h3 class="search-form-header">Task payout</h3>

                    <input type="hidden" name="report_type" value="task_payout">

                    <div class="mail_log">
                        <label for="payout_min">Minimum Payout</label>
                        <input type="number" id="payout_min" name="payout_min" step="0.01" placeholder="Minimum Payout" required>

                        <label for="payout_max">Maximum Payout</label>
                        <input type="number" id="payout_max" name="payout_max" step="0.01" placeholder="Maximum Payout" required>
                        <?php
                        if (isset($_SESSION['reports']['payout_required'])) {
                            echo '<p class="text-center">' . $_SESSION['reports']['payout_required'] . '</p>';
                        }

                        ?>
                    </div>

                    <input type="submit" name="search_by_payout_range" value="Search" class="btn btn-purple report-search-submit">
                </form>


                <?php
                if (isset($params['client']['projects']) && empty($params['client']['projects'])) {
                    echo '<p class="text-center">There is no client projects to display</p>';
                } else if (isset($params['tasks_in_time']['tasks']) && empty($params['tasks_in_time']['tasks'])) {
                    echo '<p class="text-center">There is no tasks to display</p>';
                }  else if (isset($params['task_payout']['tasks']) && empty($params['task_payout']['tasks'])) {
                    echo '<p class="text-center">There is no tasks with given payout to display</p>';
                } elseif (isset($params['client']['projects']) && !empty($params['client']['projects'])) {
                    ?>
                    <table id="task" class="report-table">
                        <caption>Projects of given client</caption>
                        <tr>
                            <th>ID</th>
                            <th>Project name</th>
                            <th>Wage</th>
                        </tr>
                        <?php
                        ?>
                        <?php foreach ($params['client']['projects'] as $project): ?>
                            <tr>
                                <td><?php echo $project->getId(); ?></td>
                                <td><?php echo $project->getProjectName(); ?></td>
                                <td><?php echo $project->getWage(); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <?php
                } elseif (isset($params['task_payout']['tasks']) && !empty($params['task_payout']['tasks'])) {
                    ?>
                    <table id="task" class="report-table">
                        <caption>Tasks payout table</caption>
                        <tr>
                            <th>ID</th>
                            <th>Project name</th>
                            <th>Title</th>
                            <th>Wage</th>
                            <th>Payout</th>
                        </tr>
                        <?php
                        ?>
                        <?php foreach ($params['task_payout']['tasks'] as $task): ?>
                            <tr>
                                <td><?php echo $task['id']; ?></td>
                                <td><?php echo $task['projectName']; ?></td>
                                <td><?php echo $task['title']; ?></td>
                                <td><?php echo $task['wage']; ?></td>
                                <td><?php echo $task['payout']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <?php
                } elseif (isset($params['tasks_in_time']['tasks']) && !empty($params['tasks_in_time']['tasks'])) {
                    ?>
                    <table id="task" class="report-table">
                        <caption>Tasks in given time range</caption>
                        <tr>
                            <th>ID</th>
                            <th>Project name</th>
                            <th>Title</th>
                            <th>Start time</th>
                            <th>Stop time </th>
                        </tr>
                        <?php
                        /** @var Task $task */
                        foreach ($params['tasks_in_time']['tasks'] as $task):
                        ?>
                        <tr>
                            <td><?php echo $task['id']; ?></td>
                            <td><?php echo $task['projectName']; ?></td>
                            <td><?php echo $task['title']; ?></td>
                            <td><?php echo $task['startTime']; ?></td>
                            <td><?php echo $task['stopTime']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                    <?php
                }
                ?>
            </div>
        </div>
        </div>
        </div>
        <?= Layout::footer() ?>
        <?php
        return ob_get_clean();
    }
}