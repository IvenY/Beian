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
$czzt = "110";
include('judgeState.php');
$stmt = $pdo -> prepare('SELECT * FROM `rs_apply_curtain` WHERE usrId = ? && mkdm = ?');
$stmt -> execute(array($userid,$mkdm));
$row = $stmt -> fetch();
if(isset($_POST['submit'])){
	$sqsj = date('y-m-d h:i:s',time());
	$sqzt = "yhsq";
	$mkdm = $_POST['mkdm'];
	$xm = $_POST['xm'];
	$lxdh = $_POST['lxdh'];
	$yjdz = $_POST['yjdz'];
	$yjdzXx = $_POST['yjdzXx'];
	$bz = $_POST['bz'];

	if($row){
		$upstmt = $pdo -> prepare('UPDATE `rs_apply_curtain` SET sqsj= ?,xm=?,lxdh=?,yjdz=?,yjdzXx=?,bz=? WHERE usrId = ? && mkdm = ?');
		$upstmt -> execute(array($sqsj,$xm,$lxdh,$yjdz,$yjdzXx,$bz,$userid,$mkdm));
		$result = $upstmt ->rowCount();
		if($result)
			echo "<script>alert('保存成功')</script>；<script>history.back(-1)</script>";
	}else{
		$insertstmt = $pdo -> prepare('INSERT INTO `rs_apply_curtain` (mkdm,usrId,sqsj,zt,xm,lxdh,yjdz,yjdzXx,bz) VALUES (?,?,?,?,?,?,?,?,?)');
		$insertstmt -> execute(array($mkdm,$userid,$sqsj,$sqzt,$xm,$lxdh,$yjdz,$yjdzXx,$bz));
		$result = $insertstmt -> rowCount();
		if($result)
			echo "<script>alert('保存成功')</script><script>history.back(-1)</script>";
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>申请幕布</title>
<script type="text/javascript" src="js/dxba.js"></script>
<!-- 引入 WeUI -->
<link rel="stylesheet" href="css/weui.css" />
<link rel="stylesheet" href="css/testcss.css" />


</head>
<body>
	<?php include('top.php')?>
	<form action="" method="post">
		<div class="weui_cells_title">申请幕布</div>
		<div class="dx_title">申请幕布</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label">姓名 </label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<input class="weui_input" type="text" name="xm" required="required"
					value="<?php echo $row['xm']?>"
					<?php if($row) echo "disabled='disabled'"?> />
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label">联系电话 </label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<input class="weui_input" type="text" name="lxdh"
					required="required" value="<?php echo $row['lxdh']?>"
					<?php if($row) echo "disabled='disabled'"?> />
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label>邮寄地址 </label>
			</div>

		</div>
		<div class="demo">
			<div id="city_2" <?php if($row) echo "hidden='true'"?>>
				<select class="prov" id="prov5" name="Province"
					data-code="@Model.Province"
					onChange="getproTextVal(this.options[this.selectedIndex].text)">
				</select> <select class="prov" id="city5" name="City"
					data-code="@Model.City"
					onChange="getcityTextVal(this.options[this.selectedIndex].text)">
				</select> <select class="prov" id="area5" name="Area"
					data-code="@Model.Area"
					onChange="setdzTextVal(this.options[this.selectedIndex].text)">
				</select>
			</div>
		</div>
		<input type="hidden" id="dz" name="yjdz"
			value="<?php echo $row["yjdz"].$row['yjdzXx']?>" />
		<div class="demo">
			<input class="weui_input" type="text" name="yjdzXx"
				placeholder="请填入详细地址"
				value="<?php echo $row["yjdz"].$row['yjdzXx']?>"
				<?php if($row) echo "disabled='disabled'"?> />
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label">备注</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<textarea class="weui_textarea" placeholder="请输入备注" name="bz" rows="3" <?php if($row) echo "disabled='disabled'"?>> <?php echo $row['bz']?></textarea>
			</div>
		</div>
		<input name="mkdm" value="<?php echo $mkdm?>" hidden="true" />
		<div class="weui_btn_area">
			<?php if(!$row) echo "<input type='submit' name='submit' value='保存'
		class='weui_btn dx_btn_primary' />";
				else echo  "<a href='javascript:void(0)' onclick='' class='weui_btn dx_btn_primary'>取消保存</a>";?>
		</div>
		<div class="weui_btn_area">
			<?php if ($mkdm == "new")
				echo "<a class='weui_btn dx_btn_primary' href='new.php' id='button'>返回新增备案</a>";
			elseif ($mkdm == "bring_in")
			echo "<a class='weui_btn dx_btn_primary' href='bringIn.php' id='button'>返回新增接入</a>";
			elseif ($mkdm == "chg_zt")
			echo "<a class='weui_btn dx_btn_primary' href='chg/chgZt.php' id='button'>返回变更主体</a>";
			?>
		</div>
	</form>
	<script src='js/jquery.min.js'></script>
	<script src="js/city2.js"></script>
	<script type="text/javascript" src="js/citySelect2.js"></script>
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
