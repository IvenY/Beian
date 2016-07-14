<?php
session_start();

//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['userid'])){
	header("Location:login.php");
	exit();
}
$userid = $_SESSION['userid'];
include('conn.php');
$mkdm = $_GET['mkdm'];
$stmt = $pdo -> prepare('SELECT * FROM `rs_cert` WHERE usrId =? && deleted = ?');
$stmt -> execute(array($userid,"0"));
$zjlxstmt = $pdo->prepare('SELECT * FROM `sys_dict` WHERE type= ?');
$zjlxstmt -> execute(array("cert_zjlx"));
$arr = array();
foreach ($zjlxstmt AS $zjlxrow){
	$arr[$zjlxrow['value']] = $zjlxrow['name'];
}
if($_SERVER['REQUEST_METHOD']=='POST'){
	$id = $_POST['id'];
	$delstmt = $pdo -> prepare('UPDATE `rs_cert` SET deleted = ? WHERE id = ?');
	$delstmt -> execute(array("1",$id));
	$result = $delstmt -> rowCount();
	echo $result;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>上传证件及核验单</title>
<!-- 引入 WeUI -->
<link rel="stylesheet" href="css/weui.css" />
<link rel="stylesheet" href="css/testcss.css" />

</head>
<body>
	<?php include('top.php')?>
	<div class="weui_cells_title">证件管理</div>
	<div class="dx_title">
		已上传证件 <a href="zjgl.php" class="weui_btn dx_btn_mini">上传证件</a>
	</div>
	<div>
		<table class="dx_table">
			<tr>
				<th width="25%">操作</th>
				<th width="50%">证件类型</th>
				<th width="25%">证件说明</th>
			</tr>
			<?php foreach ($stmt AS $row):?>
			<tr align="center">
				<td class="dx_td"><a style="color: #073F89"
					onclick="lookimg2('<?php echo $row['id']?>','<?php 
						echo $arr[$row['zjlx']];
					?>')">查看</a><a class="dx_a"
					onclick="delimg('<?php echo $row['id']?>')">删除</a></td>
				<td class="dx_td"><?php echo $arr[$row['zjlx']] ?>
				</td>
				<td class="dx_td"><?php echo $row["zjsm"] ?></td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>

	<div class="weui_btn_area">
		<?php if ($mkdm == "new")
			echo "<a class='weui_btn dx_btn_primary' href='new.php' id='button'>返回新增备案</a>";
		elseif ($mkdm == "bring_in")
			echo "<a class='weui_btn dx_btn_primary' href='bringIn.php' id='button'>返回新增接入</a>";
		elseif ($mkdm == "chg_zt")
			echo "<a class='weui_btn dx_btn_primary' href='chg/chgZt.php' id='button'>返回变更主体</a>";
		elseif ($mkdm == "chg_chg_wz")
			echo "<a class='weui_btn dx_btn_primary' href='chgwz/chgWz.php' id='button'>返回变更网站</a>";
		elseif ($mkdm == "assist")
			echo "<a class='weui_btn dx_btn_primary' href='assist.php' id='button'>返回个人帮助</a>";
		?>
	</div>
	<div id="lookdiv" class="dxui_dialog_alert" style="display: none">
		<div class="dxui_dialog">
			<div class="weui_dialog_hd">
				<strong class="weui_dialog_title" id="dialog_hd">查看核验单</strong>
			</div>
			<div class="dxui_dialog_bd">
				<img id="look" width="390" height="250" src="">
			</div>
			<div class="dxui_dialog_ft">
				<a onclick="closediv('lookdiv')" class="dxui_btn_dialog primary"
					id="dialog_ft">确定</a>
			</div>
		</div>
	</div>
	<script src='js/jquery.js'></script>
	<script src="js/index.js"></script>
	<script src="js/dxba.js"></script>
	<script src="layer/layer.js"></script>

</body>
</html>
