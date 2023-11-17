<?php
include('../db_connect.php');

$sql = "
select id,
       name
  from extra
 order by name
";

$stmt = $pdo->prepare($sql);
echo get_json($stmt);
?>
