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
            <link rel="stylesheet"  href="../public/styles.css">
        </head>
        <body>
        <div class="header d-flex ai-center">
            <div class="title text-center">
                <h1 class="title"><span>Über</span>Clocker<span>3000</span></h1>
            </div>
        </div>
        <?php
        $html = ob_get_clean();
        return $html;
    }

    public static function footer() {
        ob_start();
        ?>
        <div class="footer text-center">
            <footer>
                <span>Design &copy; 2021 Über Clocker 3000 Team</span>
                <span></span>
            </footer>
        </div>
        </body>
        </html>
        <?php
        $html = ob_get_clean();
        return $html;
    }

    public static function navbar() {
        ob_start();
        ?>
        <div class="container w-100 d-flex">
            <nav class="navig">
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
                <ul class="menulist">
                    <?php
                    $names = array('My profile', 'My tasks', 'My projects', 'My clients', 'Log out');
                    $actions = array('show-profile', 'show-tasks', 'show-projects', 'show-clients', 'logout');
                    if ($role == 'admin') {
                        array_splice($names, 4, 0, array('Users'));
                        array_splice($actions, 4, 0, array('show-users'));
                    }
                    foreach (array_combine($actions, $names) as $action => $name): ?>
                        <li <?php if($_GET['action']==$action) { echo " class=\"active\""; } ?>>
                            <a <?= "href=?action=" . $action ?>><?=$name?></a>
                        </li>
                    <?php endforeach ?>
                </ul>
            </nav>
        </div>
        <?php
        $html = ob_get_clean();
        return $html;
    }

    public static function secondsToDays($seconds) {
        if (! $seconds) {
            return "0";
        }
        $timeString = "";
        $days = intval(intval($seconds) / (3600*24));
        if($days> 0) {
            $timeString .= "$days days ";
        }
        $hours = (intval($seconds) / 3600) % 24;
        if($hours > 0) {
            $timeString .= "$hours hours ";
        }
        $minutes = (intval($seconds) / 60) % 60;
        if($minutes > 0) {
            $timeString .= "$minutes minutes ";
        }
        $seconds = intval($seconds) % 60;
        if ($seconds > 0) {
            $timeString .= "$seconds seconds";
        }
        return $timeString;
    }
}