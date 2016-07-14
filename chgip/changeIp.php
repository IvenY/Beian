<?php
session_start();

//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['userid'])){
	header("Location:login.php");
	exit();
}
$userid = $_SESSION['userid'];
include('../conn.php');
$mkdm = "chg_ip";
$czzt = "101";
include('../judgeState.php');
$stmt = $pdo -> prepare('SELECT * FROM `rs_site` WHERE usrId = ?');
$stmt ->execute(array($userid));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>变更IP</title>
<!-- 引入 WeUI -->
<link rel="stylesheet" href="../css/weui.css" />
<link rel="stylesheet" href="../css/testcss.css" />

<script src='../js/jquery.min.js'></script>
<script type="text/javascript" src="../js/dxba.js"></script>
</head>
<body>
	<div class="weui_cells_title">变更IP</div>
	<form action="changeIpOk.php" method="post" >
	<div class="weui_cell">
		<div class="weui_cell_hd">
			<label class="dx_label">选择网站<span style="color: red">*</span>
			</label>
		</div>
		<div>
			<select class="dx_slct" id="webselect" name="webselect"
				onchange="showIp()">
				<option value="0">请选择</option>
				<?php foreach($stmt AS $webrow) :?>
				<option value="<?php echo $webrow["id"]?>">
					<?php echo $webrow["mc"]?>
				</option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<div class="weui_cell">
		<div class="weui_cell_hd">
			<label class="dx_label">旧IP地址</label>
		</div>
		<div class="weui_cell_bd weui_cell_primary">
			<textarea class="weui_textarea" rows="3" disabled="disabled" id="oldip"> </textarea>
		</div>
	</div>
	
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label">新IP地址<span style="color: red">*</span></label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<textarea class="weui_textarea" placeholder="请输入新IP地址" name="newip" rows="3" ></textarea>
			</div>
		</div>
		<div class="weui_btn_area">
			<input type="submit" name="submit" id="tjip" value="保存修改" class="weui_btn dx_btn_primary" />
		</div>
	</form>
	<div class="weui_btn_area">
		<a class="weui_btn dx_btn_primary" href="chgIp.php">返回上一页</a>
	</div>

</body>
</html>
