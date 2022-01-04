<?php
namespace Templates;

class RegisterView {
    public static function render($params = []) {
        ob_start();
        ?>
        <?= Layout::header() ?>
        <div class="h2">
            <h2 class="nag_re">Rejestracja</h2>
        </div>
        <form method="post" action="index.php?action=register-set">
            <div class="data_re">

                <div class="name_re">
                    <label for="username">Username: </label>
                    <input type="text" id="username" name="username">
                </div>

                <div class="mail_re">
                    <label for="email">Email: </label>
                    <input type="text" id="email" name="email">
                </div>


                <div class="haslo_re">
                    <label for="password">Password:</label>
                    <input type="text" id="password" name="password">
                </div>

                <div class="powtorzhaslo_re">
                    <label for="rep-password">Repeat password:</label>
                    <input type="text" id="rep-password" name="rep-password">
                </div>

                <div class="btm_re">
                    <input class="register" type="submit" value="Register">
                </div>

            </div>
        </form>
        <?= Layout::footer() ?>
        <?php
        $html = ob_get_clean();
        return $html;
    }
}