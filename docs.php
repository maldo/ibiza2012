<?php
define('INCLUDE_CHECK', true);

require 'connect.php';
require 'functions.php';

session_name('esnBCNLogin');
// Starting the session

session_set_cookie_params(2 * 7 * 24 * 60 * 60);
// Making the cookie live for 2 weeks

session_start();

if (!isset($_SESSION['email']))
{
    header('Location: index.php');
    exit;
}

if ($_POST["action"])
{
    $sql = "SELECT valido
            FROM users
            WHERE email='{$_SESSION['email']}'";
            
    $row = mysql_fetch_assoc(mysql_query($sql));
    
    if ($row['valido'])
    {
        $err = "Your data have been validated and you get your place, so you can not modify your data";
        
        $_SESSION['msg']['reg-err'] = $err;
    }
    else
    {
        uploadFile($_POST["action"]);
    }    
}

include('panel.php');
?>

<div class="pageContent">
    <div id="main">

        <div class="container">

            <h1>Upload your Documents!</h1><br/>

            <h2>Files over 2 Megabytes are not allowed!</h2><br/>

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

            $row = mysql_fetch_assoc(
                    mysql_query("SELECT fileID, fileESNCARD, fileExencion, filePago, filePolicia
                                     FROM users 
                                     WHERE email='{$_SESSION['email']}'")
            );

            $url = "http://esnbarcelona.org/sites/ibiza2012";
            ?>

            <p>Upload a copy of your id card or passport</p>

            <?php
            if ($row['fileID'])
            {
                echo '<p> <strong style="color:green">UPLOADED</strong><a href=' . $url . $row['fileID'] . '> See Uploaded Document</a> </p>';
            }
            ?>

            <form action="docs.php" method="post" enctype="multipart/form-data">
                <input name="archivo" type="file" /><br />
                <input name="enviar" type="submit" value="Upload File" />
                <input name="action" type="hidden" value="ID" />     
            </form>
            <br/>

            <p>Upload a copy of your ESNCard</p>
            <?php
            if ($row['fileESNCARD'])
            {
                echo '<p> <strong style="color:green">UPLOADED</strong><a href=' . $url . $row['fileESNCARD'] . '> See Uploaded Document</a> </p>';
            }
            ?>
            <form action="docs.php" method="post" enctype="multipart/form-data">
                <input name="archivo" type="file" /><br />
                <input name="enviar" type="submit" value="Upload File" />
                <input name="action" type="hidden" value="ESNCARD" />     
            </form> 
            <br/>

            <p>Upload a copy of your ibiza payment</p>
            <?php
            if ($row['filePago'])
            {
                echo '<p> <strong style="color:green">UPLOADED</strong><a href=' . $url . $row['filePago'] . '> See Uploaded Document</a> </p>';
            }
            ?>
            <form action="docs.php" method="post" enctype="multipart/form-data">
                <input name="archivo" type="file" /><br />
                <input name="enviar" type="submit" value="Upload File" />
                <input name="action" type="hidden" value="Pago" />     
            </form> 
            <br/>

            <p>Upload a copy of your Exemption of responsibility</p>
            <p>Get the document of your <a href="http://esnbarcelona.org/sites/ibiza2012/docs/FormularioResponsabilidad.doc">Exemption of responsability</a> and if you need and example take a look to <a href="http://esnbarcelona.org/sites/ibiza2012/docs/EJEMPLO_FormularioResponsabilidad.doc">this document</a> ;)</p> 
            <?php
            if ($row['fileExencion'])
            {
                echo '<p> <strong style="color:green">UPLOADED</strong><a href=' . $url . $row['fileExencion'] . '> See Uploaded Document</a> </p>';
            }
            ?>
            <form action="docs.php" method="post" enctype="multipart/form-data">
                <input name="archivo" type="file" /><br />
                <input name="enviar" type="submit" value="Upload File" />
                <input name="action" type="hidden" value="Exencion" />     
            </form> 
            <br/>

            <p>Upload a copy of your Police document</p>
            <p>Get the document of your <a href="http://esnbarcelona.org/sites/ibiza2012/docs/FormularioPolicia.doc">Exemption of responsability</a> and if you need and example take a look to <a href="http://esnbarcelona.org/sites/ibiza2012/docs/EJEMPLO_FormularioPolicia.doc">this document</a> ;)</p> 
            <?php
            if ($row['filePolicia'])
            {
                echo '<p> <strong style="color:green">UPLOADED</strong><a href=' . $url . $row['filePolicia'] . '> See Uploaded Document</a> </p>';
            }
            ?>
            <form action="docs.php" method="post" enctype="multipart/form-data">
                <input name="archivo" type="file" /><br />
                <input name="enviar" type="submit" value="Upload File" />
                <input name="action" type="hidden" value="Policia" />     
            </form> 
            <br/>

        </div>

<?php include('foot.php'); ?> 

    </div>
</div>
</body>

</html>