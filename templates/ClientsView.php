<?php

namespace Templates;

use App\Model\ClientRepository;

class ClientsView
{
    public static function render($params = [])
    {
        ob_start();
        ?>
        <?= Layout::header() ?>
        <?= Layout::navbar() ?>
        <div class="thing">
            <div class="nag_task">
                <h2>List of clients</h2>
            </div>
            <div class="task-table">
                <table id="task">
                    <tr>
                        <th></th>
                        <th>Client name</th>
                    </tr>
                    <?php
                    $clientsRep = new ClientRepository();
                    $clients = $clientsRep->findByUserId($_SESSION['uid']);
                    foreach ($clients as $client): ?>
                        <tr>
                            <td class="del">
                                <a href="#" class="del_link" onclick=deleteOnClick()>X</a>
                            </td>
                            <td><?= $client->getClientName() ?></td>
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