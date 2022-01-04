<?php

namespace Templates;

use App\Model\TaskRepository;
use App\Model\UserRepository;

class FrontpageView {
    public static function render($params = []) {
        ob_start();
        ?>
        <?= Layout::header() ?>
        <div class="log_re">
            <ul>
                <?php
                $names = ['Log in', 'Register'];
                $actions = ['login', 'register'];
                foreach (array_combine($actions, $names) as $action => $name): ?>
                    <li>
                        <a class="choice" <?= "href=?action=" . $action ?>><?=$name?></a>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>

        <div class="H2">
            <h2 class="stats">Our stats</h2>
        </div>

        <div class="numberus">
            <p class="p1">Number of registered users: <?php
                $usersRep = new UserRepository();
                echo $usersRep->getNumberOfUsers();
                ?></p>
        </div>

        <div class="numdertas">
            <p class="p2">Number of submitted tasks: <?php
                $tasksRep = new TaskRepository();
                echo $tasksRep->getNumberOfTasks();
                ?></p>
        </div>

        <div class="week">
            <p class="p3">Time reported this week: <?php
                echo Layout::secondsToDays($tasksRep->getTotalTasksTimeThisPeriod('week'));
                ?></p>
        </div>

        <div class="month">
            <p class="p4">Time reported this month: <?php
                echo Layout::secondsToDays($tasksRep->getTotalTasksTimeThisPeriod('month'));
                ?></p>
        </div>

        <div class="year">
            <p class="p5">Time reported this year: <?php
                echo Layout::secondsToDays($tasksRep->getTotalTasksTimeThisPeriod('year'));
                ?></p>
        </div>

        <div class="totaltime">
            <p class="p6">Total time reported: <?php
                echo Layout::secondsToDays($tasksRep->getTotalTasksTimeThisPeriod());
                ?></p>
        </div>

        <?= Layout::footer() ?>
        <?php
        $html = ob_get_clean();
        return $html;
    }
}