<?php
session_start();
//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['userid'])){
	header("Location:login.php");
	exit();
}
include('../conn.php');
$userid = $_SESSION['userid'];
$jrfsstmt = $pdo -> prepare('SELECT * FROM `sys_dict` WHERE type= ?');
$fzdstmt = $pdo -> prepare('SELECT * FROM `sys_dict` WHERE type= ?');
$jrfsstmt -> execute(array("site_jrfs"));
$fzdstmt -> execute(array("site_yzjfzd"));

$stmt = $pdo -> prepare('SELECT * FROM `rs_bring_in` WHERE usrId = ?');
$stmt -> execute(array($userid));
$row = $stmt -> fetch();

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>新增接入</title>

<!-- 引入 WeUI -->
<link rel="stylesheet" href="../css/weui.css" />
<link rel="stylesheet" href="../css/testcss.css" />
</head>
<body>
	<form action="" method="post">
		<div class="weui_cells_title">新增接入</div>
		<div class="dx_title">新增接入</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label_second">网站备案号<span style="color: red">*</span>
				</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"> <?php echo $row["bah"]?>
				</a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label_second">ICP密码 <span style="color: red">*</span>
				</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"> <?php echo $row["icpmm"]?>
				</a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label">接入方式 <span style="color: red">*</span>
				</label>
			</div>
			<div class="dx_cells weui_cells_checkbox">
				<?php foreach ($jrfsstmt AS $jrfsrow):?>
				<label class="dx_cell weui_check_label"
					for="<?php echo "j".$jrfsrow["seq"]?>"> <input type="checkbox"
					name="jrfs[]" onclick="return false"
					value="<?php echo $jrfsrow["value"]?>"
					id="<?php echo "j".$jrfsrow["seq"]?>"
						<?php
						$jrfsstr= $row["jrfs"];$str=explode(",",$jrfsstr);
						for ($i=0;$i<count($str);$i++){
								if($jrfsrow["value"]==$str[$i])
									echo "checked='true'";
							}
							?>> <?php echo $jrfsrow["name"]?>
				</label>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label_second">服务器放置地 <span style="color: red">*</span>
				</label>

			</div>
			<div class="weui_cell_bd weui_cell_primary">
					<a class="weui_input"><?php echo $row["fwqfzd"]?> </a>
				</div>
		</div>
		<input type="hidden" id="dz" name="dz" />
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label_second">网站IP地址 <span style="color: red">*</span>
				</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<textarea class="weui_textarea" name="wzipdz" placeholder="请输入IP地址"
					rows="3" required="required" disabled="disabled"><?php echo $row["wzipdz"]?></textarea>
			</div>
		</div>
		<div class="weui_btn_area">
			<input type="button" class="weui_btn dx_btn_primary"
			onclick="javascript:history.back(-1);" value="返回">
		</div>
	</form>

	<script src='../js/jquery.min.js'></script>
	<script src="../js/index.js"></script>
	<script type="text/javascript" src="../js/dxba.js"></script>
</body>
</html>
