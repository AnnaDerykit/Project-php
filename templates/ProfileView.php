<?php
namespace Templates;

use App\Model\UserRepository;

class ProfileView
{
    public static function render($params = [])
    {
        ob_start();
        ?>
        <?= Layout::header($params) ?>
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
            $id = $user->getId();
            ?>
                <tr contenteditable="true" onfocusout=editOnFocusOut(<?=$id?>) id=<?= $id ?>>
                    <td class="user_prfl" contenteditable="true"><?= $user->getUsername() ?></td>
                    <td class="email_prfl" contenteditable="false"><?= $user->getEmail() ?></td>
                    <td class="passw_prfl" contenteditable="true"><?= $user->getPassword() ?></td>
                    <td class="role_prfl" contenteditable="false"><?= $user->getRole() ?></td>
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