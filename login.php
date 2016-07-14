<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>登陆</title>
<!-- 引入 WeUI -->
<link rel="stylesheet" href="css/weui.css" />
<link rel="stylesheet" href="css/testcss.css" />
<script type="text/javascript" src="js/dxba.js"></script>
</head>
<body>
	<form name="LoginForm" method="post" action=""
		onSubmit="return InputCheck(this)">
		<div class="weui_cells_title">登陆</div>
		<div class="weui_cells weui_cells_form">
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_login_label">用户名</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" name="username" type="text"
						placeholder="请在此输入登陆账号" />
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_login_label">密 码</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" name="password" type="password"
						placeholder="请在此输入密码" />
				</div>
			</div>
		</div>

		<div class="weui_btn_area">
			<input class="weui_btn dx_btn_primary" name="submit" value="确定"
				type="submit" />
		</div>
		<div id="links_left">
			<a class="weui_cells_tips" href="login.php"> 忘记密码？ </a>
		</div>
		<div id="links_right">
			<a class="weui_cells_tips" href="reg.php" float="right">注册</a>
		</div>
	</form>
</body>
</html>
<?php
header("Content-Type:text/html;charset=utf8");
session_start();
// //注销登录
// if($_GET['action'] == "logout"){
// 	unset($_SESSION['userid']);
// 	unset($_SESSION['username']);
// 	echo '注销登录成功！点击此处 <a href="login.html">登录</a>';
// 	exit;
// }
//登录
if(isset($_POST['submit'])){
$zhdlsj = date('y-m-d H:i:s',time());
$username = htmlspecialchars($_POST['username']);
$pwd = sha1($_POST['password']);
//包含数据库连接文件
include('conn.php');
//检测用户名及密码是否正确
$stmt1 = $pdo->prepare('SELECT id FROM `rs_usr` WHERE dlm = :username && mm = :pwd');
$stmt1->execute(array('username' => $username,'pwd' => $pwd));
$result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
$stmt2 = $pdo->prepare('SELECT id FROM `rs_usr` WHERE dlm = :username');
$stmt2->execute(array('username' => $username));
$result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
if(count($result1)){
	$usrid = $result1[0]['id'];
	$stmt2 = $pdo->prepare('UPDATE `rs_usr` SET zhdlsj = :zhdlsj WHERE id = :id');
	$stmt2->execute(array('zhdlsj' => $zhdlsj,'id' => $usrid));
	$_SESSION['username'] = $username;
	$_SESSION['userid'] = $usrid;
	echo "<script>window.location= 'Infomanage.php';</script>";
} elseif (!count($result2))
	echo "<script>alert('帐户名不存在！');history.go(-1)</script>";
  else {
	echo "<script>alert('帐户名或密码错误！');history.go(-1)</script>";//用户名和密码不一致，跳转到当前页面重新输入
}
}
?>
