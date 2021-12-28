<?php
namespace Templates;

class RegisterView {
    public static function render($params = []) {
        ob_start();
        ?>
        <?= Layout::header() ?>
        <form method="post" action="index.php?action=register-set">
            <label for="username">Username: </label>
            <input type="text" id="username" name="username">
            <br>
            <label for="email">Email: </label>
            <input type="text" id="email" name="email">
            <br>
            <label for="password">Password:</label>
            <input type="text" id="password" name="password">
            <br>
            <label for="rep-password">Repeat password:</label>
            <input type="text" id="rep-password" name="rep-password">
            <br>
            <input type="submit" value="Register">
        </form>
        <?= Layout::footer() ?>
        <?php
        $html = ob_get_clean();
        return $html;
    }
}
