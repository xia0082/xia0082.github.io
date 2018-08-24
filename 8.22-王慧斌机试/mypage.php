<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-type" content="text/html;charset=utf-8">
</head>
<style type="text/css">
    body{
        font-size: 12px;font-family: verdana;
    }
    div.page{
        text-align: center;
    }
    div.content{
        height: 500px;
    }
    div.page a{
        border:#aaaadd 1px solid;text-decoration: none;padding: 2px 5px 2px 5px;margin: 2px;
    }
    div.page span.current{
        border:#000099 1px solid;background-color: #000099;padding: 2px 5px 2px 5px;margin: 2px;color: #fff;font-weight: bold;
    } 
    div.page span.disable{
        border:#eee 1px solid;padding:2px 5px 2px 5px; margin: 2px;color:#ddd;
    }
    div.page form{
        display: inline;
    }
    .content{
    	width: 700px;
    	height: 500px;
    	margin:0 auto;
    }
    .content ul li{
    	list-style: none;
    	width: 700px;
    	height: 90px;
    	border-bottom: 1px dashed black;
    	margin-left:-40px;
    }
    .content ul li .left{
    	width: 70px;
    	height: 70px;
    	float: left;
    }
    .content ul li .left img{
    	width: 70px;
    	height: 70px;
    	margin-top:3px;
    }
    .content ul li .right{
    	float: left;
    	width: 450px;
    	height: 70px;
    	margin-left:20px;
    	margin-top:10px;
    	font-size:14px;
    }
    .content ul li .right span:nth-child(1){
     	color:deepskyblue;
     	font-weight: bold;
     	display: block;
     	margin-top:5px;
     	margin-bottom:10px;
     }
     .content ul li p{
     	float: left;
     	margin-top:60px;
     }
</style>
<body>
<?php
    //设置级别错误，通知类除外
    error_reporting('E_ALL&~E_NOTICE');  
    /**1---传入页码,使用GET获取**/
    $page=$_GET['p'];
    /**2---根据页码取出数据：php->mysql处理**/
    $host="localhost";
    $username="root";
    $password="";
    $db="wb";
    $pageSize=5;
    $showPage=10; 
    //连接数据库,面向过程
    $conn=mysqli_connect($host,$username,$password);
    if(!$conn){
        echo "数据库连接失败";
        exit;
    }
    //选择所要操作的数据库
    mysqli_select_db($conn,$db);
    //设置数据库编码格式
    mysqli_query($conn,"SET NAMES UTF8");
    //编写sql获取分页数据 SELECT * FROM 表名 LIMIT 起始位置，显示条数
    $sql="SELECT * FROM pinglun order by id ASC LIMIT ".($page-1)*$pageSize .",{$pageSize}";
    //把sql语句传送到数据库
    $result=mysqli_query($conn,$sql);
    //将数据显示到table中，并未table设置格式
    echo "<div class='content'>";
    echo "<ul class='lis'>";
    while ($row = mysqli_fetch_assoc($result)) {
         echo "<li>
		<div class='left'><img src='{$row['imgsrc']}' alt=''></div><div class='right'>".
		"<span class='mz'>用户名：{$row['username']}</span>".
		"<span>评论：{$row['text']}</span></div>".
		"<p class='time'>日期：{$row['date']}</p>".
		"</li>";
    }
    echo "</ul>";
    echo "</div>";
	
    //释放结果
    mysqli_free_result($result);
    //获取数据总条数
    $total_sql="SELECT COUNT(*)FROM pinglun";
    $total_result=mysqli_fetch_array(mysqli_query($conn,$total_sql));
    $total=$total_result[0];
    $total_pages=ceil($total/$pageSize);
    //关闭数据库
    mysqli_close($conn);
    /**3---显示数据+显示分页条**/
    $page_banner="<div class='page'>";
    //计算偏移量
    $pageoffset=($showPage-1)/2;
    //两种情况下 首页、上一页 的显示效果
    if($page>1){
        $page_banner .= "<a href='".$_SERVER['PHP_SELF']."?p=1'>首页</a>";
        $page_banner .= "<a href='".$_SERVER['PHP_SELF']."?p=" .($page-1) . "'><上一页</a>";
    }else{
        $page_banner .="<span class='disable'>首页</span>";
        $page_banner .="<span class='disable'><上一页</span>";
    }
    //显示
    $start=1;
    $end=$total_pages;
    //当总条数大于分页数时
    if($total_pages>$showPage){
        if($page>$pageoffset+1){
            $page_banner .="...";
        }
        if($page>$pageoffset){
            $start=$page-$pageoffset;
            $end=$total_pages>$page+$pageoffset?$page+$pageoffset:$total_pages;//三段式
        }
        //最前面几个特殊页号的显示。当前指的是页号1或者2时
        else{
            $start=1;
            $end=$showPage;
        }
        //最后面几个特殊页号的显示，当前显示的是页号7和8
        if($page+$pageoffset>$total_pages){
            $start=$start-($page+$pageoffset-$end);//注意理解这一句
        }
    }
    //显示页码
    for($i=$start;$i<=$end;$i++){
        //当前页页码上显示背景色
        if($page==$i){
            $page_banner .="<span class='current'>{$i}</span>";
        }
        //非当前页码显示
        else{
            $page_banner .= "<a href='".$_SERVER['PHP_SELF']."?p=" .$i . "'>{$i}</a>";    
        }    
    }
    if($total_pages>$showPage&&$total_pages>$page+$pageoffset){
        $page_banner .="...";    
    }
    //两种情况下的尾页、下一页 的显示效果
    if($page<$total_pages){
        $page_banner .= "<a href='".$_SERVER['PHP_SELF']."?p=" .($page+1) . "'>下一页></a>";
        $page_banner .= "<a href='".$_SERVER['PHP_SELF']."?p=$total_pages'>尾页</a>";
    }else{
        $page_banner .="<span class='disable'>尾页</span>";
        $page_banner .="<span class='disable'>下一页></span>";
    }
    $page_banner .= "共{$total_pages}页,";
    $page_banner .= "<form action='mypage.php' method='get'>";
    $page_banner .= " 到第<input type='text' size=2 value='1' name='p'>页";
    $page_banner .= "<input type='submit' value='确定'>";
    $page_banner .= "</form>";
    $page_banner .= "</div>";
    echo $page_banner;
?>
</body>
</html>