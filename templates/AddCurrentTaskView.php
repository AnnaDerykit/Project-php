<?php

namespace Templates;
use App\Model\UserRepository;
use App\Model\ClientRepository;
use App\Model\ProjectRepository;


class AddCurrentTaskView
{
    public static function render($params = [])
    {
        ob_start();
        ?>
        <?= Layout::header() ?>
        <div class="thing register">
            <div class="nag_task">
                <h2 class="text-center">Add Task</h2>
            </div>

            <form method="POST" action="index.php?action=Add-Current-Task">
                <div class="validation-errors">
                    <?php
                    if (!empty($params['message'])) {
                        echo '<p class="color-red text-center">' . $params['message'] . '</p>';
                    }
                    ?>
                </div>
            <table id="task" class="add-form">
                    <tr>
                        <th>Task Title</th>
                        <th>Project Name</th>
                    </tr>
                    <tr>
                         <td >
                            <input type="text" id="Task-Title" name="Task-Title" 
                            value="<?= !empty($params['values']['Task-Title']) ? $params['values']['Task-Title'] : ''; ?>"/>
                        </td>
                        <td>
                            <input class="Project_select" type="text" list="Projects" id="Project_Name" name="Project_Name"
                            value="<?= !empty($params['values']['Project_Name']) ? $params['values']['Project_Name'] : ''; ?>" />
                                <datalist id="Projects">
                                    <?php
                                    $projectsRep = new ProjectRepository();
                                    $projects = $projectsRep->findByUserId($_SESSION['uid']);
                                    foreach ($projects as $project): ?>
                                        <option><?= $project->getProjectName() ?></option>
                                    <?php endforeach ?>
                                </datalist>
                        </td>
                    </tr>
                    
                </table>
                <p></p>
                <input type="submit" id="submit" class="btn-rep" value="ADD">
            </form>
        </div>
        </div>
        </div>
        <?= Layout::footer() ?>
        <?php
        $html = ob_get_clean();
        return $html;
    }
}
