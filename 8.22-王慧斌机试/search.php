<?php
include_once "help.php";
// 查找pinglun表所有的数据
$selStr = "SELECT * FROM pinglun";
$result = mysqli_query($con,$selStr);
//mysqli_fetch_array() 函数从结果集中取得一行作为关联数组，或数字数组，或二者兼有
while ($rows = mysqli_fetch_array($result)) {
//	var_dump($rows);
	echo "<li>
	<div><img src='{$rows['imgsrc']}' alt=''></div><div>".
	"<span class='mz'>{$rows['username']}</span>".
	"<span>：{$rows['text']}</span>".
	"<p class='time'><span>{$rows['date']}</span><a href='javascript:;'>删除</a></p></div>".
	"</li>";
}
