<?php
define('INCLUDE_CHECK', true);
require 'connect.php';
require 'functions.php';
session_name('esnBCNLogin');
session_set_cookie_params(1 * 7 * 24 * 60 * 60);
session_start();
include('panel.php');
?>
<?php if ($_SESSION['email']):
    ?>
    <div class="pageContent">
        <div id="main">

            <div class="container">
                <h1>Get your Receipt</h1>
                <p>We are working on it!</p>
                
            </div>
            
            
        </div>

    <?php endif; ?>

</div>
</body>
</html>
