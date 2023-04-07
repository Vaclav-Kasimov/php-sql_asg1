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

// Выход из системы
if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    return;
}

require_once('PDO_connect.php');

if (isset($_POST['dopost'])){
    if (!is_numeric(htmlentities($_POST['mileage'])) || !is_numeric(htmlentities($_POST['year'])) ){
        $_SESSION['error'] ='Mileage and year must be numeric';
        header('location: add.php');
        return;
    }   elseif (strlen($_POST['make']) <1 || !isset($_POST['make'])){
        $_SESSION['error'] ='Make is required';
        header('location: add.php');
        return;
    }   else{
        $stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage) VALUES ( :mk, :yr, :mi)');
        $stmt->execute(array(
            ':mk' => htmlentities($_POST['make']),
            ':yr' => $_POST['year'],
            ':mi' => $_POST['mileage'])
        );
        header('location: view.php');
        $_SESSION['success'] = 'Record inserted';
        return;
    }
}




?>
<!DOCTYPE html>
<html>
    <head>
        <title>Viacheslav Kasimov</title>
    </head>
    
    <body>
        <h1>Tracking auto for <?= $_SESSION['name'] ?></h1>
        <?php
            if (isset($_SESSION['error'])){
                echo(
                    '<div style="color:red;">'.
                    $_SESSION['error'].
                    '</div>'
                );
                unset($_SESSION['error']);
            }


        ?>
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
                <input type="button" name="logout" onclick="location.href='/view.php'; return false;" value="cancel">
            </div>
        </form>
    </body>
</html>
