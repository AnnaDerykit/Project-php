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
        <h1>List of projects</h1>
        <table>
            <tr>
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
                    <td><?= $project->getProjectName() ?></td>
                    <?php
                    $client = $projectsRep->getClientByProjectId($project->getId());
                    ?>
                    <td><?= $client ? $client->getClientName() : '' ?></td>
                    <td><?= $project->getWage() ?></td>
                </tr>
            <?php endforeach ?>
        </table>
        <?= Layout::footer() ?>
        <?php
        $html = ob_get_clean();
        return $html;
    }
}