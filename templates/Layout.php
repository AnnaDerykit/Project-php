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
            if (isset($_SESSION['uid'])) {
                $username = $userRep->getUsernameById($_SESSION['uid']);
            }
            ?>
            <?= isset($_SESSION['uid']) && $_SESSION['uid'] ? 'Logged in as ' . $username : 'Logged out' ?>
            <ul>
                <?php
                $names = ['My profile', 'My tasks', 'My projects', 'My clients', 'Log out'];
                $actions = ['', 'show-tasks', 'show-projects', 'show-clients', 'logout'];
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