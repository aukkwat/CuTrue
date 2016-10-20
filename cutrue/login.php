<?php 
include('connect.php');
//$password = md5($password);
$sql = "select * from $login_table where $login_userid_field='".mysql_real_escape_string($username)."' and $login_user_pass_field='".mysql_real_escape_string($password)."'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
if ($row[$login_account_id_field]<>'') {
	$_SESSION[account_id] = $row[$login_account_id_field];
	$_SESSION[id] = session_id();
	echo '<meta http-equiv="refresh" content="0;URL=rest.php">';
	exit;
}		

?>