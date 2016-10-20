<?php 
include('client_setting.php');
$connect = mysql_connect( $dbhost,$dbusername,$dbpassword);
if ( !$connect ) { echo "ติดต่อกับฐานข้อมูล Mysql ไม่ได้ "; exit(); }
$condb = mysql_select_db($db);
mysql_query("set NAMES utf8");
mysql_query("SET character_set_results=utf8");

include_once('install.php');

$card_value = array();
//--- Set Value Truemoney
$card_value[50] = $card_50;
$card_value[90] = $card_90;
$card_value[150] = $card_150;
$card_value[300] = $card_300;
$card_value[500] = $card_500;
$card_value[1000] = $card_1000;

?> 