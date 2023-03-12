<!DOCTYPE html>

<?php
    $salt = 'XyZzy12*_';
    $hash = '1a52e17fa899cf40fb04cfc42e6352f1';
    $err_msg = '';
    if  (isset($_POST['dopost'])){
        if (($_POST['who'] === '') || ($_POST['pass'] === '')){
            $err_msg = 'User name and password are required';
        }   elseif (preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{0,30}[0-9A-Za-z]?)|([0-9А-Яа-я]{1}[-0-9А-я\.]{0,30}[0-9А-Яа-я]?))@([-A-Za-z]{1,}\.){1,}[-A-Za-z]{2,})$/u',$_POST['who']) !== 1){
            #regular exp. was not written by me; took it from https://ru.stackoverflow.com/questions/571772/Регулярное-выражение-для-полной-проверки-email
            $err_msg = 'Email must have an at-sign (@)';
            error_log("Login fail ".$_POST['who'].' '.hash('md5', $salt.htmlentities($_POST['pass'])));
        }   elseif  (hash('md5', $salt.htmlentities($_POST['pass'])) != $hash){
            $err_msg = 'Incorrect password';
            error_log("Login fail ".$_POST['who'].' '.hash('md5', $salt.htmlentities($_POST['pass'])));
        }   else    {
            header("Location: autos.php?name=".urlencode($_POST['who']));
            error_log("Login success ".$_POST['who']);
        }
    }
?>

<html>
    <head><title>Kasimov Viacheslav</title></head>
    <body>
        <h1>Please log in</h1>
        <div style="color: red;"><?= $err_msg ?></div>
        <form method="post">
            <div>
                <span>User name</span>
                <input type="text" name="who" size="40">
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