<?php
define('INCLUDE_CHECK', true);
require "../connect.php";
require "../functions.php";

session_name('esnBCNRegistro');
session_start();

if (!$_SESSION['Username'] && !$_SESSION['LoggedIn'])
{
    header("Location: ../index.php");
    exit;
}

if ($_POST["action"] == "validoDatos")
{
    if ($_POST['valido'] != "")
    {
        if ($_POST['valido'] == 3)
        {
            $sql = "UPDATE users SET valido = '3' WHERE email ='{$_POST['email']}'";
        }
        else
        {
            $sql = "UPDATE users SET validoDatos = '" . $_POST['valido'] . "'
                         WHERE email='{$_POST['email']}'";
        }
        mysql_query($sql);
    }
}
elseif ($_POST["action"] == "pago")
{
    if ($_POST['valido'] != "")
    {
        $sql = "UPDATE users SET pago = '" . $_POST['valido'] . "'
                         WHERE email='{$_POST['email']}'";
        mysql_query($sql);
    }
}
elseif ($_POST["action"] == "exencion")
{
    if ($_POST['valido'] != "")
    {
        $sql = "UPDATE users SET exencion = '" . $_POST['valido'] . "'
                         WHERE email='{$_POST['email']}'";
        mysql_query($sql);
    }
}
elseif ($_POST["action"] == "policia")
{
    if ($_POST['valido'] != "")
    {
        $sql = "UPDATE users SET policia = '" . $_POST['valido'] . "'
                         WHERE email='{$_POST['email']}'";
        mysql_query($sql);
    }
}
elseif ($_POST["action"] == "send")
{
     $sql = "UPDATE users
            SET valido = '1'
            WHERE email='{$_POST['email']}'";
            
        mysql_query($sql);
    
    $from = "no-reply@esnbarcelona.org";
    $to = $_POST['email'];
    $subject = "Ibiza 2012 Registration System - You got a place!!!!";


    $body = "SPANISH/ENGLISH

\n¡FELICIDADES, YA TIENES TU PLAZA EN EL ESN IBIZA TRIP 2012 con ESN BARCELONA!

\nHas seguido correctamente todos los pasos. Ahora sé paciente. Pronto te enviaremos más información sobre el viaje.

\nMientras esperas a que llegue el gran día, puedes conocer a los más de 3000 estudiantes que nos juntaremos en Ibiza en: <a href=" . "http://www.facebook.com/groups/248674291878807/" . ">link</a>

\nPara cualquier duda contacta con ibiza@esnbarcelona.org o si es un problema técnico con tech.service@esnbarcelona.org

\n¡Nos vemos muy pronto!

\nESN BCN IBIZA TEAM

--

\nCONGRATULATIONS, YOU ALREADY HAVE YOUR PLACE IN THE ESN IBIZA TRIP 2012 by ESN BARCELONA!

\nNow be patient. We will soon send you more info about the trip.

\nWhile you wait for the big day, you can start meeting the 3000 student that will join in Ibiza in: <a href=" . "http://www.facebook.com/groups/248674291878807/" . ">link</a>

\nFor any doubt send a mail to ibiza@esnbarcelona.org or if you have a technical problem try with tech.service@esnbarcelona.org

\nSee you very soon!

\nESN BCN IBIZA TEAM";


    send_mail($from, $to, $subject, $body);

    //TODO hacer que no puedan enviar nada mas
}
elseif ($_POST["action"] == "sendDatos")
{    
    
    $sql = "SELECT fileID, fileESNCARD
            FROM users
            WHERE email='{$_POST['email']}'";
            
    $row = mysql_fetch_assoc(mysql_query($sql));
    
    unlink(getcwd(). '/..' . $row['fileID']);
    unlink(getcwd(). '/..' . $row['fileESNCARD']);
    
    $sql = "UPDATE users SET fileID = NULL,
                             fileESNCARD = NULL
                         WHERE email='{$_POST['email']}'";

    mysql_query($sql);
    
    $from = "no-reply@esnbarcelona.org";
    $to = $_POST['email'];
    $subject = "Ibiza 2012 Registration System - Problem with your data";
    $body = "SPANISH/ENGLISH

\n¡Hola!

\nLos datos que nos has dado no son válidos. Por favor, asegúrate que los datos coinciden con los de tu DNI o Pasaporte y que tú ESN Card se encuentra debidamente rellenada. Comprueba que los documentos están bien escaneados y vuélvelos a subir con suficiente calidad para que podamos identificar todas las letras y números. Ten en cuenta que si se trata de tu ID tienes que subir las dos caras.
Recuerda que si no nos envías todos los documentos correctamente no podremos confirmar tu plaza.

\nPara cualquier duda contacta con ibiza@esnbarcelona.org o si es un problema técnico con tech.service@esnbarcelona.org

\nMuchas gracias.

\nESN BCN IBIZA TEAM

--

\nHi!

\nThe data you provided is not valid. Please, make sure that the data is the same as in your ID or Passport and your ESN Card is properly filled in. Check that the documents are properly scanned and re-upload it with enough quality such that we are able to identify every letter and number. Take into account, that if you upload your ID you have to send both front and rear part.
Remember, that we will not be able to confirm your place until you correctly send us all the documents.

\nFor any doubt send a mail to ibiza@esnbarcelona.org or if you have a technical problem try with tech.service@esnbarcelona.org

\nThank you.

\nESN BCN IBIZA TEAM";

    send_mail($from, $to, $subject, $body);
}
elseif ($_POST["action"] == "sendPago")
{    
    
      $sql = "SELECT filePago
            FROM users
            WHERE email='{$_POST['email']}'";
            
    $row = mysql_fetch_assoc(mysql_query($sql));
    
    unlink(getcwd(). '/..' . $row['filePago']);
    
    $sql = "UPDATE users SET filePago = NULL
                         WHERE email='{$_POST['email']}'";

    mysql_query($sql);
    
    
    $from = "no-reply@esnbarcelona.org";
    $to = $_POST['email'];
    $subject = "Ibiza 2012 Registration System - Problem with your Payment copy";
    $body = "SPANISH/ENGLISH

\n¡Hola!

\nLa copia de tu RECIBO DE PAGO no es válida. Por favor, asegúrate que está bien escaneada y vuélvela a subir con suficiente calidad para que podamos identificar todas las letras y números.
Recuerda que si no nos envías todos los documentos correctamente no podremos confirmar tu plaza.

\nPara cualquier duda contacta con ibiza@esnbarcelona.org o si es un problema técnico con tech.service@esnbarcelona.org

\nMuchas gracias.

\nESN BCN IBIZA TEAM

\n--

\nHi!

\nYour PROOF OF PAYMENT copy is not valid. Please, make sure that it is properly scanned and re-upload it with enough quality such that we are able to identify every letter and number.
Remember, that we will not be able to confirm your place until you correctly send us all the documents.

\nFor any doubt send a mail to ibiza@esnbarcelona.org or if you have a technical problem try with tech.service@esnbarcelona.org

\nThank you.

\nESN BCN IBIZA TEAM";

    send_mail($from, $to, $subject, $body);
}
elseif ($_POST["action"] == "sendExencion")
{
    
    $sql = "SELECT fileExencion
            FROM users
            WHERE email='{$_POST['email']}'";
            
    $row = mysql_fetch_assoc(mysql_query($sql));
    
    unlink(getcwd(). '/..' . $row['fileExencion']);
    
    $sql = "UPDATE users SET fileExencion = NULL
                         WHERE email='{$_POST['email']}'";

    mysql_query($sql);
    
    
    $from = "no-reply@esnbarcelona.org";
    $to = $_POST['email'];
    $subject = "Ibiza 2012 Registration System - Problem with your Exemption of responsibility";
    $body = "SPANISH/ENGLISH

\n¡Hola!

\nHemos encontrado algún problema con tu documento de “EXENCIÓN DE RESPONSABILIDAD”. Por favor, asegúrate que está bien rellenado (<a href=" . "http://esnbarcelona.org/sites/ibiza2012/docs/EJEMPLO_FormularioResponsabilidad.doc" . ">aquí tiene un ejemplo</a>) y vuélvelo a subir con suficiente calidad para que podamos identificar todas las letras y números.
Recuerda que si no nos envías todos los documentos correctamente no podremos confirmar tu plaza.

\nPara cualquier duda contacta con ibiza@esnbarcelona.org o si es un problema técnico con tech.service@esnbarcelona.org

\nMuchas gracias.

\nESN BCN IBIZA TEAM

\n--

\nHi!

\nWe found a problem with your document of “EXEMPTION OF RESPONSIBILITY”. Pleas, make sure that it is properly filled in (<a href=" . "http://esnbarcelona.org/sites/ibiza2012/docs/EJEMPLO_FormularioResponsabilidad.doc" . ">here you are an example</a>) and re-upload it with enough quality such that we are able to identify every letter and number.

\nRemember, that we will not be able to confirm your place until you correctly send us all the documents.

\nFor any doubt send a mail to ibiza@esnbarcelona.org or if you have a technical problem try with tech.service@esnbarcelona.org

\nThank you.

\nESN BCN IBIZA TEAM";

    send_mail($from, $to, $subject, $body);
}
elseif ($_POST["action"] == "sendPolicia")
{
    
    $sql = "SELECT filePolicia
            FROM users
            WHERE email='{$_POST['email']}'";
            
    $row = mysql_fetch_assoc(mysql_query($sql));
    
    unlink(getcwd(). '/..' . $row['filePolicia']);
    
    $sql = "UPDATE users SET filePolicia = NULL
                         WHERE email='{$_POST['email']}'";

    mysql_query($sql);
    
    
    $from = "no-reply@esnbarcelona.org";
    $to = $_POST['email'];
    $subject = "Ibiza 2012 Registration System - Problem with your Police document";
    $body = "SPANISH/ENGLISH

\n¡Hola!

\nHemos encontrado algún problema con el “DOCUMENTO DE LA POLICÍA” . Por favor, asegúrate que está bien rellenado (<a href=" . "http://esnbarcelona.org/sites/ibiza2012/docs/EJEMPLO_FormularioResponsabilidad.doc" . ">aquí tiene un ejemplo</a>) y vuélvelo a subir con suficiente calidad para que podamos identificar todas las letras y números.
Recuerda que si no nos envías todos los documentos correctamente no podremos confirmar tu plaza.

\nPara cualquier duda contacta con ibiza@esnbarcelona.org o si es un problema técnico con tech.service@esnbarcelona.org

\nMuchas gracias.

\nESN BCN IBIZA TEAM

\n--

\nHi!

\nWe found a problem with your “POLICE DOCUMENT”. Please, make sure that it is properly filled in (<a href=" . "http://esnbarcelona.org/sites/ibiza2012/docs/EJEMPLO_FormularioResponsabilidad.doc" . ">here you are an example</a>) and re-upload it with enough quality such that we are able to identify every letter and number.
Remember, that we will not be able to confirm your place until you correctly send us all the documents.

\nFor any doubt send a mail to ibiza@esnbarcelona.org or if you have a technical problem try with tech.service@esnbarcelona.org

\nThank you.

\nESN BCN IBIZA TEAM";

    send_mail($from, $to, $subject, $body);
}

if ($_POST["action"])
{
    header('Location: registro.php#' . $_POST['email']);
    exit;
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Ibiza 2012 Registro</title>

        <style type="text/css">
            table.db-table 	{ border-right:1px solid #ccc; border-bottom:1px solid #ccc; }
            table.db-table th	{ background:#eee; padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
            table.db-table td	{ padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
        </style>
    </head>
    <body>
        <?php
        $url = "http://esnbarcelona.org/sites/ibiza2012";
        
        echo '<h1>Estadísticas</h1>';

        echo '<h2>Registrados</h2>';
        $sql = "SELECT COUNT(*) as num FROM users";

        $result = mysql_fetch_assoc(mysql_query($sql));

        echo 'Total registrados: ' . $result['num'];
        echo "<br />";

        $sql = "SELECT COUNT(*) as num FROM users WHERE valido=1";
        $result = mysql_fetch_assoc(mysql_query($sql));
        echo '<b>Validados:</b> ' . $result['num'];

        echo '<h2>Mulleres y Salidos</h2>';
        $query = "SELECT gender, COUNT(email) FROM users WHERE valido=1 GROUP BY gender";

        $result = mysql_query($query);

        while ($row = mysql_fetch_array($result))
        {
            echo "There are " . $row['COUNT(email)'] . " " . $row['gender'] . ".";
            echo "<br />";
        }

        echo '<h2>Camisetas Mojadas</h2>';
        $query = "SELECT shirt, COUNT(email) FROM users WHERE valido=1 GROUP BY shirt";

        $result = mysql_query($query);

        while ($row = mysql_fetch_array($result))
        {
            echo "There are " . $row['COUNT(email)'] . " " . $row['shirt'] . ".";
            echo "<br />";
        }

        echo '<h2>MadUniversities</h2>';
        $query = "SELECT uni, COUNT(email) FROM users WHERE valido=1 GROUP BY uni";

        $result = mysql_query($query);

        while ($row = mysql_fetch_array($result))
        {
            echo "There are " . $row['COUNT(email)'] . " " . $row['uni'] . ".";
            echo "<br />";
        }


        echo '<h1>Registro</h1>';
        $result = mysql_query("SELECT email,id,esncard,name,lastname,gender,fileID,fileESNCARD,phone,uni,nac,shirt,validoDatos,exencion,fileExencion,pago,filePago,policia,filePolicia,valido FROM users ORDER BY ISNULL(lastname),lastname");
        if (mysql_num_rows($result))
        {
            echo '<table cellpadding="0" cellspacing="0" class="db-table">';
            echo '<tr>
                <th>Email</th>
                <th>ID</th>
                <th>ESNCARD</th>
                <th>Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>File ID</th>
                <th>File ESN</th>
                <th>Phone</th>
                <th>Uni</th>
                <th>Nat</th>
                <th>Shirt</th>
                <th>Validos?</th>
                <th>ValDatos</th>
                <th>File Pago</th>
                <th>Pago?</th>
                <th>ValPago</th>
                <th>File Exencion</th>
                <th>Exencion?</th>
                <th>Val Exencion</th>
                <th>File Policia</th>
                <th>Policia?</th>
                <th>Val Policia</th>
                <th>Enviar Mail</th>

            </tr>';
            while ($row = mysql_fetch_assoc($result))
            {
                echo '<tr>';

                /*echo $row['valido'] ? '<td bgcolor="#00ff00"><a name="' . $row['email'] . '"a>' . $row['email'] . '</a></td>' : '<td><a name="' . $row['email'] . '"a>' . $row['email'] . '</a></td>';
                echo $row['valido'] ? '<td bgcolor="#00ff00">' . $row['id'] . '</td>' : '<td>' . $row['id'] . '</td>';
                echo $row['valido'] ? '<td bgcolor="#00ff00">' . $row['esncard'] . '</td>' : '<td>' . $row['esncard'] . '</td>';
                echo $row['valido'] ? '<td bgcolor="#00ff00">' . $row['name'] . '</td>' : '<td>' . $row['name'] . '</td>';
                echo $row['valido'] ? '<td bgcolor="#00ff00">' . $row['lastname'] . '</td>' : '<td>' . $row['lastname'] . '</td>';
                echo $row['valido'] ? '<td bgcolor="#00ff00">' . $row['gender'] . '</td>' : '<td>' . $row['gender'] . '</td>';*/
                
                if ($row['valido'] == 0)
                {
                    echo '<td><a name="' . $row['email'] . '"a>' . $row['email'] . '</a></td>';
                    echo '<td>' . $row['id'] . '</td>';
                    echo '<td>' . $row['esncard'] . '</td>';
                    echo '<td>' . $row['name'] . '</td>';
                    echo '<td>' . $row['lastname'] . '</td>';
                    echo '<td>' . $row['gender'] . '</td>';                    
                }
                else if($row['valido'] == 1)
                {
                    echo '<td bgcolor="#00ff00"><a name="' . $row['email'] . '"a>' . $row['email'] . '</a></td>';
                    echo '<td bgcolor="#00ff00">' . $row['id'] . '</td>';
                    echo '<td bgcolor="#00ff00">' . $row['esncard'] . '</td>';
                    echo '<td bgcolor="#00ff00">' . $row['name'] . '</td>';
                    echo '<td bgcolor="#00ff00">' . $row['lastname'] . '</td>';
                    echo '<td bgcolor="#00ff00">' . $row['gender'] . '</td>';     
                }
                else if ($row['valido'] == 3)
                {
                    echo '<td bgcolor="#FFFF00"><a name="' . $row['email'] . '"a>' . $row['email'] . '</a></td>';
                    echo '<td bgcolor="#FFFF00">' . $row['id'] . '</td>';
                    echo '<td bgcolor="#FFFF00">' . $row['esncard'] . '</td>';
                    echo '<td bgcolor="#FFFF00">' . $row['name'] . '</td>';
                    echo '<td bgcolor="#FFFF00">' . $row['lastname'] . '</td>';
                    echo '<td bgcolor="#FFFF00">' . $row['gender'] . '</td>';     
                }
                

                if ($row['fileID'])
                {
                    if ($row['validoDatos'] == 1)
                    {
                        echo '<td bgcolor="#00ff00"><a href=' . $url . $row['fileID'] . '>Ver</a> </td>';
                    }
                    else echo '<td><a href=' . $url . $row['fileID'] . '>Ver</a> </td>';
                }
                else
                {
                    echo '<td>', $row['fileID'], '</td>';
                }

                if ($row['fileESNCARD'])
                {
                    if ($row['validoDatos'] == 1)
                    { 
                        echo '<td bgcolor="#00ff00"><a href=' . $url . $row['fileESNCARD'] . '>Ver</a> </td>';
                    } 
                    else echo'<td><a href=' . $url . $row['fileESNCARD'] . '>Ver</a> </td>';
                }
                else
                {
                    echo '<td>', $row['fileESNCARD'], '</td>';
                }

                if ($row['valido'] == 0)
                {
                    echo '<td>' . $row['phone'] . '</td>';
                    echo '<td>' . $row['uni'] . '</td>';
                    echo '<td>' . $row['nac'] . '</td>';
                    echo '<td>' . $row['shirt'] . '</td>';
                }
                else if($row['valido'] == 1)
                {
                    echo '<td bgcolor="#00ff00">' . $row['phone'] . '</td>';
                    echo '<td bgcolor="#00ff00">' . $row['uni'] . '</td>';
                    echo '<td bgcolor="#00ff00">' . $row['nac'] . '</td>';
                    echo '<td bgcolor="#00ff00">' . $row['shirt'] . '</td>';
                }
                else if ($row['valido'] == 3)
                {
                    echo '<td bgcolor="#ffff00">' . $row['phone'] . '</td>';
                    echo '<td bgcolor="#ffff00">' . $row['uni'] . '</td>';
                    echo '<td bgcolor="#ffff00">' . $row['nac'] . '</td>';
                    echo '<td bgcolor="#ffff00">' . $row['shirt'] . '</td>';
                }
                
                /*echo $row['valido'] ? '<td bgcolor="#00ff00">' . $row['phone'] . '</td>' : '<td>' . $row['phone'] . '</td>';
                echo $row['valido'] ? '<td bgcolor="#00ff00">' . $row['uni'] . '</td>' : '<td>' . $row['uni'] . '</td>';
                echo $row['valido'] ? '<td bgcolor="#00ff00">' . $row['nac'] . '</td>' : '<td>' . $row['nac'] . '</td>';
                echo $row['valido'] ? '<td bgcolor="#00ff00">' . $row['shirt'] . '</td>' : '<td>' . $row['shirt'] . '</td>';*/

                //---------------Validacion de Datos
                if ($row['validoDatos'])
                {
                    echo '<td bgcolor="#00ff00"> OK </td>';
                }
                else
                {
                    echo '<td bgcolor="#ff0000" > :( 

                    <form method="post" action="registro.php">
                        <input type="submit" name="submit" value="Send?" />
                        <input name="action" type="hidden" value="sendDatos" /> 
                        <input name="email" type="hidden" value="' . $row['email'] . '" />
                    </form>
                </td>';
                }

                echo '<td> 
                    <form method="post" action="registro.php">
                        <select id="valido" name="valido"> 
                            <option value=""></option>	
                            <option value="1">OK</option> 
                            <option value="0">:(</option>
                            <option value="3">Cancelar</option>
                        </select>
                        <input type="submit" name="submit" value="OK?" />
                        <input name="action" type="hidden" value="validoDatos" /> 
                        <input name="email" type="hidden" value="' . $row['email'] . '" />
                    </form>

                </td>';

                //------------------Validacion de Pago
                if ($row['filePago'])
                {
                    echo $row['pago'] ? '<td bgcolor="#00ff00"><a href=' . $url . $row['filePago'] . '>Ver</a> </td>' : '<td> <a href=' . $url . $row['filePago'] . '>Ver</a> </td>';
                }
                else
                {
                    echo '<td>', $row['filePago'], '</td>';
                }

                if ($row['pago'])
                {
                    echo '<td bgcolor="#00ff00"> OK </td>';
                }
                else
                {
                    echo '<td bgcolor="#ff0000" > :( 

                    <form method="post" action="registro.php">
                        <input type="submit" name="submit" value="Send?" />
                        <input name="action" type="hidden" value="sendPago" /> 
                        <input name="email" type="hidden" value="' . $row['email'] . '" />
                    </form>
                </td>';
                }

                echo '<td> 
                    <form method="post" action="registro.php">
                        <select id="valido" name="valido"> 
                            <option value=""></option>	
                            <option value="1">OK</option> 
                            <option value="0">:(</option>
                        </select>
                        <input type="submit" name="submit" value="OK?" />
                        <input name="action" type="hidden" value="pago" /> 
                        <input name="email" type="hidden" value="' . $row['email'] . '" />
                    </form>

                </td>';

                //-----------------------Validacion exencion
                if ($row['fileExencion'])
                {
                    echo $row['exencion'] ? '<td bgcolor="#00ff00"><a href=' . $url . $row['fileExencion'] . '>Ver</a> </td>' : '<td><a href=' . $url . $row['fileExencion'] . '>Ver</a> </td>';
                }
                else
                {
                    echo '<td>', $row['fileExencion'], '</td>';
                }

                if ($row['exencion'])
                {
                    echo '<td bgcolor="#00ff00"> OK </td>';
                }
                else
                {
                    echo '<td bgcolor="#ff0000" > :( 

                    <form method="post" action="registro.php">
                        <input type="submit" name="submit" value="Send?" />
                        <input name="action" type="hidden" value="sendExencion" /> 
                        <input name="email" type="hidden" value="' . $row['email'] . '" />
                    </form>
                </td>';
                }

                echo '<td> 
                    <form method="post" action="registro.php">
                        <select id="valido" name="valido"> 
                            <option value=""></option>	
                            <option value="1">OK</option> 
                            <option value="0">:(</option>
                        </select>
                        <input type="submit" name="submit" value="OK?" />
                        <input name="action" type="hidden" value="exencion" /> 
                        <input name="email" type="hidden" value="' . $row['email'] . '" />
                    </form>

                </td>';
                //--------------------------------------validacion policia
                if ($row['filePolicia'])
                {
                    echo $row['policia'] ? '<td bgcolor="#00ff00"><a href=' . $url . $row['filePolicia'] . '>Ver</a> </td>' : '<td><a href=' . $url . $row['filePolicia'] . '>Ver</a> </td>';
                }
                else
                {
                    echo '<td>', $row['filePolicia'], '</td>';
                }

                if ($row['policia'])
                {
                    echo '<td bgcolor="#00ff00"> OK </td>';
                }
                else
                {
                    echo '<td bgcolor="#ff0000" > :( 

                    <form method="post" action="registro.php">
                        <input type="submit" name="submit" value="Send?" />
                        <input name="action" type="hidden" value="sendPolicia" /> 
                        <input name="email" type="hidden" value="' . $row['email'] . '" />
                    </form>
                </td>';
                }

                echo '<td> 
                    <form method="post" action="registro.php">
                        <select id="valido" name="valido"> 
                            <option value=""></option>	
                            <option value="1">OK</option> 
                            <option value="0">:(</option>
                        </select>
                        <input type="submit" name="submit" value="OK?" />
                        <input name="action" type="hidden" value="policia" /> 
                        <input name="email" type="hidden" value="' . $row['email'] . '" />
                    </form>

                </td>';

                //-------------------mail de confirmacion

                echo '<form method="post" action="registro.php">';

                if ($row['validoDatos'] && $row['pago'] && $row['exencion'] && $row['policia'])
                {
                    if ($row['valido'] == 1)
                    {
                        echo '<td bgcolor="#00ff00"><input type="submit" name="submit" value="Send?" />';
                    }
                    else
                    {
                        echo '<td bgcolor="#FFA500"><input type="submit" name="submit" value="Send?" />';
                    }
                }
                else
                {
                    echo '<td><input type="submit" name="submit" value="Send?" disabled="disabled" />';
                }

                echo '<input name="action" type="hidden" value="send" /> 
                    <input name="email" type="hidden" value="' . $row['email'] . '" />
            </form>
        </td>';

                echo '</tr>';
            }
            echo '</table><br />';
            
            
            echo '<h2>Nacionalidades</h2>';
        $query = "SELECT nac, COUNT(email) FROM users WHERE valido=1 GROUP BY nac";

        $result = mysql_query($query);

        while ($row = mysql_fetch_array($result))
        {
            echo "There are " . $row['COUNT(email)'] . " " . $row['nac'] . ".";
            echo "<br />";
        }
                  
        }
        ?>
    </body>
</html>

