<?php
include_once "help.php";
//var_dump($_POST);  
$username = $_POST['username'];
//echo($username);
//从数据表pinglun中找到username进行删除
$delStr = "DELETE FROM pinglun WHERE username ='{$username}'";
var_dump($delStr);
$result = mysqli_query($con,$delStr);
mysqli_close($con);