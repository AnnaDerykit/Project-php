<?php

namespace Templates;

use App\Model\UserRepository;

class UsersView
{
    public static function render($params = [])
    {
        ob_start();
        ?>
        <?= Layout::header($params) ?>
        <?= Layout::navbar() ?>
        <div class="thing">
        <div class="nag_task">
            <h2>List of users</h2>
        </div>
            <div class="task-table">
                <table id="task">
            <tr>
                <th></th>
                <th>Username</th>
                <th>Email</th>
                <th>Password</th>
                <th>Role</th>
            </tr>
            <?php
            $usersRep = new UserRepository();
            $users = $usersRep->getAllUsersExceptId($_SESSION['uid']);
            foreach ($users as $user):
                $id = $user->getId();
                ?>
                <tr>
                    <td class="del">
                        <a href="#" class="del_link" onclick=deleteOnClick()>X</a>
                    </td>
                    <td class="user_usr"><?= $user->getUsername() ?></td>
                    <td class="email_usr"><?= $user->getEmail() ?></td>
                    <td class="passw_usr"><?= $user->getPassword() ?></td>
                    <td class="role_usr">
                        <select class="role_select" name="role" onfocusout=editOnFocusOut(<?=$id?>)>
                            <option value="<?php echo $user->getRole() ?>"><?= $user->getRole() ?></option>
                            <?php if ($user->getRole() == "user") { ?>
                                <option value="admin">admin</option>
                            <?php } else { ?>
                                <option value="user">user</option>
                            <?php } ?>
                        </select>
                    </td>
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
