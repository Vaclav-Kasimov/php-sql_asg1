<?php
session_start();
function db_print($pdo)
{
    $statement = $pdo->query('SELECT * FROM autos');
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
        echo('<li>'.$row['year'].' '.$row['make'].'/'.$row['mileage']).'</li>';
    }
}

// проверка на логин
if (! isset($_SESSION['name'])) {
    die('Not logged in');
}


require_once('PDO_connect.php');





?>
<!DOCTYPE html>
<html>
    <head>
        <title>Viacheslav Kasimov</title>
    </head>
    
    <body>
        <h1>Tracking auto for <?= $_SESSION['name'] ?></h1>
        <?php
            if (isset($_SESSION['success'])){
                echo(
                    '<div style="color:green;">'.
                    $_SESSION['success'].
                    '</div>'
                );
                unset($_SESSION['success']);
            }
        ?>
        <div>
            <a href="add.php">Add New</a> | <a href="logout.php"> Logout</a>
        </div>
        <h1>Automobiles</h1>
        <ul>
            <?= db_print($pdo) ?>
        </ul>
    </body>
</html>
