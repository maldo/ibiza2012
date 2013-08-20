<?php

define('INCLUDE_CHECK', true);
require 'connect.php';
require 'functions.php';

$folder = opendir("uploads/");

while (false !== ($oldentry = readdir($folder)))
{
    if ($oldentry != "." && $oldentry != "..")
    {
        //echo $oldentry."\n";

        $corte = explode("_", $oldentry);
        
        $mail;
        
        if (count($corte) > 3)
        {            
            $mail = $corte[1]."_".$corte[2];
        }
        else
            $mail = $corte[1];

        
        //echo $mail."\n";
        
        $ext = pathinfo($oldentry, PATHINFO_EXTENSION);

        $sql = "SELECT lastName, name FROM users WHERE email='$mail'";

        $result = mysql_query($sql);

        $row = mysql_fetch_assoc($result);

        $nombre = $row['lastName'] . "_" . $row['name'] . "_" . $corte[0] . "." . $ext;

        $newname = strtolower($nombre);
        
        copy("uploads/$oldentry", "ordenESN/$newname");
    }
}

closedir($folder);
?>
