<?php
namespace Templates;

use App\Model\UserRepository;

class ProfileView {
    public static function render() {
        ob_start();
        ?>
        <?= Layout::header() ?>
        <?= Layout::navbar() ?>
        <h1>My profile</h1>
        <table>
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
            <tr>
                <td><?= $user->getUsername() ?></td>
                <td><?= $user->getEmail() ?></td>
                <td><?= $user->getPassword() ?></td>
                <td><?= $user->getRole() ?></td>
            </tr>
        </table>
        <?= Layout::footer() ?>
        <?php
        $html = ob_get_clean();
        return $html;
    }
}