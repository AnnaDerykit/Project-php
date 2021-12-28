<?php

namespace App\Controllers;

use Templates\FrontpageView;

class FrontpageViewController
{
    public static function index()
    {
        if (isset($_SESSION['uid'])) {
            header('Location: index.php?action=show-clients');
        } else {
            echo FrontpageView::render();
        }
        return;
    }
}