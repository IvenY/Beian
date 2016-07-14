<?php
session_start();
if(!isset($_SESSION['userid'])){
	header("Location:login.php");
	exit();
}
$userid = $_SESSION['userid'];
include('conn.php');
if (isset($_POST['submit'])) {
	$gxsj = date('y-m-d H:i:s',time());
	$nPwd = sha1($_POST['nPwd']);
	$stmt = $pdo -> prepare('UPDATE `rs_usr` SET gxsj = ?,mm = ? WHERE id = ?');
	$stmt -> execute(array($gxsj,$nPwd,$userid));
	$result = $stmt -> rowCount();
	if($result){
		echo "<script>alert('修改密码成功！')</script>";
		echo "<script>window.location.href = 'assist.php'</script>";
	}else {
		echo "<script>alert('修改密码失败,请稍后再试！')</script>";
	}
		
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type">
<meta charset="UTF-8">
<title>修改密码</title>

<!-- 引入 WeUI -->
<link rel="stylesheet" href="css/weui.css" />
<link rel="stylesheet" href="css/testcss.css" />

</head>
<body>
	<?php include('top.php')?>
	<form action="" method="post" name="changeForm" onSubmit="return changePwdCheck(this)">
		<div class="dx_title">修改密码</div>
		<div class="weui_cells weui_cells_form">
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label">旧密码</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" name="oPwd" type="password" />
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label">新密码 </label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" type="password" required="required"
						name="nPwd" placeholder="密码至少8位" />
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label">重复密码 </label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" type="password" required="required"
						name="rPwd"  />
				</div>
			</div>
			<div class="weui_cell weui_vcode">
				<div class="weui_cell_hd">
					<label class="dx_label">验证码</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input"  required="required" name="checkpic" placeholder="请输入验证码" />
				</div>
				<div class="weui_cell_ft">
					<img id="checkpic" onclick="changing();" src='checkcode.php' />
				</div>
			</div>

		</div>
		<div class="weui_btn_area">
			<input class="weui_btn dx_btn_primary" type="submit" name="submit" value="提交" />
		</div>
	</form>
	<script src='js/jquery.min.js'></script>
	<script src="js/index.js"></script>
	<script src="js/dxba.js"></script>
</body>
</html>
