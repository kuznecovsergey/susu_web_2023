<?php
	session_start();
	if (!array_key_exists('IS_AUTH', $_SESSION)) {
		header('Location: authorization.php');
		die();
	}
?>

<header>
	<?php
		echo $_SESSION['name']. ' ' . $_SESSION['login'];
		echo '<br/>Роли: ';
		echo json_encode($_SESSION['roles']);
	?>
	<form action="logout.php">
		<input type="submit" value="Выйти">
	</form>
<header>