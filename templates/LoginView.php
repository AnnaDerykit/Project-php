<?php
namespace Templates;

class LoginView {
    public static function render($params = []) {
        ob_start();
        ?>
        <?= Layout::header() ?>
        <div class="h2">
            <h2 class="nag_log">Logowanie</h2>
        </div>

        <form method="post" action="index.php?action=login-set">

            <div class="data_log">
                <div class="mail_log">
                    <label for="email">Email: </label>
                    <input type="text" id="email" name="email">
                </div>

                <div class="password_log">
                    <label for="password">Password:</label>
                    <input type="text" id="password" name="password">
                </div>

                <div class="btm_log">
                    <input class="login" type="submit" value="Log in">
                </div>
            </div>
        </form>
        <?= Layout::footer() ?>
        <?php
        $html = ob_get_clean();
        return $html;
    }
}
?>


