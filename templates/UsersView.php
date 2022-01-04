<?php

namespace Templates;

use App\Model\UserRepository;

class UsersView {
    public static function render() {
        ob_start();
        ?>
        <?= Layout::header() ?>
        <?= Layout::navbar() ?>
        <h1>List of users</h1>
        <table>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Password</th>
                <th>Role</th>
            </tr>
            <?php
            $usersRep = new UserRepository();
            $users = $usersRep->getAllUsersExceptId($_SESSION['uid']);
            foreach ($users as $user): ?>
                <tr>
                    <td><?= $user->getUsername() ?></td>
                    <td><?= $user->getEmail() ?></td>
                    <td><?= $user->getPassword() ?></td>
                    <td>
                        <select name="role">
                            <option value="<?php echo $user->getRole() ?>"><?= $user->getRole() ?></option>
                            <?php if ($user->getRole()=="user") { ?>
                                <option value="admin">admin</option>
                            <?php } else { ?>
                                <option value="user">user</option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
        <?= Layout::footer() ?>
        <?php
        $html = ob_get_clean();
        return $html;
    }
}
