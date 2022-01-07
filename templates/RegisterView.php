<?php

namespace Templates;

class RegisterView
{
    public static function render($params = [])
    {
        ob_start();
        ?>
        <?= Layout::header() ?>

        <div class="h2">
            <h2 class="nag_re">Rejestracja</h2>
        </div>

        <div class="validation-errors">
            <?php
            if (!empty($params['message'])) {
                echo '<p class="color-red text-center">'. $params['message'] .'</p>';
            }
            ?>
        </div>

        <form method="POST" action="index.php?action=register-set">
            <div class="data_re">
                <div class="name_re">
                    <label for="username">Username: </label>
                    <input type="text" id="username" name="username" value="<?= !empty($params['values']['username']) ? $params['values']['username'] : ''; ?>">
                </div>

                <div class="mail_re">
                    <label for="email">Email: </label>
                    <input type="text" id="email" name="email" value="<?= !empty($params['values']['email']) ? $params['values']['email'] : ''; ?>">
                </div>

                <div class="haslo_re">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" value="<?= !empty($params['values']['password']) ? $params['values']['password'] : ''; ?>">
                </div>

                <div class="repeat_password_re">
                    <label for="repeat_password">Repeat password:</label>
                    <input type="password" id="repeat_password" name="repeat_password" value="<?= !empty($params['values']['repeat_password']) ? $params['values']['repeat_password'] : ''; ?>">
                </div>

                <div class="btm_re">
                    <input class="register" type="submit" value="Register">
                </div>

            </div>
        </form>
        <?= Layout::footer() ?>
        <?php
        return ob_get_clean();
    }
}
