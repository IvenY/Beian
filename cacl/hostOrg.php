<?php
session_start();

//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['userid'])){
	header("Location:login.php");
	exit();
}
$userid = $_SESSION['userid'];
include('../conn.php');
$stmt = $pdo -> prepare('SELECT * FROM `rs_host_org` WHERE usrId = ?');
$stmt ->execute(array($userid));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>备案主体信息</title>
<!-- 引入 WeUI -->
<link rel="stylesheet" href="../css/weui.css" />
<link rel="stylesheet" href="../css/testcss.css" />
<script type="text/javascript" src="../js/dxba.js"></script>
</head>
<body>
	<div class="weui_cells_title">注销备案需要进行如下步骤</div>
	<div class="dx_cells weui_cells_form">
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label style="color: #073F89">第一步、 <span style="color: black;">填写上传申请表格</span>
				</label>
			</div>
			<div class="dx_tag">
				<a class="tag bg-blue" href="../static/zxsqb.doc">下载模板</a> 
				<a class="tag bg-blue" href="">开始上传</a> 
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label style="color: #073F89">第二步、 <span style="color: black;">申请信息初审(需1-2工作日)</span>
				</label>
			</div>
			<div class="dx_tag">
				<a class="tag bg-yellow" href="reject.php">退回处理</a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label style="color: #073F89">第三步、 <span style="color: black;">提交管局审核(请耐心等待)</span>
				</label>
			</div>
			<div class="dx_tag">
				<a class="tag bg-blue" href="">备案进度</a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label style="color: #073F89">第四步、 <span style="color: black;">备案成功</span>
				</label>
			</div>
			<div class="dx_tag">
				<a class="tag bg-blue" href="">注销信息</a> 
			</div>
		</div>
	</div>
	<div class="weui_btn_area">
		<a class="weui_btn dx_btn_primary" href="../Infomanage.php">返回备案桌面</a>
	</div>
</body>
</html>
