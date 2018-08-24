<?php
// html页面编码格式
header("content-Type:text/html;charset=utf-8");
define("HOST","127.0.0.1");
define("USERNAME",'root');
define('PWD','');
define('DBNAME','wb');
define('CHARSET','utf8');
$con = mysqli_connect(HOST,USERNAME,PWD,DBNAME) or die("数据库连接失败,<spans style='color:red;'>".mysqli_error()."</span>");
// 这是设置数据库编码格式
mysqli_set_charset($con,CHARSET);