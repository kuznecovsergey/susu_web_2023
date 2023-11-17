<?php
include('../db_connect.php');

$entity_body = file_get_contents('php://input');
$post_data = json_decode($entity_body, true);

if(!$post_data) {
    $result_data = [
        "error" => 1,
        "errorMsg" => "Не переданы входные параметры."
    ];
    echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    die();
}

// Место для валидации 

if (array_key_exists('id', $post_data)) { // Изменить
    $sql = " update main set
                name = :name,
                num = :num,
                producer = :producer,
                extra_id = :extra_id
              where id = :id;
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $post_data['id']);
} else { // Добавить
    $sql = "insert into main 
        (name,   num, producer,  extra_id) VALUES
        (:name, :num, :producer, :extra_id); 
    ";
    $stmt = $pdo->prepare($sql);
}

if ($post_data['name'] === "") $post_data['name'] = null;
if ($post_data['num'] === "") $post_data['num'] = null;
if ($post_data['producer'] === "") $post_data['producer'] = null;
if ($post_data['extra_id'] === "") $post_data['extra_id'] = null;

$stmt->bindParam(':name', $post_data['name']);
$stmt->bindParam(':num', $post_data['num']);
$stmt->bindParam(':producer', $post_data['producer']);
$stmt->bindParam(':extra_id', $post_data['extra_id']);
echo get_json($stmt);
?>
