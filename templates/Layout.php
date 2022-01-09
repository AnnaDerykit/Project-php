<?php

namespace Templates;

use App\Model\UserRepository;

class Layout
{
    public static function header($params = [])
    {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <title>Über Clocker 3000</title>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="../public/styles.css">
            <?php
            if (isset($params['script'])) {
                echo '<script src=' . $params["script"] . '></script>';
            }
            ?>
        </head>
        <body>
        <div class="header d-flex ai-center">
            <div class="title text-left">
                <h1 class="title"><span>Über</span>Clocker<span>3000</span></h1>
            </div>
            <div class="hello-user text-right">
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
                <span class="username"><?= isset($_SESSION['uid']) && $_SESSION['uid'] ? 'Logged in as ' . $username : 'Logged out' ?><img class="icon" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pjxzdmcgdmlld0JveD0iMCAwIDMyIDMyIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjx0aXRsZS8+PGcgaWQ9ImFib3V0Ij48cGF0aCBkPSJNMTYsMTZBNyw3LDAsMSwwLDksOSw3LDcsMCwwLDAsMTYsMTZaTTE2LDRhNSw1LDAsMSwxLTUsNUE1LDUsMCwwLDEsMTYsNFoiLz48cGF0aCBkPSJNMTcsMThIMTVBMTEsMTEsMCwwLDAsNCwyOWExLDEsMCwwLDAsMSwxSDI3YTEsMSwwLDAsMCwxLTFBMTEsMTEsMCwwLDAsMTcsMThaTTYuMDYsMjhBOSw5LDAsMCwxLDE1LDIwaDJhOSw5LDAsMCwxLDguOTQsOFoiLz48L2c+PC9zdmc+" alt="user icon"></span>
            </div>
        </div>
        <div class="container w-100 d-flex">
        <?php
        $html = ob_get_clean();
        return $html;
    }

    public static function footer()
    {
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

    public static function navbar()
    {
        ob_start();
        ?>
            <nav class="navig">
                <ul class="menulist">
                    <?php
                    $userRep = new UserRepository();
                    $username = null;
                    $role = null;
                    if (isset($_SESSION['uid'])) {
                        $u = $userRep->findById($_SESSION['uid']);
                        $username = $u->getUsername();
                        $role = $u->getRole();
                    }
                    $names = array('My profile', 'My tasks', 'My projects', 'My clients', 'Log out');
                    $actions = array('show-profile', 'show-tasks', 'show-projects', 'show-clients', 'logout');
                    if ($role == 'admin') {
                        array_splice($names, 4, 0, array('Users'));
                        array_splice($actions, 4, 0, array('show-users'));
                    }
                    foreach (array_combine($actions, $names) as $action => $name): ?>
                        <li <?php if ($_GET['action'] == $action) {
                            echo " class=\"active\"";
                        } ?>>
                            <a <?= "href=?action=" . $action ?>><?= $name ?></a>
                        </li>
                    <?php endforeach ?>
                </ul>
            </nav>
        <?php
        $html = ob_get_clean();
        return $html;
    }

    public static function secondsToDays($seconds)
    {
        if (!$seconds) {
            return "0";
        }
        $timeString = "";
        $days = intval(intval($seconds) / (3600 * 24));
        if ($days > 0) {
            $timeString .= "$days days ";
        }
        $hours = (intval($seconds) / 3600) % 24;
        if ($hours > 0) {
            $timeString .= "$hours hours ";
        }
        $minutes = (intval($seconds) / 60) % 60;
        if ($minutes > 0) {
            $timeString .= "$minutes minutes ";
        }
        $seconds = intval($seconds) % 60;
        if ($seconds > 0) {
            $timeString .= "$seconds seconds";
        }
        return $timeString;
    }
}