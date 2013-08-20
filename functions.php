<?php

if (!defined('INCLUDE_CHECK'))
    die('You are not allowed to execute this file directly');

function checkEmail($str)
{
    return preg_match("/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $str);
}

function send_mail($from, $to, $subject, $body)
{
    $headers = '';
    $headers .= "From: $from\n";
    $headers .= "Reply-to: $from\n";
    $headers .= "Return-Path: $from\n";
    $headers .= "Message-ID: <" . md5(uniqid(time())) . "@" . $_SERVER['SERVER_NAME'] . ">\n";
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "Date: " . date('r', time()) . "\n";

    mail($to, $subject, $body, $headers);
}

function uploadFile($doc)
{
    // obtenemos los datos del archivo
    $size = $_FILES["archivo"]['size'];
    $type = $_FILES["archivo"]['type'];
    $archivo = $_FILES["archivo"]['name'];
    $ext = pathinfo($archivo, PATHINFO_EXTENSION);
    $prefijo = substr(md5(uniqid(rand())), 0, 6);

    $currentdir = getcwd();

    $ok = 1;
    $error = "";

    if ($ext === "php" || $ext === "html" || $ext === "xml" || $ext === "gif" || $ext === "mp3"
            || $ext === "avi" || $ext === "swf" || $ext === "dll" || $ext === "so")
    {
        $ok = 0;
        $error = "Invalid Extension";
    }

    if ($size > 2000000)
    {
        $ok = 0;
        $error = "File too big";
    }

    if ($archivo != "" & $ok)
    {
        $file = "/uploads/" . $doc . "_" . $_SESSION['email'] . "_" . $prefijo . "." . $ext;
        // guardamos el archivo a la carpeta files
        $destino = $currentdir . $file;

        if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino))
        {
            $_SESSION['msg']['reg-success'] = "File Uploaded: <b>" . $archivo . " Successfully</b>";

            $sql = "SELECT file$doc 
                    FROM users 
                    WHERE email = '{$_SESSION['email']}' ";
            //echo $sql;
            $row = mysql_fetch_assoc(mysql_query($sql));

            if ($row['file' . $doc])
            {
                unlink($currentdir . $row['file' . $doc]);
            }

            $sql = "UPDATE users SET file$doc = '" . $file . "'
                    WHERE email='{$_SESSION['email']}'";
            //echo $sql;
            mysql_query($sql);
        }
        else
        {
            $_SESSION['msg']['reg-err'] = "There is some problem uploading your file.
                                            Try Again! " . $error;
        }
    }
    else
    {
        $_SESSION['msg']['reg-err'] = "There is some problem uploading your file. 
                                            Try Again! " . $error;
    }
}

?>