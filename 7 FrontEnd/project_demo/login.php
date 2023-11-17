<?php
    session_start();
    if (array_key_exists('IS_AUTH', $_SESSION)) {
        header('Location: index.php');
        die();
    }

    $dsn = "pgsql:host=localhost;port=5432;dbname=postgres;";
    $pdo = new PDO($dsn, 'postgres', '1');

    $sql = 'select name, id from users 
            where login = :login and pass = :password';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':login', $_POST['login']);
    $stmt->bindParam(':password', $_POST['password']);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        include('find_roles.php');
        $_SESSION['roles'] = get_roles($row['id']);

        $_SESSION['IS_AUTH'] = true;
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['login'] = $_POST['login'];
        header('Location: index.php');
        die();
    } else {
        echo 'Неверные логин или пароль!<br/>';
        echo '<form action="authorization.php">
                <input type="submit" value="Вернуться">
             </form>';
    }
?>
