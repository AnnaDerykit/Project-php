<?php

namespace Templates;

use App\Model\UserRepository;

class ReportsView
{
    public static function render($params = [])
    {
        ob_start();
        ?>
        <?= Layout::header($params) ?>
        <?= Layout::navbar() ?>

        <?= Layout::footer() ?>
        <?php
        $html = ob_get_clean();
        return $html;
    }
}