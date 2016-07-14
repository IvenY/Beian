<?php
session_start();

//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['userid'])){
	header("Location:login.php");
	exit();
}
$userid = $_SESSION['userid'];
include('conn.php');
$stmt = $pdo -> prepare('SELECT * FROM `rs_usr` WHERE id = ? limit 1 ');
$stmt -> execute(array($userid));
$row = $stmt -> fetch();

if($_SERVER['REQUEST_METHOD']=="POST"){
	$dz = $_POST['dz'];
	$newsql = "UPDATE `rs_usr` SET jrd='$dz' WHERE id='$userid'";
	if(mysqli_query($connection, $newsql)){
		echo "<script>alert('更改成功！')</script>";
		echo "<script>location.href='change.php'</script>";
	}
	else
		echo "<script>alert('更改失败！')</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>变更IP</title>
<!-- 引入 WeUI -->
<link rel="stylesheet" href="css/weui.css" />
<link rel="stylesheet" href="css/testcss.css" />

<script src='js/jquery.min.js'></script>
<script type="text/javascript" src="js/dxba.js"></script>
</head>
<body>
	<div class="weui_cells_title">变更IP</div>
	<form action="" method="post">

		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_infoshow_label">旧接入地市 </label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"><?php echo $row["jrd"]?> </a>
			</div>
		</div>

		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label_second">新接入地市 <span style="color: red">*</span>
				</label>
			</div>
		</div>
		<div class="demo">
			<div id="city_2">
				<select class="prov" id="prov5" name="Province"
					data-code="@Model.Province"
					onChange="getproTextVal(this.options[this.selectedIndex].text)">
				</select> <select class="city" id="city5" name="City"
					data-code="@Model.City"
					onChange="getcityTextVal(this.options[this.selectedIndex].text)">
				</select> <select class="dist" id="area5" name="Area"
					data-code="@Model.Area"
					onChange="setdzTextVal(this.options[this.selectedIndex].text)">
				</select>
			</div>
		</div>
		<input type="hidden" id="dz" name="dz" />
		<div class="weui_btn_area">
			<input type="submit" name="submit" id="tjip" value="提交审核"
				class="weui_btn dx_btn_primary" />
		</div>
	</form>
	<div class="weui_btn_area">
		<a class="weui_btn dx_btn_primary" href="Infomanage.php">返回备案桌面</a>
	</div>
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
