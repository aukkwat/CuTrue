<?php 
@header ('Content-type: text/html; charset=utf-8');
include('connect.php');

$sql = "CREATE TABLE IF NOT EXISTS `cutrue` (
`id` BIGINT( 20 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`account_id` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`ip` varchar(15) collate utf8_unicode_ci NOT NULL,
`serial` VARCHAR( 14 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`amount` INT( 4 ) NOT NULL DEFAULT '0',
`dt` DATETIME NOT NULL ,
`status` ENUM( 'เข้าสู่ระบบ', 'กำลังดำเนินการ', 'สำเร็จ', 'ไม่สำเร็จ', 'ใช้ไปแล้ว' ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`refill_amount` INT( 7 ) NOT NULL DEFAULT '0',
`refill` ENUM( 'YES', 'NO' ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'NO'
) ENGINE = MYISAM ;";
$result = mysql_query($sql);

$sql = "CREATE TABLE IF NOT EXISTS  `cutrue_item_bonus` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`account_id` VARCHAR( 20 ) NOT NULL ,
`item_id` VARCHAR( 20 ) NOT NULL ,
`item_name` varchar(255) collate utf8_unicode_ci NOT NULL,
`item_amount` INT( 11 ) NOT NULL ,
`bonus_rate` VARCHAR( 10 ) NOT NULL,
`bonus_date` DATE NOT NULL,
`bonus_refill` ENUM( 'YES', 'NO' ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'NO'
) ENGINE = MYISAM ;";
$result = mysql_query($sql);

?>