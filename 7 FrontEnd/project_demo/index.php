<?php
    session_start();
    if (!array_key_exists('IS_AUTH', $_SESSION)) {
        header('Location: authorization.php');
        die();
    }
?>
<head>
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <?php
        include('header.php');
    ?>
    <button onclick="addRow()">Добавить</button>
    <button onclick="editRow()">Изменить</button>
    <br/><br/>
    <div>
        <span>Название препарата: </span><input id="item-name"><br/>
        <span>Кол-во в упаковке: </span><input id="item-num"><br/>
        <span>Производитель: </span><input id="item-producer"><br/>
        <span>Единица  измерения: </span>
        <select id="select-extra">
            <option></option>
        </select><br/>
    </div>
    <br/>
    <table border="1" >
        <thead>
            <tr>
                <th>Название препарата</th>
                <th>Кол-во в упаковке</th>
                <th>Производитель</th>
                <th>Единица  измерения</th>
                <th/>
            </tr>
        </thead>
        <tbody id="main-container">
        </tbody>
    </table>

    <script src="js/script.js"></script>
</body>