<?php
define('INCLUDE_CHECK', true);
require 'connect.php';
require 'functions.php';
session_name('esnBCNLogin');
session_set_cookie_params(1 * 7 * 24 * 60 * 60);
session_start();

if ($_POST['submit'] == "Update Password")
{
    $err = array();

    $sql = "SELECT pass 
            FROM users 
            WHERE email='{$_SESSION['email']}'";

    $row = mysql_fetch_assoc(mysql_query($sql));

    if ($row['pass'] == md5($_POST['cpass']))
    {
        if ($_POST['npass'] === $_POST['nnpass'])
        {
            $sql = "UPDATE users SET pass = '" . md5($_POST['npass']) . "'
                                 WHERE email='{$_SESSION['email']}'";

            mysql_query($sql);
            
            $_SESSION['msg']['reg-success'] = "Your password has been changed";
        }
        else
        {
            $err = "Yours new passwords do not match. Try again!";
        }
    }
    else
    {
        $err = "Your current password does not match with the password you put";
    }

    if (count($err))
    {
        $_SESSION['msg']['reg-err'] = implode('<br />', $err);
    }
}

include ("panel.php");
if ($_SESSION['email']):
    ?>
    <div class="pageContent">
        <div id="main">

            <div class="container">

                <h1>Change your password</h1>

                <form method="post" class="clearfix" action="pass.php">                   
                    <label>Email Address:</label>
                    <label> <?php echo $_SESSION['email']; ?> </label>
                    <br/><br/>

                    <?php
                    if ($_SESSION['msg']['reg-err'])
                    {
                        echo '<div class="err">' . $_SESSION['msg']['reg-err'] . '</div><br/>';
                        unset($_SESSION['msg']['reg-err']);
                    }

                    if ($_SESSION['msg']['reg-success'])
                    {
                        echo '<div class="success">' . $_SESSION['msg']['reg-success'] . '</div><br/>';
                        unset($_SESSION['msg']['reg-success']);
                    }
                    ?>

                    <label for="cpass">Current Password:</label>
                    <input type="password" name="cpass" id="cpass" value= "" />
                    <br/><br/>
                    <label for="npass">New Password: (Min 8 characters)</label>
                    <input type="password" name="npass" id="npass" value= "" />
                    <br/><br/>
                    <label for="nnpass">Confirm Password</label>
                    <input type="password" name="nnpass" id="nnpass" value= "" />
                    <br/><br/>
                    <input type="submit" name="submit" value="Update Password" class="bt_register" />
                </form>
            </div>
            
            <?php include('foot.php'); ?> 
            
        </div>
        <?php
    endif;
    ?>
</div>


</body>
</html>