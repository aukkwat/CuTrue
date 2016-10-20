<?php 
session_start();
include('connect.php');
?>
<table id="mytable" cellspacing="0" align="center">
  <tr align="center">
    <th width="171" scope="col">วัน เวลา</th>
    <th width="165" scope="col">หมายเลขบัตร</th>
    <th width="106" scope="col">ราคาบัตร</th>
    <th width="148" scope="col">สถานะ</th>
  </tr>
<?php 
$sql = "select * from cutrue where account_id='$_SESSION[account_id]'";
$result = mysql_query($sql);
$a = 1;
while ($row=mysql_fetch_array($result)) {
	if (($a%2)==0) { $cl = ' class="alt"'; } else { $cl = ''; }
	$a++;
	if ($row[status]=='เข้าสู่ระบบ') {
		$status="<span style='color:white'>$row[status]</span>";
	} else if ($row[status]=='กำลังดำเนินการ') {
		$status="<span style='color:blue'>$row[status]</span>";
	} else if ($row[status]=='สำเร็จ') {
		$status="<span style='color:green'>$row[status]</span>";
	} else if ($row[status]=='ไม่สำเร็จ') {
		$status="<span style='color:red'>$row[status]</span>";
	} else if ($row[status]=='ใช้ไปแล้ว') {
		$status="<span style='color:orange'>$row[status]</span>";
	}
?>
  <tr>
    <td<?php echo $cl?>><?php echo $row[dt]?></td>
    <td<?php echo $cl?>><?php echo $row[serial]?></td>
    <td<?php echo $cl?>><?php echo $row[amount]?></td>
    <td<?php echo $cl?>><?php echo $status?></td>
  </tr>
<?php 
}//while
?>  
</table>