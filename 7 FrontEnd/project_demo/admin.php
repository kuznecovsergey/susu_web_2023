<?php
    session_start();
    if (!array_key_exists('IS_AUTH', $_SESSION) ||
        !array_key_exists('roles', $_SESSION)) {
		header('Location: authorization.php');
		die();
	}

    echo $_SESSION['name']. ' ' . $_SESSION['login'] . '<br/>';

    if (in_array('ADM', $_SESSION['roles'])) {
        echo 'У вас есть доступ.';
    } else {
        echo 'У вас нет доступа!';
        die();
    }
?>
<div>Панель администратора</div>