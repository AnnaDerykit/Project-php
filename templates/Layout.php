<?php
namespace Templates;

use App\Model\UserRepository;

class Layout {
    public static function header() {
        ob_start();
        ?>
        <html lang="en">
        <head>
            <title>Über Clocker 3000</title>
            <meta charset="UTF-8">
        </head>
        <body>
        <?php
        $html = ob_get_clean();
        return $html;
    }

    public static function footer() {
        ob_start();
        ?>
            <footer>Design &copy; 2021 Über Clocker 3000 Team</footer>
        </body>
        </html>
        <?php
        $html = ob_get_clean();
        return $html;
    }

    public static function navbar() {
        ob_start();
        ?>
        <nav>
            <?php
            $userRep = new UserRepository();
            $username = null;
            $role = null;
            if (isset($_SESSION['uid'])) {
                $u = $userRep->findById($_SESSION['uid']);
                $username = $u->getUsername();
                $role = $u->getRole();
            }
            ?>
            <?= isset($_SESSION['uid']) && $_SESSION['uid'] ? 'Logged in as ' . $username : 'Logged out' ?>
            <ul>
                <?php
                $names = array('My profile', 'My tasks', 'My projects', 'My clients', 'Log out');
                $actions = array('show-profile', 'show-tasks', 'show-projects', 'show-clients', 'logout');
                if ($role == 'admin') {
                    array_splice($names, 4, 0, array('Users'));
                    array_splice($actions, 4, 0, array('show-users'));
                }
                foreach (array_combine($actions, $names) as $action => $name): ?>
                <li<?php if($_GET['action']==$action) { echo " class=\"active\""; } ?>>
                    <a <?= "href=?action=" . $action ?>><?=$name?></a>
                </li>
                <?php endforeach ?>
            </ul>
        </nav>
        <?php
        $html = ob_get_clean();
        return $html;
    }
}