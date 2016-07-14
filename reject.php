<?php
session_start();
$array = array(
		"new_tj" => "新增备案-提交审核"	,
		"new_cxtj" => "新增备案-重新提交",
		"new_ysh" => "新增备案-预审核",
		"bring_in_tj" => "新增接入-提交审核",
		"bring_in_ysh" => "新增接入-预审核",
		"pass" => "通过",
		"reject" => "拒绝"
);
//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['userid'])){
	header("Location:login.php");
	exit();
}
$userid = $_SESSION['userid'];
$mkdm = $_GET['mkdm'];
$czjg = "reject";
include('conn.php');
$stmt = $pdo ->prepare('SELECT * FROM `rs_opt_log` WHERE usrId = ? && mkdm = ? && czjg = ?');
$stmt -> execute(array($userid,$mkdm,$czjg));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>退回处理</title>
<!-- 引入 WeUI -->
<link rel="stylesheet" href="css/weui.css" />
<link rel="stylesheet" href="css/testcss.css" />

</head>
<body>
	<?php include('top.php')?>
	<form action="Webinfook.php" method="post">
		<div class="dx_title">退回信息处理</div>
		<div>
			<table class="dx_table">
				<tr bgcolor="#CCCCCC">
					<th width="20%" >操作时间</th>
					<th width="20%">操作人</th>
					<th width="20%">操作类别</th>
					<th width="20%">操作结果</th>
					<th width="20%">操作意见</th>
				</tr>
				<?php foreach ($stmt AS $row):?>
				<tr align="center">
					<td class="dx_td"><?php echo $row["czsj"] ?></td>
					<td class="dx_td"><?php echo $row["czrxm"] ?></td>
					<td class="dx_td"><?php echo $array[$row["czdz"]] ?></td>
					<td class="dx_td"><?php echo $array[$row["czjg"]] ?></td>
					<td class="dx_td"><?php echo $row["czyj"] ?></td>
				</tr>
				<?php endforeach; $pdo = null; ?>
			</table>
		</div>
		<div class="weui_btn_area">
			<input type="button" class="weui_btn dx_btn_primary"
			onclick="javascript:history.back(-1);" value="返回上一页">
		</div>
	</form>
	
	<script src='js/jquery.min.js'></script>
	<script src="js/index.js"></script>
	<script src="js/city2.js"></script>
	<script src="js/dxba.js"></script>
	<script type="text/javascript" src="js/citySelect2.js"></script>

</body>
</html>
