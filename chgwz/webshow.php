<?php
session_start();
//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['userid'])){
	header("Location:login.php");
	exit();
}
$userid = $_SESSION['userid'];
if(!isset($_GET['id'])){
	echo "<script> window.history.go(-1); </script>";
	exit();
}
$id = $_GET['id'];
include('../conn.php');
$fwqfzdstmt = $pdo->prepare('SELECT jrd FROM `rs_usr` WHERE id = :userId limit 1');
$fzdstmt = $pdo->prepare('SELECT * FROM `sys_dict` WHERE type=:site_yzjfzd');
$fwnrstmt = $pdo->prepare('SELECT * FROM `sys_dict` WHERE type=:site_fwnr');
$yylbstmt = $pdo->prepare('SELECT * FROM `sys_dict` WHERE type=:site_yylb');
$fzrzjlxstmt = $pdo->prepare('SELECT * FROM `sys_dict` WHERE type=:site_fzr_zjlx');
$jrfsstmt = $pdo->prepare('SELECT * FROM `sys_dict` WHERE type=:site_jrfs');
$sfygsstmt = $pdo->prepare('SELECT * FROM `sys_dict` WHERE type=:site_sfygssl');
$stmt = $pdo->prepare('SELECT * FROM `rs_site` WHERE usrId = ? && id= ?');

$fwqfzdstmt -> execute(array('userId'=>$userid));
$fzdstmt -> execute(array('site_yzjfzd'=> "site_yzjfzd"));
$fwnrstmt -> execute(array('site_fwnr'=> "site_fwnr"));
$yylbstmt -> execute(array('site_yylb'=> "site_yylb"));
$fzrzjlxstmt -> execute(array('site_fzr_zjlx'=>"site_fzr_zjlx"));
$jrfsstmt -> execute(array('site_jrfs'=>"site_jrfs"));
$sfygsstmt -> execute(array('site_sfygssl'=>"site_sfygssl"));
$stmt -> execute(array($userid,$id));
$row = $stmt -> fetch();
$fwqrow = $fwqfzdstmt -> fetch();

$arr1 = array();
$arr2 = array();
foreach ($fzdstmt AS $fzdrow){
	$arr1[$fzdrow['value']] = $fzdrow['name'];
}
foreach ($sfygsstmt AS $sfygsrow){
	$arr2[$sfygsrow['value']] = $sfygsrow['name'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>网站基本信息</title>
<!-- 引入 WeUI -->
<link rel="stylesheet" href="../css/weui.css" />
<link rel="stylesheet" href="../css/testcss.css" />
<script type="text/javascript" src="../js/dxba.js"></script>
</head>
<body>
	<div class="weui_cells_title">查看网站信息</div>
	<div class="dx_title">网站基本信息</div>
	<div class="dx_cells weui_cells_form">
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label">网站名称 <span style="color: red">*</span>
				</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"> <?php echo $row["mc"]?>
				</a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label">首页网址 <span style="color: red">*</span>
				</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<textarea class="weui_textarea" name="sywz"
					placeholder="可输入多个，以;分开，或者换行填写，不要加http://" rows="3"
					disabled="disabled"> <?php echo $row["sywz"]?>
				</textarea>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label">网站域名 <span style="color: red">*</span>
				</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<textarea class="weui_textarea" name="ym"
					placeholder="每行填写一个域名信息，回车换行。域名不能加www.,如果只有ip,则半角状态下填写ip地址"
					rows="3" disabled="disabled">
					<?php echo $row["ym"]?>
				</textarea>
			</div>
		</div>
		<div class="demo">
			<div class="weui_cell_hd">
				<label class="dx_infoslct" onclick="show();">点击查看服务内容 <span
					style="color: red">*</span>
				</label>
			</div>
		</div>
		<div class="demo" id="fwnr" style="display: none">
			<div class="dx_cells weui_cells_checkbox">
				<?php foreach ($fwnrstmt AS $fwnrrow):?>
				<label class="dx_cell weui_check_label"
					for="<?php echo "f".$fwnrrow["seq"]?>"> <input type="checkbox"
					name="fwnr[]" onclick="return false;"
					value="<?php echo $fwnrrow["value"]?>" id="<?php echo "f".$i?>"
					<?php
					$fwnrstr= $row["fwnr"];$str=explode(",",$fwnrstr);
					for ($i=0;$i<count($str);$i++){
								if($fwnrrow["value"]==$str[$i])
									echo "checked='true'";
							}
							?>> <?php echo $fwnrrow["name"]?>
				</label>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="demo">
			<div class="weui_cell_hd">
				<label class="dx_infoslct" onclick="show2();">点击查看语言类别 <span
					style="color: red">*</span>
				</label>
			</div>
		</div>
		<div class="demo" id="yylb" style="display: none">
			<div class="dx_cells weui_cells_checkbox">
				<?php foreach ($yylbstmt AS $yylbrow):?>
				<label class="dx_cell weui_check_label"
					for="<?php echo "y".$yylbrow["seq"]?>"> <input type="checkbox"
					name="yylb[]" onclick="return false;"
					value="<?php echo $yylbrow["value"]?>"
					id="<?php echo "y".$yylbrow["seq"]?>"
					<?php
					$yylbstr= $row["yylb"];$str=explode(",",$yylbstr);
					for ($i=0;$i<count($str);$i++){
								if($yylbrow["value"]==$str[$i])
									echo "checked='true'";
							}
							?>> <?php echo $yylbrow["name"]?>
				</label>
				<?php endforeach;?>
			</div>
		</div>
		<div class="dx_title">主体负责人基本情况</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label">姓名 <span style="color: red">*</span>
				</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<input class="weui_input" name="fzrxm" type="text" placeholder="说明"
					value="<?php echo $row["fzrXm"]?>" disabled="disabled" />
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label_second">有效证件类型<span style="color: red">*</span>
				</label>
			</div>
			<div>
				<a class="weui_input"> <?php foreach ($fzrzjlxstmt AS $fzrzjlxrow):
				$zjlxstr= $row["fzrZjlx"];$str=explode(",",$zjlxstr);
				for ($i=0;$i<count($str);$i++){
								if($fzrzjlxrow["value"]==$str[$i])
									echo $fzrzjlxrow["name"];
							}
							?> <?php endforeach; ?>
				</a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label_second">有效证件号码 <span style="color: red">*</span>
				</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"> <?php echo $row["fzrZjhm"]?>
				</a>
			</div>
		</div>

		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label">电子邮箱 <span style="color: red">*</span>
				</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"> <?php echo $row["fzrDzyx"]?>
				</a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label">办公电话 <span style="color: red">*</span>
				</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"> <?php echo $row["fzrBgdh"]?>
				</a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label">手机号码 <span style="color: red">*</span>
				</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"> <?php echo $row["fzrSjhm"]?>
				</a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label">MSN </label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"> <?php echo $row["fzrMsn"]?>
				</a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label">QQ </label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"> <?php echo $row["fzrQq"]?>
				</a>
			</div>
		</div>
		<div class="dx_title">网站接入信息</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_infoshow_label">服务器放置地 </label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"> <?php echo $fwqrow['jrd']?>
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
					<?php if ($jrfsrow["value"]=="qtfs") {
						echo "onchange=showmore("."'j".$jrfsrow["seq"]."')";
						}?>
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
		<div class="weui_cell" id="yzjfzd" style="display: none">
			<div class="weui_cell_hd">
				<label class="dx_label_second">云主机放置地 <span style="color: red">*</span>
				</label>
			</div>
			<div class="weui_cell_hd">
				<a class="weui_input"> <?php echo $arr1[$row['yzjfzd']]?>
				</a>
			</div>
		</div>
		<div class="weui_cell" id="sfygssl" style="display: none">
			<div class="weui_cell_hd">
				<label class="dx_label_third">是否云公司受理 <span style="color: red">*</span>
				</label>
			</div>
			<div class="weui_cell_hd">
				<a class="weui_input"> <?php echo $arr2[$row['sfygssl']]?>
				</a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label_second">网站IP地址</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<textarea class="weui_textarea" name="jrIp" placeholder="请输入IP地址"
					rows="3" disabled="disabled"> <?php echo $row["jrIp"]?>
				</textarea>
			</div>
		</div>
	</div>
	<input hidden="true" name="oldmc" value="<?php echo $name?>">
	<input hidden="true" name="lx" value="1">
	<div class="weui_btn_area">
		<input type="button" class="weui_btn dx_btn_primary"
			onclick="javascript:history.back(-1);" value=”返回上一页”>
	</div>
	<script src='../js/jquery.min.js'></script>
	<script type="text/javascript">
		var x = document.getElementById("j4");
		if(x.checked){
			document.getElementById("yzjfzd").style.display = "";
			document.getElementById("sfygssl").style.display = "";
		}
	</script>
</body>
</html>
