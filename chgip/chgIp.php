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
$stmt = $pdo->prepare('SELECT * FROM `rs_opt_state` WHERE usrId = ? && czlx = ?');
$stmt -> execute(array($userid,$mkdm));
$row = $stmt -> fetch();
$bgsj = date('y-m-d H:i:s',time());
if(!$row){
	$stmtIn = $pdo->prepare('INSERT INTO `rs_opt_state` (usrId,czlx,czzt,bgsj) VALUES (?,?,?,?)');
	$stmtIn -> execute(array($userid,$mkdm,"100",$bgsj));
}
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
				<label <?php if ($row['czzt']<=100){
					echo "style='color:red'";}else{
				 	echo "style='color:#073F89'";}?>>第一步、 <span style="color: black;">修改IP信息</span>
				</label>
			</div>
			<div class="dx_tag">
				<a class="tag bg-blue" href="changeIp.php">修改信息</a> 
				<a class="tag bg-green" href="">提交审核</a> 
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label <?php if ($row['czzt']==103){
					echo "style='color:red'";}else{
				 	echo "style='color:#073F89'";}?>>第二步、 <span style="color: black;">申请信息初审(需1-2工作日)</span>
				</label>
			</div>
			<div class="dx_tag" <?php if ($row['czzt']<103) echo "style='display: none'";?>>
				<a class="tag bg-yellow" href="../reject.php?mkdm=<?php echo $mkdm?>">退回处理</a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label <?php if ($row['czzt']==110){
					echo "style='color:red'";}else{
				 	echo "style='color:#073F89'";}?>>第三步、 <span style="color: black;">提交管局审核(请耐心等待)</span>
				</label>
			</div>
			<div class="dx_tag">
				<a class="tag bg-blue" href="../progress.php" <?php if ($row['czzt']<110) echo "style='display: none'";?>>备案进度</a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label <?php if ($row['czzt']==200){
					echo "style='color:red'";}else{
				 	echo "style='color:#073F89'";}?>>第四步、 <span style="color: black;">备案成功</span>
				</label>
			</div>
			<div class="dx_tag">
				<a class="tag bg-blue" href="" <?php if ($row['czzt']<200) echo "style='display: none'";?>>注销信息</a> 
			</div>
		</div>
	</div>
	<div class="weui_btn_area">
		<a class="weui_btn dx_btn_primary" href="../change.php">返回变更桌面</a>
	</div>
</body>
</html>
