<?php
session_start();
if(!isset($_SESSION['userid'])){
	header("Location:login.php");
	exit();
}
$userid = $_SESSION['userid'];
include('conn.php');
$stmt = $pdo -> prepare('SELECT * FROM `rs_usr` WHERE id = ? limit 1');
$stmt -> execute(array($userid));
$row = $stmt -> fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type">
<meta charset="UTF-8">
<title>个人信息</title>

<!-- 引入 WeUI -->
<link rel="stylesheet" href="css/weui.css" />
<link rel="stylesheet" href="css/testcss.css" />

</head>
<body>
	<?php include('top.php')?>
	<div class="dx_title">个人信息</div>
	<div class="weui_cells weui_cells_form">
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label">用户名 </label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"> <?php echo $row['dlm']?>
				</a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label_first">首次报备接入点 </label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"><?php echo $row['jrd']?> </a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label">接入商 </label>
			</div>

			<div class="weui_cell_hd">
				<a class="dx_label"><?php echo $row['jrs']?> </a>
			</div>

		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label">姓名 </label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"><?php echo $row['zsxm']?> </a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label">手机 </label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"><?php echo $row['sj']?> </a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label">电子邮箱 </label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"><?php echo $row['dzyx']?> </a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label">签约时间 </label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"></a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label">接入时间 </label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"><?php echo $row['cjsj']?> </a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label_first">合同有效期 </label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"></a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label">备注</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<textarea class="weui_textarea" name="bz" rows="3">
					<?php echo $row['bz']?>
				</textarea>
			</div>
		</div>

	</div>
	<div class="weui_btn_area">
		<input type="button" class="weui_btn dx_btn_primary"
			onclick="javascript:history.back(-1);" value="上一步">
	</div>
	<script src='js/jquery.min.js'></script>
	<script src="js/index.js"></script>
	<script src="js/dxba.js"></script>
</body>
</html>
