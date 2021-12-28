<?php

namespace Templates;

use App\Model\TaskRepository;
use App\Model\UserRepository;

class FrontpageView {
    public static function render($params = []) {
        ob_start();
        ?>
        <?= Layout::header() ?>
        <div>
            <ul>
                <?php
                $names = ['Log in', 'Register'];
                $actions = ['login', 'register'];
                foreach (array_combine($actions, $names) as $action => $name): ?>
                    <li<?php if($_GET['action']==$action) { echo " class=\"active\""; } ?>>
                        <a <?= "href=?action=" . $action ?>><?=$name?></a>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
        <h1>Our stats</h1>
        <p>Number of registered users: <?php
            $usersRep = new UserRepository();
            echo $usersRep->getNumberOfUsers();
            ?></p>
        <p>Number of submitted tasks: <?php
            $tasksRep = new TaskRepository();
            echo $tasksRep->getNumberOfTasks();
            ?></p>
        <p>Total time of submitted tasks: <?php
            echo self::secondsToDays($tasksRep->getTotalTasksTime());
            ?></p>
        <?= Layout::footer() ?>
        <?php
        $html = ob_get_clean();
        return $html;
    }

    public static function secondsToDays($seconds) {
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