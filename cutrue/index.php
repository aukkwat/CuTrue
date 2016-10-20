<?php 
session_start();
header ('Content-type: text/html; charset=utf-8');

if ($_POST[login_button]<>'') {
unset($_POST[login_button]);
	echo "$_POST[login_button]";
	if ($_POST[username]<>'' and $_POST[password]<>'') {
		$username = trim($_POST[username]);
		$password = trim($_POST[password]);			
		include('login.php');
	}
} else if ($_POST[serial]<>'') {
	//include('install.php');
	if (is_numeric($_POST[serial]) and strlen($_POST[serial])==14) {				
		include('client_send.php');	
	} else {
		echo "<script>alert('กรอกรหัสบัตรไม่ถูกต้อง (ตัวเลข 14 หลัก)');</script>";
		echo '<meta http-equiv="refresh" content="0;URL=rest.php">';
	}
}
include('client_setting.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ระบบเติมเงินทรูมันนี่ โดย CuTrue.net</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>

<body>

<p class="cutrue_head">ระบบเติมเงินทรูมันนี่ โดย <a href="https://www.cutrue.net">CuTrue.net</a></p>

<?php 
if ($_SESSION[account_id]=='') {
?>
<p>
<form name="frm" id="frm" action="" method="post">
<table width="300" border="0" cellpadding="1" cellspacing="1" align="center">
<tr>
  <th><div align="right">ID :</div></th>
  <th><input type="text" name="username" id="username" autocomplete="off" size="15" maxlength="30" style="border:orange 1px solid; font-size:16px"></th>
</tr>
<tr>
  <th><div align="right">Password :</div></th>
  <th><input type="password" name="password" id="password" autocomplete="off" size="15" maxlength="30" style="border:orange 1px solid; font-size:16px"></th>
</tr>
</table>
</div>
<input type="submit" value="-Login-" name="login_button" />
</form>
</p>
<?php 
} else if ($_SESSION[account_id]<>'') {
	echo '<meta http-equiv="refresh" content="20;URL=rest.php">';
?>
<input type="button" onclick="javascript:window.location.href='logout.php';" value="Logout">
<p>
<form name="frm" id="frm" action="" method="post">
<input type="text" name="serial" id="serial" maxlength="14" autocomplete="off" style="border:orange 1px solid; font-size:16px">&nbsp;
<input type="submit" value="เติมเงิน"/>
</form>
</p>
<p>
<div align="center">
<table border="0" width="400">
<tr><td align="left" style="font-size:12px">
- เฉพาะบัตรเงินสดทรูมันนี่เท่านั้น<br />
- ใช้เวลาดำเนินการ 1-5 นาที<br />
<span style="color:darkred">** ใส่รหัสบัตรผิดหลายครั้ง ระบบจะทำการล็อคโดยอัตโนมัติ</span>
</td></tr>
</table>
</div>
</p>

<script language="javascript">
function History() {
	var req;
	if (window.XMLHttpRequest) req=new XMLHttpRequest(); else if (window.ActiveXObject) req=new ActiveXObject("Microsoft.XMLHTTP");	else { alert("Browser not support");return false; }
	req.onreadystatechange=function() {	if (req.readyState==4) { document.getElementById('history').innerHTML=req.responseText;	setTimeout("History()",1000);} }
	var str=Math.random();	
	var querystr="history.php?time="+str;
	req.open("POST", querystr , true);
	req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	req.send(null);
}
History();
</script>
<div align="center" id="history" name="history"></div>
<?php 
}
?>

<p class="cutrue_head">ระบบเติมเงินทรูมันนี่ โดย <a href="https://www.cutrue.net">CuTrue.net</a></p>

<table width="300" border="0" cellpadding="1" cellspacing="1" align="center">
<tr>
  <th>ราคาบัตร</th>
  <th>พ้อยที่จะได้รับ</th>
</tr>
<tr>
  <td class="mytable_td">50</td>
  <td class="mytable_td"><?php echo $card_50;?></td>
</tr>
<tr>
  <td class="mytable_td">90</td>
  <td class="mytable_td"><?php echo $card_90;?></td>
</tr>
<tr>
  <td class="mytable_td">150</td>
  <td class="mytable_td"><?php echo $card_150;?></td>
</tr>
<tr>
  <td class="mytable_td">300</td>
  <td class="mytable_td"><?php echo $card_300;?></td>
</tr>
<tr>
  <td class="mytable_td">500</td>
  <td class="mytable_td"><?php echo $card_500;?></td>
</tr>
<tr>
  <td class="mytable_td">1000</td>
  <td class="mytable_td"><?php echo $card_1000;?></td>
</tr>
</table>

</body>
</html>
