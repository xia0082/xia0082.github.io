<?php
// 用于在数据表里插入
var_dump($_POST);
date_default_timezone_set('PRC');
$username = $_POST['user'];
$text = $_POST['text'];
$imgsrc = $_POST['imgsrc'];
$date = date('m月d日 h:i',time());
include_once 'help.php';
echo "连接成功";
$sqlStr1 = <<<sql1
INSERT INTO pinglun (username,text,imgsrc,date) values ("$username","$text","$imgsrc","$date");
sql1;
$res1 = mysqli_query($con,$sqlStr1);
mysqli_close($con);
?>