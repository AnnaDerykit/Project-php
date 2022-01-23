<?php

namespace Templates;
use App\Model\UserRepository;
use App\Model\ClientRepository;
use App\Model\ProjectRepository;
class AddClientView
{
    public static function render($params = [])
    {
        ob_start();
        ?>
        <?= Layout::header() ?>
        <div class="thing register">
            <div class="nag_Client">
                <h2>Add Project</h2>
            </div>

            <form method="POST" action="index.php?action=Add-Client">
                <div class="validation-errors">
                    <?php
                    if (!empty($params['message'])) {
                        echo '<p class="color-red text-center">' . $params['message'] . '</p>';
                    }
                    ?>
                </div>
            <table id="Client-Name">
                    <tr>
                        <th>Client name</th>
                    </tr>
                    <tr>
                         <td >
                            <input type="text" id="Client-Name" name="Client-Name" 
                            value="<?= !empty($params['values']['Client-Name']) ? $params['values']['Client-Name'] : ''; ?>"/>
                        </td>
                    </tr>
                    
                </table>
                <input type="submit" id="submit" class="btn-peach" value="ADD">
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
