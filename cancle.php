<?php
session_start();

//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['userid'])){
	header("Location:login.php");
	exit();
}
?>
<!doctype html>
<html lang="en">
<head>
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>注销备案</title>
<link rel="stylesheet" href="css/weui.css" />
<script src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/dxba.js"></script>
<link href="css/testcss.css" rel='stylesheet' type='text/css' />
</head>
<body>
	<?php include('top.php')?>
	<div class="container">
		<!--图标模块开始-->
		<div class="bringIn">
			<a class="next-a" href="cacl/hostOrg.php"> 注销主体 </a>
		</div>

		<div class="cancle" id="first-pic3-div">
			<a class="next-a" href="cacl/webSite.php"> 注销网站 </a>
		</div>


		<!--图标模块结束-->



		<!--footer开始-->
		<div class="first-footer">
			<p>公司地址：xxxxxxxxxxxxxxx</p>
		</div>
		<!--footer结束-->

	</div>

	<!--遮罩开始-->
	<div class="bg"></div>
	<!--遮罩结束-->


</body>
</html>

