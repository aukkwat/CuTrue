<?php 
$player = trim($_COOKIE[player]);
setcookie("player",$_SESSION[account_id],time()+3600*24*356);
if ($_SESSION[account_id]=='' or $_SESSION[id]<>session_id()) {
	exit;
}
include('connect.php');
$account_id = trim(mysql_real_escape_string($_SESSION[account_id]));
$serial = trim(mysql_real_escape_string($_POST[serial]));

function TopUp($CUTRUE_CODE,$ACCOUNT_ID,$SERIAL,$PLAYER,$IP) {				

		$fields = array(
			'cutrue_code' => $CUTRUE_CODE,
			'account_id' => $ACCOUNT_ID,
			'serial' => $SERIAL,
			'player' => $PLAYER,
			'ip' => $IP
			);
						
			$ch = curl_init();   // create a new curl resource
			//curl_setopt($ch,CURLOPT_URL, $CONFIG['ServerURL']);   // set URL and other appropriate options
			
			$url = "https://www.cutrue.net/server/server.php";
			
			$isRequestHeader = false;
			$exHeaderInfoArr   = array();
			$exHeaderInfoArr[] = "Content-type: text/xml";
			$exHeaderInfoArr[] = "Authorization: "."Basic ".base64_encode("authen_user:authen_pwd");
			
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
			curl_setopt($ch, CURLOPT_HEADER, (($isRequestHeader) ? 1 : 0));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			if( is_array($exHeaderInfo) && !empty($exHeaderInfo) )
			{
				curl_setopt($ch, CURLOPT_HTTPHEADER, $exHeaderInfo);
			}
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);

			$Rec_Data = curl_exec($ch);   // grab URL and pass it to the browser			
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);		
			curl_close($ch);   // close curl resource, and free up system resources
			if($httpcode==200) 
			{
				return $Rec_Data;
			}
			else
			{
				return "FAILED:". $httpcode. $Rec_Data;
			}	
}


$now = date("Y-m-d H:i:s");
$sql = "select * from cutrue where (account_id='$account_id' or ip='$_SERVER[REMOTE_ADDR]') and serial='$serial' and status='กำลังดำเนินการ'";
$result = mysql_query($sql);
if (mysql_num_rows($result)>2) {
	echo "<script>alert('กรุณารอการทำรายการข้อมูลเก่าก่อน ใจเย็นๆนะคะ');</script>";
	echo '<meta http-equiv="refresh" content="0;URL=rest.php">';
	exit;	
}

$sql = "select * from cutrue where (account_id='$account_id' or ip='$_SERVER[REMOTE_ADDR]') order by id DESC limit 0,3";
$result = mysql_query($sql);
$check1 = 0;
$check2 = 0;
while ($row=mysql_fetch_array($result)) {
	if ($row[status]=='เข้าสู่ระบบ' or $row[status]=='กำลังดำเนินการ') {
		$check1 = $check1+1;
	}
	if ($row[status]=='ไม่สำเร็จ' or $row[status]=='ใช้ไปแล้ว') {
		$check2 = $check2+1;
		$lastbad = $row[dt];
	}
}


if ($check1>3) {	
	echo "<script>alert('กรุณารอการทำรายการข้อมูลเก่าก่อน ใจเย็นๆนะคะ');</script>";
	echo '<meta http-equiv="refresh" content="0;URL=rest.php">';
	exit;
}
if ($check2>=3) {
	$now_check = date("YmdHis");
	$dt = explode(' ',$lastbad);
	$d = explode('-',$dt[0]);
	$t = explode(':',$dt[1]);
	$lastbad = $d[0].$d[1].$d[2].$t[0].$t[1].$t[2];
	$x = $now_check-$lastbad;	
	if ($x<10000) {
		echo "<script>alert('กรอกรหัสบัตรผิดหลายครั้ง ระบบทำการล็อคชั่วคราว กรุณาลองใหม่ภายหลัง');</script>";
		echo '<meta http-equiv="refresh" content="0;URL=rest.php">';
		exit;
	}
}



	//Call Topup Process		
	$ret = TopUp($cutrue_code,$account_id,$serial,$player,$_SERVER[REMOTE_ADDR]);
	$pos = strpos($ret,'CUTOK');	
	if($pos<>'') {		
		$sql = "insert into cutrue (account_id,ip,serial,amount,dt,status) values ('$account_id','$_SERVER[REMOTE_ADDR]','$serial','0','$now','กำลังดำเนินการ')";
		mysql_query($sql);
		if (strpos($ret,'CUTOK2')<>'') {
			echo "<script>alert('ระบบของ True Money ขัดข้องอยู่ครับ อาจใช้เวลานานกว่าปกติในการทำรายการ');</script>";
		}
	} else {		
		echo "<script>alert('$ret');</script>";
	}

echo '<meta http-equiv="refresh" content="0;URL=rest.php">';
exit;			
?>

						