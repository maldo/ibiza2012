<?php

if(!defined('INCLUDE_CHECK')) die('You are not allowed to execute this file directly');

/* Database config */

$db_host	= 'esnupcorg.fatcowmysql.com';
$db_user	= 'ocibizabcn';
$db_pass	= 'FV#r6:8*35Z5;g1';
$db_database    = 'ibiza12'; 

/* End config */

$link = mysql_connect($db_host,$db_user,$db_pass) or die('Unable to establish a DB connection');

mysql_select_db($db_database,$link);
mysql_query("SET names UTF8");

?>