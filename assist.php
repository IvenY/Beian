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
<title>备案信息管理</title>
<link rel="stylesheet" href="css/weui.css" />
<script src="js/jquery.min.js"></script>
<script src="js/dxba.js"></script>
<link href="css/testcss.css" rel='stylesheet' type='text/css' />
</head>
<body>
	<?php include('top.php')?>
	<div class="container">
		<!--图标模块开始-->
		<div class="grxx">
			<a class="next-a" href="usrInfo.php"> 个人信息</a>
		</div>

		<div class="zjgl">
			<a class="next-a" href="cert1.php?mkdm=assist"> 证件管理 </a>
		</div>


		<div class="assist">
			<a class="next-a" href="static/help.pdf"> 操作指南 </a>
		</div>

		<div class="change" id="first-pic3-div">
			<a class="next-a" href="changePwd.php"> 修改密码</a>
		</div>
		
		<!--图标模块结束-->



		<!--footer开始-->
		<?php include('footer.php')?>
		<!--footer结束-->

	</div>

	<!--遮罩开始-->
	<div class="bg"></div>
	<!--遮罩结束-->

</body>
</html>

