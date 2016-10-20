<?php 
include('connect.php');

if ((($_SERVER['REMOTE_ADDR']=='203.150.230.41') or ($_SERVER['REMOTE_ADDR']=='203.150.230.79')) and ($_POST[cutrue_code]==$cutrue_code)) {
	$sql ="select id from cutrue where account_id='$_POST[account_id]' and serial='$_POST[serial]' and status='กำลังดำเนินการ' order by id ASC limit 0,1";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);

	if ($_POST[amount]>0) { $refill="NO"; } else { $refill="YES"; }
	$new_amount = $card_value[$_POST[amount]];
	$sql = "update cutrue set status='$_POST[status]',amount='$_POST[amount]',refill_amount='$new_amount',refill='$refill' where id='$row[id]'";

	if (mysql_query($sql)) { echo "REFILL OK"; } else { echo "FAILED UPDATE DB"; }
	if (mysql_num_rows($result)>1) {
		$sql = "update cutrue set status='ใช้ไปแล้ว',refill='YES' where id!='$row[id]' and account_id='$_POST[account_id]' and serial='$_POST[serial]' and status='กำลังดำเนินการ'";
		mysql_query($sql);
	}
	
	//--- ส่วนให้โบนัสตามราคาบัตร
	if ($bonus_card[$_POST[amount]]<>"") {
		$item_bonus = explode("&&",$bonus_card[$_POST[amount]]);
		foreach ($item_bonus as $item) {
			list($item_id,$item_name,$item_amount) = explode(",",$item);
			if ($item_id<>'' and $item_amount>0) {
				$s = "insert into cutrue_item_bonus (account_id,item_id,item_name,item_amount,bonus_rate,bonus_date,bonus_refill) values ('$_POST[account_id]','$item_id','$item_name','$item_amount','99999999',NOW(),'NO')";
				mysql_query($s);
			}
		}
	}

	$today = date("Y-m-d");
	if ($today>=$bonus_start and $today<=$bonus_end) {
		//--- ส่วนโปรโมชั่น
		$sql = "select SUM(amount) as sum_amount from cutrue where account_id='$_POST[account_id]' and status='สำเร็จ' and dt>='$bonus_start' and dt<='$bonus_end'";	
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$sum_amount = $row[sum_amount];	
		//--- Check Bonus	
		foreach($bonus as $key => $value) {
			echo "$sum_amount>=$key <br>";
			if (($sum_amount*1)>=($key*1)) {
				
				$sql2 = "select id from cutrue_item_bonus where account_id='$_POST[account_id]' and bonus_date>='$bonus_start' and bonus_date<='$bonus_end' and bonus_rate='$key'";
				$result2 = mysql_query($sql2);
				echo "*****<br>".mysql_num_rows($result2)."<br>******<br>";
				if (mysql_num_rows($result2)==0) {				
					$item_bonus = explode("&&",$value);				
					foreach ($item_bonus as $item) {
						list($item_id,$item_name,$item_amount) = explode(",",$item);
						if ($item_id<>'' and $item_amount>0) {
							$s = "insert into cutrue_item_bonus (account_id,item_id,item_name,item_amount,bonus_rate,bonus_date,bonus_refill) values ('$_POST[account_id]','$item_id','$item_name','$item_amount','$key',NOW(),'NO')";
							echo "item_bonus ---> $s<br>";
							mysql_query($s);
						}
					}
				}
			}
		}
	}
}
//echo $sql;
?>