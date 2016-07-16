<?php
//資料庫設定
//資料庫位置
$db_server = "localhost";
//資料庫名稱
$db_table = "mydb";
//資料庫管理者帳號
$db_user = "root";
//資料庫管理者密碼
$db_passwd = "root";

//對資料庫連線
($connect = @mysqli_connect($db_server, $db_user, $db_passwd)) or die("SQL_CONN_FAIL");
#if (!@mysqli_connect($db_server, $db_user, $db_passwd)) or die("SQL_CONN_FAIL");

//CONNECT DATABASE
(mysqli_select_db($connect,$db_table)) or die("SQL_SELC_TABLE_FAIL");

//資料庫連線採UTF8
mysqli_query($connect, "SET NAMES 'utf8'");
mysqli_set_charset($connect,'utf-8');
?>