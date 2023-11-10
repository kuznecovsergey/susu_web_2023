<?php
    session_start();
    if (array_key_exists('IS_AUTH', $_SESSION)) {
        header('Location: index.php');
        die();
    }
?>
<meta charset="utf-8"/>
<form action="login.php" method="POST">
    Логин:<br><input name="login"><br>
    Пароль:<br><input name="password" type="password"><br>
    <input type="submit" value="Ок">
</form>