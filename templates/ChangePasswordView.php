<?php
namespace Templates;

use App\Model\UserRepository;

class ChangePasswordView
{
    public static function render($params = [])
    {
        ob_start();
        ?>
        <?= Layout::header($params) ?>
        <div class="thing register">
            <div class="nag_task">
                <?php $changeId = $_POST['id'];
                $uid = $_SESSION['uid'];
                if ($changeId == $uid) { ?>
                    <h2>Change password</h2>
                <?php } else {
                    $userRep = new UserRepository();
                    $u = $userRep->findById($changeId);
                    $username = $u->getUsername();?>
                    <h2><?= 'Change password for ' . $username ?></h2>
                <?php } ?>
            </div>

            <div class="validation-errors">
                <?php
                if (!empty($params['message'])) {
                    echo '<p class="color-red text-center">' . $params['message'] . '</p>';
                }
                ?>
            </div>

            <?php
            $userRep = new UserRepository();
            $user = $userRep->findById($uid);
            $id = $user->getId();
            ?>

            <form method="POST" action="?action=change-password">
                <input type="hidden" id="id" name="id" value=<?=$changeId?>>
                <div class="data_log" id=<?=$id?>>
                    <div class="haslo_re">
                        <label for="password">New password:</label>
                        <input type="password" id="password" name="password">
                    </div>

                    <div class="repeat_password_re">
                        <label for="repeat_password">Repeat new password:</label>
                        <input type="password" id="repeat_password" name="repeat_password">
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
