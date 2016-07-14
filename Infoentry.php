<?php
session_start();
//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['userid'])){
	header("Location:login.php");
	exit();
}
$userid = $_SESSION['userid'];
include('conn.php');
$mkdm = "new";
$czzt = "101";
include('judgeState.php');

$stmt = $pdo -> prepare('SELECT * FROM `rs_host_org` WHERE usrId = :usrId');
$stmt2 = $pdo -> prepare('SELECT * FROM `rs_per_in_chc` WHERE usrId = :usrId');
$xzstmt = $pdo -> prepare('SELECT * FROM `sys_dict` WHERE type = :xztype');
$zjlxstmt = $pdo -> prepare('SELECT * FROM `sys_dict` WHERE type = :zjlxtype');
$stmt -> execute(array('usrId' => $userid));
$stmt2 -> execute(array('usrId' => $userid));
$xzstmt -> execute(array('xztype' => "host_org_xz"));
$zjlxstmt -> execute(array('zjlxtype' => "host_org_zjlx"));
$row = $stmt -> fetch();
$row2 = $stmt2 -> fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>信息录入</title>
<script type="text/javascript" src="js/dxba.js"></script>
<!-- 引入 WeUI -->
<link rel="stylesheet" href="css/weui.css" />
<link rel="stylesheet" href="css/testcss.css" />


</head>
<body>
	<form name="entryForm" action="Infoentryok.php" method="post"
		onsubmit="return entryCheck(this)">
		<div class="weui_cells_title">第1步:填写ICP备案主体信息</div>
		<div class="dx_title">主办单位信息</div>
		<div class="dx_cells weui_cells_form">
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="weui_label">主办单位名称 <span style="color: red">*</span>
					</label>
				</div>
			</div>
			<div class="demo">
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" type="text" required="required" name="mc"
						value="<?php echo $row["mc"]?>" />
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="weui_label">主办单位性质</label>
				</div>
			</div>
			<div class="demo">
				<div class="weui_cell_hd">
					<select class="dx_slct" id="xz" name="xz" onchange="zbzjlxChange()">
						<option value="0">请选择</option>
						<?php foreach ($xzstmt AS $xzrow):?>
						<option value="<?php echo $xzrow["value"]?>"
						<?php
						if($xzrow["value"]==$row["xz"])
							echo "selected='true'";
						?>>
							<?php echo $xzrow["name"]?>
						</option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="weui_label">主办单位有效证件类型<span style="color: red">*</span>
					</label>
				</div>
			</div>
			<div class="demo">
				<div id="city_2">
					<select class="dx_slct" id="zbzjlx" name="zbdwzjlx">
						<option value="0">请先选择主办单位性质</option>
					</select>
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="weui_label">主办单位有效证件号码 <span style="color: red">*</span>
					</label>
				</div>

			</div>
			<div class="demo">
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" type="number" name="zjhm"
						value="<?php echo $row["zjhm"]?>" />
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="weui_label">证件住所 <span style="color: red">*</span>
					</label>
				</div>

			</div>
			<div class="demo">
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" type="text" name="zjzs"
						placeholder="请按照证件地址填写" value="<?php echo $row["zjzs"]?>" />
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="weui_label">主办单位所在地 <span style="color: red">*</span>
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
			<input type="hidden" id="dz" name="dz"
				value="<?php echo $row["dz"]?>" />
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="weui_label">主办单位通信地址 <span style="color: red">*</span>
					</label>
				</div>

			</div>
			<div class="demo">
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" type="text" name="txdz"
						value="<?php echo $row["txdz"]?>" />
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="weui_label">投资者或上级主管单位名称 <span style="color: red">*</span><br />
					</label>
				</div>
			</div>
			<div class="demo">
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" type="text" name="tzzhsjzgdw"
						placeholder="多个投资者或多个主管单位以符号;分割"
						value="<?php echo $row["tzzhsjzgdw"]?>" />
				</div>
			</div>

			<div class="dx_title">主体负责人基本情况</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label">姓名 <span style="color: red">*</span>
					</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" type="text" name="xm"
						value="<?php echo $row2["xm"]?>" />
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label_second">有效证件类型<span style="color: red">*</span>
					</label>
				</div>
				<div id="city_2">
					<select class="dx_slct" name="per_zjlx">
						<option value="0">请选择</option>
						<?php foreach ($zjlxstmt AS $zjlxrow ):?>
						<option value="<?php echo $zjlxrow["value"]?>"
						<?php
						if($zjlxrow["value"]==$row2["zjlx"])
							echo "selected='true'";
						?>>
							<?php echo $zjlxrow["name"]?>
						</option>
						<?php endforeach; $pdo = null?>
					</select>
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label_second">有效证件号码 <span style="color: red">*</span>
					</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" name="per_zjhm" type="number"
						value="<?php echo $row2["zjhm"]?>" />
				</div>
			</div>

			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label">电子邮箱 <span style="color: red">*</span>
					</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" name="per_dzyx" type="text"
						value="<?php echo $row2["dzyx"]?>" />
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label">办公电话 <span style="color: red">*</span>
					</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" type="text" name="bgdh"
						placeholder="格式：086-010-12345678"
						value="<?php echo $row2["bgdh"]?>" />
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label">手机号码 <span style="color: red">*</span>
					</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" type="number" name="per_sjhm"
						value="<?php echo $row2["sjhm"]?>" />
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label">MSN </label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" type="text" name="msn"
						value="<?php echo $row2["msn"]?>" />
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label">QQ </label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" type="number" name="qq"
						value="<?php echo $row2["qq"]?>" />
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label">备注</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<textarea class="weui_textarea" placeholder="请输入备注" name="bz"
						rows="3">
						<?php echo $row2["bz"]?>
					</textarea>
				</div>
			</div>
		</div>
		<div class="weui_btn_area">
			<input type="submit" value="保存并进入下一步" class="weui_btn dx_btn_primary" />
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

		var xz = document.getElementById("xz");
		var zbzjlx = document.getElementById("zbzjlx");
		if(xz.value){
			if(xz.value == "jd")
				zbzjlx.options.add(new Option("军队代号", "jddh"));
			else if(xz.value == "zfjg")
				zbzjlx.options.add(new Option("组织机构代码证", "zzjgdmz"));
			else if(xz.value == "sydw"){
				zbzjlx.options.add(new Option("组织机构代码证", "zzjgdmz"));
				zbzjlx.options.add(new Option("事业法人证", "syfrz"));
		   }else if(xz.value == "qy"){
			    zbzjlx.options.add(new Option("组织机构代码证", "zzjgdmz"));
				zbzjlx.options.add(new Option("工商营业执照", "gsyyzz"));
		   }else if(xz.value == "gr"){
			    zbzjlx.options.add(new Option("身份证", "sfz"));
				zbzjlx.options.add(new Option("护照", "hz"));
				zbzjlx.options.add(new Option("军官证", "jgz"));
				zbzjlx.options.add(new Option("台胞证", "tbz"));
		   }else if(xz.value == "shtt"){
				zbzjlx.options.add(new Option("组织机构代码证", "zzjgdmz"));
				zbzjlx.options.add(new Option("社团法人证", "stfrz"));
		   }
		}
		for(var i=0;i<zbzjlx.options.length;i++){
			if(zbzjlx.options[i].value == "<?php echo $row['zjlx']?>")
				zbzjlx.options[i].selected = true;
		}
	</script>

</body>
</html>
