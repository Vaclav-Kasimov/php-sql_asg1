<?php

function db_print($pdo)
{
    $statement = $pdo->query('SELECT * FROM autos');
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
        echo('<li>'.$row['year'].' '.$row['make'].'/'.$row['mileage']).'</li>';
    }
}

// проверка на логин
if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
}

// Выход из системы
if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    return;
}

require_once('PDO_connect.php');

$err_msg ='';
$ok_msg ='';

if (isset($_POST['dopost'])){
    if (!is_numeric($_POST['mileage']) || !is_numeric($_POST['year']) ){
        $err_msg ='Mileage and year must be numeric';
    }   elseif (strlen($_POST['make']) <1 || !isset($_POST['make'])){
        $err_msg ='Make is required';
    }   else{
        $stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage) VALUES ( :mk, :yr, :mi)');
        $stmt->execute(array(
            ':mk' => $_POST['make'],
            ':yr' => $_POST['year'],
            ':mi' => $_POST['mileage'])
        );
    }
}




?>
<!DOCTYPE html>
<html>
    <head>
        <title>Viacheslav Kasimov</title>
    </head>
    
    <body>
        <h1>Tracking auto for <?= $_GET['name'] ?></h1>
        <div style="color: red;"><?= $err_msg ?></div>
        <div style="color: green;"><?= $ok_msg ?></div>
        <form method="post">
            <div>
                <span>Make</span>
                <input type="text" name="make" size="40">
            </div>
            <div>
                <span>Year</span>
                <input type="text" name="year" size="40">
            </div>
            <div>
                <span>Mileage</span>
                <input type="text" name="mileage" size="40">
            </div>
            <div>
                <input type="submit" name="dopost" value="Add">
                <input type="button" name="escape" onclick="location.href='/index.php'; return false;" value="Logout">
            </div>
            <h1>Automobiles</h1>
            <ul>
                <?= db_print($pdo) ?>
            </ul>
    </body>
</html>