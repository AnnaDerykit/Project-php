<?php
namespace Templates;

class ChangePasswordView
{
    public static function render($params = [])
    {
        ob_start();
        ?>
        <?= Layout::header() ?>
        <div class="thing register">
            <div class="nag_task">
                <h2>Change password</h2>
            </div>

            <div class="validation-errors">
                <?php
                if (!empty($params['message'])) {
                    echo '<p class="color-red text-center">' . $params['message'] . '</p>';
                }
                ?>
            </div>

            <form method="POST" action="?action=password-change">
                <div class="data_log">
                    <div class="haslo_re">
                        <label for="password">New password:</label>
                        <input type="password" id="password" name="password"
                               value="<?= !empty($params['values']['password']) ? $params['values']['password'] : ''; ?>">
                    </div>

                    <div class="repeat_password_re">
                        <label for="repeat_password">Repeat new password:</label>
                        <input type="password" id="repeat_password" name="repeat_password"
                               value="<?= !empty($params['values']['repeat_password']) ? $params['values']['repeat_password'] : ''; ?>">
                    </div>

                    <div class="btm_re">
                        <input class="register btn btn-purple" type="submit" value="Submit">
                    </div>
                </div>
            </form>
        </div>
        </div>
        </div>
        <?= Layout::footer() ?>
        <?php
        return ob_get_clean();
    }
}
