<?php
session_start();

//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['userid'])){
	header("Location:login.php");
	exit();
}
$userid = $_SESSION['userid'];
$mkdm = $_GET['mkdm'];
include('conn.php');
$stmt = $pdo -> prepare('SELECT * FROM `rs_cert` WHERE usrId =? && deleted = ?');
$stmt -> execute(array($userid,"0"));
$stmt3 = $pdo -> prepare('SELECT * FROM `rs_usr_ver_bill` WHERE usrId = ? && mkdm = ?');
if($_SERVER['REQUEST_METHOD']=='POST'){
	$certid = $_POST['zjid'];
	$mkdm = $_GET['mkdm'];
	$gxsj = date('y-m-d H:i:s',time());
	$stmt2 = $pdo -> prepare('SELECT * FROM `rs_cert` WHERE id = ?');
	$stmt2 -> execute(array($certid));
	$row2 = $stmt2 -> fetch();
	
	$ifstmt2 = $pdo -> prepare('SELECT * FROM `rs_usr_cert` WHERE certId = ? AND mkdm = ? limit 1 ');
	$ifstmt2 -> execute(array($certid,$mkdm));
	$ifresult = $ifstmt2 -> rowCount();
	if($ifresult)
		return true;
	else {
		$stmt4 = $pdo -> prepare('INSERT INTO `rs_usr_cert` (usrId,certId,mkdm,gxsj,sm) VALUES (?,?,?,?,?)');
		$stmt4 -> execute(array($userid,$certid,$mkdm,$gxsj,$row2['zjsm']));
	}
}

$stmt3 -> execute(array($userid,$mkdm));
$row3 = $stmt3 -> fetch();

$ifstmt = $pdo -> prepare('SELECT * FROM `rs_cert` WHERE usrId = ?');
$ifstmt -> execute(array($userid)); 
$ifrow = $ifstmt -> rowCount();
$zjlxstmt = $pdo->prepare('SELECT * FROM `sys_dict` WHERE type= ?');
$zjlxstmt -> execute(array("cert_zjlx"));
$arr = array();
foreach ($zjlxstmt AS $zjlxrow){
	$arr[$zjlxrow['value']] = $zjlxrow['name'];
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
	<div class="weui_input" style=" color: #FF6600">没有符合需要的证件类型，请先 <a style="color: red ;" onclick="tozjgl()">点此上传</a>证件，再返回选择！</div>
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
					onclick="upzj('<?php echo $row['id']?>','<?php echo $mkdm?>')">选择</a><a class="dx_a"
					onclick="lookdiv('<?php echo $row['id']?>')">查看</a></td>
				<td class="dx_td"><?php echo $arr[$row['zjlx']] ?>
				</td>
				<td class="dx_td"><?php echo $row["zjsm"] ?></td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
	<div id="lookdiv" class="dxui_dialog_alert" style="display: none">
		<div class="dxui_dialog">
			<div class="dxui_dialog_bd" onclick="closediv()">
				<img id="look"  height="250" src="" onclick="closediv()">
			</div>
		</div>
	</div>
	<script src='js/jquery.min.js'></script>
	<script src="js/index.js"></script>
	<script src="js/dxba.js"></script>
	<script src="layer/layer.js"></script>
</body>
</html>
