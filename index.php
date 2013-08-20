<?php
define('INCLUDE_CHECK', true);
require 'connect.php';
require 'functions.php';
session_name('esnBCNLogin');
session_set_cookie_params(1 * 7 * 24 * 60 * 60);
session_start();

if ($_SESSION['email'] && !isset($_COOKIE['esnRemember']) && !$_SESSION['rememberMe'])
{
    // If you are logged in, but you don't have the esnRemember cookie (browser restart)
    // and you have not checked the rememberMe checkbox:

    $_SESSION = array();
    session_destroy();

    // Destroy the session
}


if (isset($_GET['logoff']))
{
    $_SESSION = array();
    session_destroy();

    header("Location: index.php");
    exit;
}

if ($_POST['submit'] == 'Login')
{
    // Checking whether the Login form has been submitted

    $err = array();
    // Will hold our errors

    if (!$_POST['email'] || !$_POST['password'])
        $err[] = 'All the fields must be filled in!';

    if (!count($err))
    {
        $_POST['email'] = mysql_real_escape_string($_POST['email']);
        $_POST['password'] = mysql_real_escape_string($_POST['password']);
        $_POST['rememberMe'] = (int) $_POST['rememberMe'];

        // Escaping all input data

        $row = mysql_fetch_assoc(
                mysql_query("SELECT email, name 
                            FROM users 
                            WHERE email='{$_POST['email']}' 
                            AND pass='" . md5($_POST['password']) . "'")
        );

        if ($row['email'])
        {
            // If everything is OK login

            $_SESSION['email'] = $row['email'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['rememberMe'] = $_POST['rememberMe'];

            // Store some data in the session

            setcookie('esnRemember', $_POST['rememberMe']);
        }
        else
            $err[] = 'Wrong email and/or password!';
    }

    if ($err)
        $_SESSION['msg']['login-err'] = implode('<br />', $err);
    // Save the error messages in the session

    header("Location: index.php");
    exit;
}
else if ($_POST['submit'] == 'Register')
{
    // If the Register form has been submitted

   /* $err = array();

    if (!checkEmail($_POST['email']))
    {
        $err[] = 'Your email is not valid!';
    }

    if (!count($err))
    {
        // If there are no errors

        $pass = substr(md5($_SERVER['REMOTE_ADDR'] . microtime() . rand(1, 100000)), 0, 8);
        // Generate a random password

        $_POST['email'] = mysql_real_escape_string($_POST['email']);
        $_POST['name'] = mysql_real_escape_string($_POST['name']);
        // Escape the input data

        mysql_query("INSERT INTO users (email,pass,name,dt)
                    VALUES(		
			'" . $_POST['email'] . "',
			'" . md5($pass) . "',
			'" . $_POST['name'] . "',
			NOW()
	)");

        //TODO mas cosas al mail
        if (mysql_affected_rows($link) == 1)
        {
            $body = "Hello " . $_POST['name'] . ",
                    \nYour password is: " . $pass . "
                    \nNow you can go (http://esnbarcelona.org/sites/ibiza2012/) and log into the system. 
                    \nRemember fill out your information and upload the necessary documents in order to complete your registration
                    \n
                    \nFor any doubt about the trip contact with ibiza@esnbarcelona.org or if you have some technical problem try with tech.service@esnbarcelona.org
                    \n
                    ESN BARCELONA";

            send_mail('no-reply@esnbarcelona.org', $_POST['email'], 'Ibiza 2012 Registration System - Your New Password', $body);

            $_SESSION['msg']['reg-success'] = 'We sent you an email with your new password!';
        }
        else
            $err[] = 'We already sent an email to your account!';
    }

    if (count($err))
    {
        $_SESSION['msg']['reg-err'] = implode('<br />', $err);
    }

    header("Location: index.php");
    exit;*/
}
else if ($_POST['submit'] == 'Recover')
{
    $err = array();

    if (!checkEmail($_POST['email']))
    {
        $err[] = 'Your email is not valid!';
    }
    if (!count($err))
    {
        $_POST['email'] = mysql_real_escape_string($_POST['email']);

        $sql = "SELECT email, name 
                            FROM users 
                            WHERE email='{$_POST['email']}'";

        $result = mysql_num_rows(mysql_query($sql));

        if ($result)
        {
            $pass = substr(md5($_SERVER['REMOTE_ADDR'] . microtime() . rand(1, 100000)), 0, 8);

            $sql = "UPDATE users SET pass = '" . md5($pass) . "'
                                 WHERE email='{$_POST['email']}'";

            mysql_query($sql);

            $body = "Hello,
                    \nYour new password is: " . $pass . "
                    \nNow you can go (http://esnbarcelona.org/sites/ibiza2012/) and log into the system. 
                    \nRemember fill out your information and upload the necessary documents in order to complete your registration
                    \n
                    \n
                    ESN BARCELONA";

            send_mail($_POST['email'], $_POST['email'], 'Ibiza 2012 Registration System - Recovering a new Password', $body);

            $_SESSION['msg']['login-success'] = 'We sent you an email with your new password!';
        }
        else
        {
            $err[] = "Your mail is not registered! Please register first!";
        }
    }

    if (count($err))
    {
        $_SESSION['msg']['login-err'] = implode('<br />', $err);
    }

    header("Location: index.php");
    exit;
}

$script = '';

if ($_SESSION['msg'])
{
    // The script below shows the sliding panel on page load

    $script = '
	<script type="text/javascript">
	
		$(function(){
		
			$("div#panel").show();
			$("#toggle a").toggle();
		});
	
	</script>';
}
?>

<?php include('panel.php'); ?>

<div class="pageContent">
    <div id="main">
        <div class="container">
            <h1>Ibiza 2012</h1>
            <h2>Registration form for the best trip ever</h2>
        </div>

        <?php
        if (isset($_SESSION['email']))
        {
            $sql = "SELECT * 
                            FROM users 
                            WHERE email='{$_SESSION['email']}'";
            $row = mysql_fetch_assoc(mysql_query($sql));

            echo '<div class="container">';
            echo '<h3>Things you must do!</h3></br>';

            if($row['valido'])
            {
                 $did = '<font color="00ff00"><strong>GREAT! You are IN!!! ;)</strong></font>';
            }
            echo '<p> '. $did . '</p>';
            
            if ($row['id'])
            {
                $did = '<font color="00ff00"><strong>DONE!</strong></font>';
            }
            else
            {
                $did = '<font color="ff0000">To Do!</font>';
            }
            echo '<p><strong>Fill your data: </strong>' . $did . '</p>';

            if ($row['fileID'])
            {
                $did = '<font color="00ff00"><strong>DONE!</strong></font>';
            }
            else
            {
                $did = '<font color="ff0000">To Do!</font>';
            }
            echo '<strong>Upload ID copy: </strong>' . $did . '</p>';

            if ($row['fileESNCARD'])
            {
                $did = '<font color="00ff00"><strong>DONE!</strong></font>';
            }
            else
            {
                $did = '<font color="ff0000">To Do!</font>';
            }
            echo '<strong>Upload ESNCard copy: </strong>' . $did . '</p>';

            if ($row['filePago'])
            {
                $did = '<font color="00ff00"><strong>DONE!</strong></font>';
            }
            else
            {
                $did = '<font color="ff0000">To Do!</font>';
            }
            echo '<strong>Upload Ibiza Payment: </strong>' . $did . '</p>';

            if ($row['fileExencion'])
            {
                $did = '<font color="00ff00"><strong>DONE!</strong></font>';
            }
            else
            {
                $did = '<font color="ff0000">To Do!</font>';
            }
            echo '<strong>Upload Exemption of responsibility: </strong>' . $did . '</p>';

            if ($row['filePolicia'])
            {
                $did = '<font color="00ff00"><strong>DONE!</strong></font>';
            }
            else
            {
                $did = '<font color="ff0000">To Do!</font>';
            }
            echo '<strong>Upload Police document: </strong>' . $did . '</p>';


            echo '</div>';
        }
        ?>

        <?php include('info.php');?>

        <?php include('foot.php'); ?> 
    </div>
</div>

</body>
</html>
