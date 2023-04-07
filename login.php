<!DOCTYPE html>

<?php
    session_start();
    $salt = 'XyZzy12*_';
    $hash = '1a52e17fa899cf40fb04cfc42e6352f1';
    if  (isset($_POST['dopost'])){
        unset($_SESSION['name']); //Если каким-то образом есть информация о залогиненном пользователе, выходим из аккаунта
        
        if (($_POST['email'] === '') || ($_POST['pass'] === '')){
            $_SESSION['error'] = 'User name and password are required';
            header('Location: login.php');
            return;
        }   elseif (preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{0,30}[0-9A-Za-z]?)|([0-9А-Яа-я]{1}[-0-9А-я\.]{0,30}[0-9А-Яа-я]?))@([-A-Za-z]{1,}\.){1,}[-A-Za-z]{2,})$/u',$_POST['email']) !== 1){
            #regular exp. was not written by me; took it from https://ru.stackoverflow.com/questions/571772/Регулярное-выражение-для-полной-проверки-email
            $_SESSION['error'] = 'Email must have an at-sign (@)';
            error_log("Login fail ".$_POST['email'].' '.hash('md5', $salt.htmlentities($_POST['pass'])));
            header('Location: login.php');
            return;
        }   elseif  (hash('md5', $salt.htmlentities($_POST['pass'])) != $hash){
            $_SESSION['error'] = 'Incorrect password';
            error_log("Login fail ".$_POST['email'].' '.hash('md5', $salt.htmlentities($_POST['pass'])));
            header('Location: login.php');
            return;
        }   else    {
            $_SESSION['name'] = $_POST['email'];
            header("Location: view.php");
            error_log("Login success ".$_SESSION['email']);
            return;
        }
    }
?>

<html>
    <head><title>Kasimov Viacheslav</title></head>
    <body>
        <h1>Please log in</h1>
        <?php 
            if (isset($_SESSION['error'])){
                echo '<p style = "color:red;">'.$_SESSION['error'].'<p>';
                unset($_SESSION['error']);
            }
        ?>
        <form method="post">
            <div>
                <span>User name</span>
                <input type="text" name="email" size="40">
            </div>
            <div>
                <span>Password</span>
                <input type="password" name="pass" size="40">
            </div>
            <div>
                <input type="submit" name="dopost" value="Log In">
                <input type="button" name="escape" onclick="location.href='/index.php'; return false;" value="Cancel">
            </div>
        </form>
    </body>
</html>