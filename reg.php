<?php
session_start();
include('conn.php');
$dictstmt = $pdo -> prepare('SELECT * FROM `cfg_dict` WHERE type = ?');
$dictstmt -> execute(array("jrs"));
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$cjsj =  date('y-m-d H:i:s',time());
	$username = $_POST['username'];
	$zt = 1 ;
	$pwd = $_POST['password'];
	$zsxm = $_POST['zsxm'];
	$sj = $_POST['sj'];
	$jrd = $_POST['dz'];
	$jrs = $_POST['jrs'];
	$dzyx = $_POST['dzyx'];
	$bz = $_POST['bz'];
	//注册信息判断
	$pwd = sha1($pwd);
	// 	mysqli_select_db($connection, $dbname);
	$stmt2 = $pdo -> prepare('INSERT INTO `rs_usr`(cjsj,gxsj,dlm,zt,mm,jrd,jrs,zsxm,sj,dzyx,bz) VALUES (?,?,?,?,?,?,?,?,?,?,?)');
	$stmt2 -> execute(array($cjsj,$cjsj,$username,$zt,$pwd,$jrd,$jrs,$zsxm,$sj,$dzyx,$bz));
	$result = $stmt2 -> rowCount();
	if($result){
		echo "<script>window.location= 'Regok.php';</script>";
	}else{
		echo '抱歉！添加数据失败：<br />';
		echo '点击此处 <a href="javascript:history.back(-1);">返回</a> 重试';
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type">
<meta charset="UTF-8">
<title>注册</title>

<!-- 引入 WeUI -->
<link rel="stylesheet" href="css/weui.css" />
<link rel="stylesheet" href="css/testcss.css" />

</head>
<body>
	<form action="" method="post" name="regForm"
		onSubmit="return RegCheck(this)">
		<div class="dx_title">注册</div>
		<div class="weui_cells weui_cells_form">
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label">用户名 <span style="color: red">*</span>
					</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" type="text" required="required"
						name="username" placeholder="说明" />
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label">密码 <span style="color: red">*</span>
					</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" type="password" required="required"
						name="password" placeholder="说明" />
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label">确认密码 <span style="color: red">*</span>
					</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" type="password" name="password2"
						placeholder="说明" />
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label_first">首次报备接入点 <span style="color: red">*</span>
					</label>
				</div>
			</div>
			<div class="demo">
				<div id="city_2">
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
			<input type="hidden" id="dz" name="dz" />
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label">接入商 <span style="color: red">*</span>
					</label>
				</div>

				<div class="weui_cell_hd">
					<select class="prov" name="jrs">
						<option value="1">请选择</option>
						<?php foreach($dictstmt AS $dictrow):?>
						<option value="<?php echo $dictrow['value']?>">
							<?php echo $dictrow['name']?>
						</option>
						<?php endforeach;$pdo = null?>
					</select>
				</div>

			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label">姓名 <span style="color: red">*</span>
					</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" type="text" required="required"
						name="zsxm" placeholder="说明" />
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label">手机 <span style="color: red">*</span>
					</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" required="required" type="number"
						name="sj" placeholder="说明" />
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label">电子邮箱 <span style="color: red">*</span>
					</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" required="required" type="text"
						name="dzyx" placeholder="说明" />
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label">备注</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<textarea class="weui_textarea" name="bz" placeholder="请输入备注"
						rows="3"></textarea>
				</div>
			</div>
			<div class="weui_cell weui_vcode">
				<div class="weui_cell_hd">

					<label class="dx_label">验证码 <span style="color: red">*</span>
					</label>

				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" required="required" name="checkpic"
						placeholder="请输入验证码" />
				</div>
				<div class="weui_cell_ft">
					<img id="checkpic" onclick="changing();" src='checkcode.php' />
				</div>
			</div>

		</div>
		<div class="weui_btn_area">
			<input class="weui_btn dx_btn_primary" type="submit" name="submit"
				value="提交" />
		</div>
	</form>
	<script src='js/jquery.min.js'></script>
	<script src="js/index.js"></script>
	<script type="text/javascript" src="js/dxba.js"></script>
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
