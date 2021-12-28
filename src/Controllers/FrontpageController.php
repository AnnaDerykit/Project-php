<?php

namespace App\Controllers;

use Templates\FrontpageView;

class FrontpageController
{
    public static function index()
    {
        if (isset($_SESSION['uid'])) {
            header('Location: index.php?action=show-profile');
        } else {
            echo FrontpageView::render();
        }
        return;
    }
}