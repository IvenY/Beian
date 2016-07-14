<?php
session_start();

//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['userid'])){
	header("Location:login.php");
	exit();
}
$userid = $_SESSION['userid'];
include('../conn.php');
$mkdm = "chg_chg_wz";
$czzt = "101";
include('../judgeState.php');
$sql = "SELECT * FROM `rs_site` s WHERE id in(SELECT CASE WHEN s.id is null THEN t.id ELSE s.id END FROM(SELECT * FROM `rs_site` WHERE mkdm = ? AND usrId = ?)t
		LEFT JOIN `rs_site` s ON s.mkdm = ? AND t.usrId = s.usrId AND t.id = s.old) ";
$stmt2 = $pdo -> prepare($sql);
$stmt2 -> execute(array("new",$userid,"chg_chg_wz"));
$version = 0;

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
			ICP备案网站信息列表
		</div>
		<div>
			<table class="dx_table">
				<tr>
					<th width="50">序号</th>
					<th width="200">网站名称</th>
					<th width="60">操作</th>
				</tr>
				<?php foreach ($stmt2 AS $row): $i++;?>
				<tr align="center">
					<td class="dx_td"><?php echo $i ?></td>
					<td class="dx_td"><?php echo $row["mc"] ?></td>
					<td class="dx_td tag bg-blue"
						onclick="location.href='<?php echo 'webedit.php?id='.$row['id']?>'">编辑</td>
				</tr>
				<?php endforeach;$pdo = null; ?>
			</table>
		</div>
		<div class="weui_btn_area">
			<a class="weui_btn dx_btn_primary" href="chgWz.php">上一页</a>
		</div>
	<script src='../js/jquery.min.js'></script>
	<script type="text/javascript" src="../js/dxba.js"></script>
	<script src="../js/city2.js"></script>
	<script type="text/javascript" src="../js/citySelect2.js"></script>

</body>
</html>
