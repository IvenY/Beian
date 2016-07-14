<?php
session_start();
$userid = $_SESSION['userid'];
//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['userid'])){
	header("Location:login.php");
	exit();
}
include('conn.php');
$stmt = $pdo -> prepare('SELECT * FROM `rs_usr` WHERE id = ? limit 1');
$stmt -> execute(array($userid));
$row = $stmt -> fetch();
$stmt2 = $pdo -> prepare('SELECT * FROM `rs_opt_state` WHERE usrId = ? && czlx = ? limit 1');
$stmt2 -> execute(array($userid,"new"));
if($stmt2 -> rowCount())
	$row2 = $stmt2 -> fetch();
?>
<!doctype html>
<html lang="en">
<head>
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>备案信息管理</title>
<script src="js/jquery.min.js"></script>
<link rel="stylesheet" href="css/weui.css" />
<script type="text/javascript" src="js/dxba.js"></script>
<link href="css/testcss.css" rel='stylesheet' type='text/css' />
</head>
<body>
	<?php include('top.php')?>
	<div class="container">
		
		<div class="bgzt">
			<a class="next-a" onclick ="checkzt(<?php echo $row2['czzt']?>)"> 变更主体 </a>
		</div>

		<div class="bgwz">
			<a class="next-a" href="chgwz/chgWz.php"> 变更网站 </a>
		</div>

		<div class="bgip">
			<a class="next-a" href="chgip/chgIp.php"> 变更IP </a>
		</div>

		<div class="bgdsjr" >
			<a class="next-a" href="javascript:void(0)" id="changeds" onclick="changeds('<?php echo $row['jrs']?>')"> 变更地市接入 </a>
		</div>

		<div class="xzwz">
			<a class="next-a" href="chgaddwz/addWz.php"> 新增网站 </a>
		</div>

		<div class="xzdsjr" >
			<a class="next-a"> 新增地市接入 </a>
		</div>
		<!--图标模块结束-->
		
		<!--footer开始-->
		<?php include('footer.php')?>
		<!--footer结束-->

	</div>
</body>
</html>

