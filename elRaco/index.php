<?php
session_name('esnBCNRegistro');
session_start();

$failed = 0;

if (!empty($_POST['username']) && !empty($_POST['password']))
{
    if (md5($_POST['username']) == "6a92cc847768907d5c1967628ff40ea4" &&
            md5($_POST['password']) == "24d04d9ad17fa991460b1a2fa88dc466")
    {

        $_SESSION['Username'] = $username;
        $_SESSION['LoggedIn'] = 1;

        header("Location: registro.php");
        exit;
    }
    else
    {
        $failed = 1;
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
    <head>  
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
        <title>Ibiza 2012 Registro Team!</title>
        <link rel="stylesheet" href="style.css" type="text/css" />
    </head>  
    <body>  
        <div id="main">

            <?php
            if ($failed)
            {
                echo "<h1>Error</h1>";
                echo "<p>Sorry, you are not authorized by the island! Please check with OC employees or with Jackob himself. Thank you ;)</p>";
            }
            else
            {
                ?><h1>Registro Team!!</h1>

                <p>Good Luck;)</p>

                <form method = "post" action = "index.php" id = "loginform">
                    <fieldset>
                        <label for = "username">Username:</label><input type = "text" name = "username" id = "username" /><br />
                        <label for = "password">Password:</label><input type = "password" name = "password" id = "password" /><br />
                        <input type = "submit" name = "login" id = "login" value = "Login" />
                    </fieldset>
                </form>
            <?php } ?>

        </div>
    </body>
</html>