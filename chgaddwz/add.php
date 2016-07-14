<?php
session_start();

//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['userid'])){
	header("Location:login.php");
	exit();
}
$userid = $_SESSION['userid'];
include('../conn.php');
$mkdm = "new";
$version = "0";
$sql = "SELECT * FROM `rs_site` s WHERE id in(SELECT CASE WHEN s.id is null THEN t.id ELSE s.id END FROM(SELECT * FROM `rs_site` WHERE mkdm = ? AND usrId = ?)t
		LEFT JOIN `rs_site` s ON s.mkdm = ? AND t.usrId = s.usrId AND t.id = s.old) ";
$stmt = $pdo -> prepare($sql);
$stmt -> execute(array($mkdm,$userid,"chg_chg_wz"));

$i=0;//网站信息列表数据序号
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>变更备案网站</title>
<!-- 引入 WeUI -->
<link rel="stylesheet" href="../css/weui.css" />
<link rel="stylesheet" href="../css/testcss.css" />

</head>
<body>
		<div class="dx_title">
			ICP备案网站信息列表<a href='webinfo.php' class='weui_btn dx_btn_mini'>新增网站</a>
		</div>
		<div>
			<table class="dx_table">
				<tr>
					<th width="50">序号</th>
					<th width="200">网站名称</th>
					<th width="60">操作</th>
				</tr>
				<?php foreach ($stmt AS $row): $i++;?>
				<tr align="center">
					<td class="dx_td"><?php echo $i ?></td>
					<td class="dx_td"><?php echo $row["mc"] ?></td>
					<td class="dx_td tag bg-blue"
						onclick="location.href='<?php echo '../webedit2.php?id='.$row['id']?>'">查看</td>
				</tr>
				<?php endforeach;$pdo = null; ?>
			</table>
		</div>
		<div class="weui_btn_area">
			<a class="weui_btn dx_btn_primary" href="addWz.php">上一页</a>
		</div>
	<script src='../js/jquery.min.js'></script>
	<script src="../js/city2.js"></script>
	<script type="text/javascript" src="../js/dxba.js"></script>
	<script type="text/javascript" src="../js/citySelect2.js"></script>

</body>
</html>
