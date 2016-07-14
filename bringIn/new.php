<?php
session_start();
//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['userid'])){
	header("Location:login.php");
	exit();
}
include('../conn.php');
$mkdm = "bring_in";
$userid = $_SESSION['userid'];
$czzt = "101";
include('../judgeState.php');
$jrfsstmt = $pdo -> prepare('SELECT * FROM `sys_dict` WHERE type= ?');
$fzdstmt = $pdo -> prepare('SELECT * FROM `sys_dict` WHERE type= ?');
$jrfsstmt -> execute(array("site_jrfs"));
$fzdstmt -> execute(array("site_yzjfzd"));

if(isset($_POST['submit'])){
	$jrfsstr = '';
	$bah = $_POST['bah'];
	$icpmm = $_POST['icpmm'];
	$wzipdz = $_POST['wzipdz'];
	$jrfs = $_POST['jrfs'];
	$fwqfzd = $_POST['dz'];
	$gxsj = date('y-m-d H:i:s',time());
	for($i=0;$i<count($jrfs);$i++){
		if($i == 0){
			$jrfsstr=$jrfs[0];
		}else{
			$jrfsstr.=",".$jrfs[$i];
		}
	}
	$stmt = $pdo -> prepare('INSERT INTO `rs_bring_in` (usrId,bah,icpmm,jrfs,fwqfzd,wzipdz,gxsj) VALUES (?,?,?,?,?,?,?)');
	$stmt2 = $pdo -> prepare('UPDATE `rs_opt_state` SET czzt=?,bgsj=? WHERE usrId = ? && czlx = ?');
	$ifstmt = $pdo -> prepare('SELECT * FROM `rs_bring_in` WHERE usrId = ?');
	$ifstmt -> execute(array($userid));
	$ifrow = $ifstmt->rowCount();
	if(!$ifrow){
		$stmt -> execute(array($userid,$bah,$icpmm,$jrfsstr,$fwqfzd,$wzipdz,$gxsj));
		$stmt2 -> execute(array("101",$gxsj,$userid,"bring_in"));
		$result = $stmt->rowCount();
		$result2 = $stmt2 -> rowCount();
		if($result&&$result2){
			echo "<script>alert('操作成功，返回“新增接入“页面！');window.location.href='../bringIn.php'</script>";
		}else{
			echo "<script>alert('保存失败！')</script>";
		}
	}else{
		$upstmt = $pdo -> prepare('UPDATE `rs_bring_in` SET bah = ?,icpmm = ?,jrfs=?,fwqfzd = ?,wzipdz = ?, gxsj = ? WHERE usrId = ?');
		$upstmt -> execute(array($bah,$icpmm,$jrfsstr,$fwqfzd,$wzipdz,$gxsj,$userid));
		$stmt2 ->  execute(array("101",$gxsj,$userid,"bring_in"));
		$upresult = $upstmt -> rowCount();
		$result2 = $stmt2  -> rowCount();
		if($upresult&&$result2){
			echo "<script>alert('操作成功，返回“新增接入“页面！');window.location.href='../bringIn.php'</script>";
		}else{
			echo "<script>alert('保存失败！')</script>";
		}
	}

}
$stmt3 = $pdo -> prepare('SELECT * FROM `rs_bring_in` WHERE usrId = ? limit 1');
$stmt3 -> execute(array($userid));
$row = $stmt3 -> fetch();
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
				<input class="weui_input" name="bah" required="required"
					placeholder="如：京ICP备09031924号-1" value="<?php echo $row["bah"]?>" />
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label_second">ICP密码 <span style="color: red">*</span>
				</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<input class="weui_input" type="text" required="required"
					name="icpmm" value="<?php echo $row["icpmm"]?>" />
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label">接入方式 <span style="color: red">*</span>
				</label>
			</div>
			<div class="dx_cells weui_cells_checkbox">
				<?php foreach($jrfsstmt AS $jrfsrow):?>
				<label class="dx_cell weui_check_label"
					for="<?php echo "j".$jrfsrow["seq"]?>"> <input type="checkbox"
					name="jrfs[]" value="<?php echo $jrfsrow["value"]?>"
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
			<div id="city_2">
				<select class="prov" id="prov5" name="Province"
					data-code="@Model.Province"
					onChange="getproTextVal(this.options[this.selectedIndex].text)">
				</select> <select class="city" id="city5" name="City"
					data-code="@Model.City"
					onChange="setdzTextVal(this.options[this.selectedIndex].text)">
				</select> <select class="dist" id="area5" name="Area"
					data-code="@Model.Area" style="display: none"></select>
			</div>
		</div>
		<input type="hidden" id="dz" name="dz"
			value="<?php echo $row["fwqfzd"]?>" />
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label_second">网站IP地址 <span style="color: red">*</span>
				</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<textarea class="weui_textarea" name="wzipdz" placeholder="请输入IP地址"
					rows="3" required="required">
					<?php echo $row["wzipdz"]?>
				</textarea>
			</div>
		</div>
		<div class="weui_btn_area">
			<input type="submit" name="submit" value="保存信息"
				class="weui_btn dx_btn_primary" />
		</div>
		<div class="weui_btn_area">
			<a class="weui_btn dx_btn_primary" href="../Infomanage.php">返回备案桌面</a>
		</div>
	</form>

	<script src='../js/jquery.min.js'></script>
	<script src="../js/index.js"></script>
	<script type="text/javascript" src="../js/dxba.js"></script>
	<script src="../js/city2.js"></script>
	<script type="text/javascript" src="../js/citySelect2.js"></script>
	<script type="text/javascript">
	var selectVa2 = new CitySelect({
		data: data,
		provId: "#prov5",
		cityId: '#city5',
		areaId: '#area5',
		isSelect: false
		});
	</script>
</body>
</html>
