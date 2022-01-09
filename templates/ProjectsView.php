<?php
namespace Templates;

use App\Model\ClientRepository;
use App\Model\ProjectRepository;

class ProjectsView {
    public static function render($params = []) {
        ob_start();
        ?>
        <?= Layout::header() ?>
        <?= Layout::navbar() ?>
        <div class="thing">
        <div class="nag_task">
            <h2>List of projects</h2>
        </div>
            <div class="task-table">
                <table id="task">
                    <tr>
                <th></th>
                <th>Project name</th>
                <th>Client name</th>
                <th>Wage</th>
            </tr>
            <?php
            $projectsRep = new ProjectRepository();
            $clientsRep = new ClientRepository();
            $projects = $projectsRep->findByUserId($_SESSION['uid']);
            foreach ($projects as $project): ?>
                <tr>
                    <td class="del">
                        <a href="#" class="del_link" onclick=deleteOnClick()>X</a>
                    </td>
                    <td><?= $project->getProjectName() ?></td>
                    <?php
                    $client = $projectsRep->getClientByProjectId($project->getId());
                    ?>
                    <td><?= $client ? $client->getClientName() : '' ?></td>
                    <td><?= $project->getWage() ?></td>
                </tr>
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