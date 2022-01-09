<?php
namespace Templates;

use App\Model\UserRepository;

class ProfileView {
    public static function render() {
        ob_start();
        ?>
        <?= Layout::header() ?>
        <?= Layout::navbar() ?>
        <div class="thing">
            <div class="nag_task">
              <h2>My profile</h2>
            </div>
        <div class="task-table">
            <table id="task">
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Password</th>
                <th>Role</th>
            </tr>
            <?php
            $usersRep = new UserRepository();
            $user = $usersRep->findById($_SESSION['uid']);
            ?>
            <tr contenteditable="true">
                <td><?= $user->getUsername() ?></td>
                <td contenteditable="false"><?= $user->getEmail() ?></td>
                <td><?= $user->getPassword() ?></td>
                <td contenteditable="true"><?= $user->getRole() ?></td>
            </tr>
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