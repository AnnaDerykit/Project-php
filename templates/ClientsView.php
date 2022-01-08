<?php
namespace Templates;

use App\Model\ClientRepository;

class ClientsView {
    public static function render($params = []) {
        ob_start();
        ?>
        <?= Layout::header() ?>
        <?= Layout::navbar() ?>
        <h1>List of clients</h1>
        <table>
            <tr>
                <th>Client name</th>
            </tr>
            <?php
            $clientsRep = new ClientRepository();
            $clients = $clientsRep->findByUserId($_SESSION['uid']);
            foreach ($clients as $client): ?>
                <tr>
                    <td><?= $client->getClientName() ?></td>
                </tr>
            <?php endforeach ?>
        </table>
        <?= Layout::footer() ?>
        <?php
        $html = ob_get_clean();
        return $html;
    }
}