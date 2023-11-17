<?php
include('../db_connect.php');

$sql = "
delete
  from main
 where id = :id
";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $_GET['id']);

echo get_json($stmt);
?>
