<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Ibiza 2012 Calling</title>

        <link rel="stylesheet" type="text/css" href="style.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="login_panel/css/slide.css" media="screen" />

        <link rel="icon" type="image/png" href="favicon.png" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

        <!-- PNG FIX for IE6 -->
        <!-- http://24ways.org/2007/supersleight-transparent-png-in-ie6 -->
        <!--[if lte IE 6]>
            <script type="text/javascript" src="login_panel/js/pngfix/supersleight-min.js"></script>
        <![endif]-->

        <script src="login_panel/js/slide.js" type="text/javascript"></script>

        <?php echo $script; ?>
    </head>

    <body>
        <!-- Panel -->
        <div id="toppanel">
            <div id="panel">
                <div class="content clearfix">
                    <div class="left">
                        <h1>ESN Barcelona</h1>
                        <h2>Welcome to IBIZA 2012 Registration</h2>		
                        <p class="grey">You need to register in order to get your place in IBIZA 2012</p>
                        <h2>Remember!!!</h2>
                        <p class="grey">Registration is just the first step, you need to log into the app and fill out all the info!!</p>
                    </div>


                    <?php
                    if (!$_SESSION['email']):
                        ?>

                        <div class="left">
                            <!-- Login Form -->
                            <form class="clearfix" action="" method="post">
                                <h1>Member Login</h1>

                                <?php
                                if ($_SESSION['msg']['login-err'])
                                {
                                    echo '<div class="err">' . $_SESSION['msg']['login-err'] . '</div>';
                                    unset($_SESSION['msg']['login-err']);
                                }
                                
                                if ($_SESSION['msg']['login-success'])
                                {
                                    echo '<div class="success">' . $_SESSION['msg']['login-success'] . '</div>';
                                    unset($_SESSION['msg']['login-success']);
                                }                                
                                ?>

                                <label class="grey" for="email">Email:</label>
                                <input class="field" type="text" name="email" id="email" size="23" />
                                <label class="grey" for="password">Password:</label>
                                <input class="field" type="password" name="password" id="password" size="23" />
                                <label>
                                    <input name="rememberMe" id="rememberMe" type="checkbox" checked="checked" value="1" /> 
                                    &nbsp;Remember me
                                </label>
                                <div class="clear"></div>
                                <input type="submit" name="submit" value="Login" class="bt_login" />
                                <input type="submit" name="submit" value="Recover" class="bt_login" />
                            </form>
                        </div>
                        <div class="left right">			
                            <!-- Register Form -->
                            <form action="" method="post">
                                <h1>Don't be fool!! Register Now!!</h1>		

                                <?php
                                if ($_SESSION['msg']['reg-err'])
                                {
                                    echo '<div class="err">' . $_SESSION['msg']['reg-err'] . '</div>';
                                    unset($_SESSION['msg']['reg-err']);
                                }

                                if ($_SESSION['msg']['reg-success'])
                                {
                                    echo '<div class="success">' . $_SESSION['msg']['reg-success'] . '</div>';
                                    unset($_SESSION['msg']['reg-success']);
                                }
                                ?>

                                <label class="grey" for="email">Email:</label>
                                <input class="field" type="text" name="email" id="email" value="" size="23" />
                                <label class="grey" for="name">Name:</label>
                                <input class="field" type="text" name="name" id="name" size="23" />
                                <label>A password will be e-mailed to you.</label>
                                <input type="submit" name="submit" value="Register" class="bt_register" />
                            </form>
                        </div>

                        <?php
                    else:
                        ?>

                        <div class="left">

                            <h1>Things To Do!</h1>

                            <p><a href="index.php">Right to the beginning</a></p>

                            <p><a href="data.php">Fill your data</a></p>

                            <p><a href="docs.php">Upload your Documents</a></p>

                            <p><a href="receipt.php">[BETA]Get a copy of your receipt</a></p>
                            
                            <p><a href="pass.php">Change your password</a></p>

                            <p><a href="http://www.esnbarcelona.org/content/faqs">Questions? Try our FAQ!</a></p>

                            <p><a href="index.php?logoff">Log off</a></p>

                        </div>

                        <div class="left right">
                            <img src="gesn_star.png" alt =""/>
                        </div>

                    <?php
                    endif;
                    ?>
                </div>
            </div> <!-- /login -->	

            <!-- The tab on top -->	
            <div class="tab">
                <ul class="login">
                    <li class="left">&nbsp;</li>
                    <li>Hello <?php echo $_SESSION['email'] ? $_SESSION['name'] : 'Guest'; ?>!</li>
                    <li class="sep">|</li>
                    <li id="toggle">
                        <a id="open" class="open" href="#"><?php echo $_SESSION['email'] ? 'Open Panel' : 'Log In | Register'; ?></a>
                        <a id="close" style="display: none;" class="close" href="#">Close Panel</a>			
                    </li>
                    <li class="right">&nbsp;</li>
                </ul> 
            </div> <!-- / top -->

        </div> <!--panel -->