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
                    <li>
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
        <p>Time reported this week: <?php
            echo Layout::secondsToDays($tasksRep->getTotalTasksTimeThisPeriod('week'));
            ?></p>
        <p>Time reported this month: <?php
            echo Layout::secondsToDays($tasksRep->getTotalTasksTimeThisPeriod('month'));
            ?></p>
        <p>Time reported this year: <?php
            echo Layout::secondsToDays($tasksRep->getTotalTasksTimeThisPeriod('year'));
            ?></p>
        <p>Total time reported: <?php
            echo Layout::secondsToDays($tasksRep->getTotalTasksTimeThisPeriod());
            ?></p>
        <?= Layout::footer() ?>
        <?php
        $html = ob_get_clean();
        return $html;
    }
}