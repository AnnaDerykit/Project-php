<?php
namespace Templates;

class LoginView {
    public static function render($params = []) {
        ob_start();
        ?>
            <?= Layout::header() ?>
            <form method="post" action="index.php?action=login-set">
                <label for="email">Email: </label>
                <input type="text" id="email" name="email">
                <br>
                <label for="password">Password:</label>
                <input type="text" id="password" name="password">
                <br>
                <input type="submit" value="Log in">
            </form>
            <?= Layout::footer() ?>
        <?php
        $html = ob_get_clean();
        return $html;
    }
}