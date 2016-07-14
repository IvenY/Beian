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
$czzt = "101";
include('judgeState.php');
$stmt = $pdo -> prepare('SELECT * FROM `rs_usr_cert` WHERE usrId = ? AND mkdm = ?');
$stmt -> execute(array($userid,$mkdm));
// 	$path='img/';//路径
$stmt3 = $pdo -> prepare('SELECT * FROM `rs_usr_ver_bill` WHERE usrId = ? AND mkdm = ?');
$stmt3 -> execute(array($userid,$mkdm));
$row3 = $stmt3 -> fetch();

$ifstmt = $pdo -> prepare('SELECT * FROM `rs_cert` WHERE usrId = ? AND deleted = ?');
$ifstmt -> execute(array($userid,"0"));
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
	<?php include('top.php')?>
	<div class="weui_cells_title">上传证件及核验单</div>
	<div class="dx_title">
		已上传证件 <a href="javascript:void(0)" class="weui_btn dx_btn_mini"
			onclick="ifUpzj(<?php echo $ifrow?>,'<?php echo $mkdm?>')">上传证件</a>
	</div>
	<div>
		<table class="dx_table">
			<tr>
				<th width="25%">操作</th>
				<th width="50%">证件类型</th>
				<th width="25%">证件说明</th>
			</tr>
			<?php foreach ($stmt AS $row):$stmt4 = $pdo -> prepare('SELECT * FROM `rs_cert` WHERE id = ? limit 1');
												$stmt4 -> execute(array($row['certId']));
												$frow = $stmt4 -> fetch();?>
			<tr align="center">
				<td class="dx_td"><a style="color: #073F89"
					onclick="lookimg2('<?php echo $frow['id']?>','<?php 
						echo $arr[$frow['zjlx']];
					?>')">查看</a><a class="dx_a"
					onclick="removeimg('<?php echo $frow['id']?>','<?php echo $mkdm?>')">移除</a></td>
				<td class="dx_td"><?php if($frow) echo $arr[$frow['zjlx']] ?>
				</td>
				<td class="dx_td"><?php echo $frow["zjsm"] ?></td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
	<div class="dx_title">
		已上传核验单 <a href="static/hyd.doc" class="weui_btn dx_btn_mini">下载核验单模板</a>
	</div>
	<div>
		<div class="dxui_dialog_ft">
			<div style="margin: 0 1.5em;">
				<a id="uploadhyd" href="javascript:;" onclick="opendiv('<?php echo $mkdm?>')" class="weui_btn dx_btn_mini">上传或更新核验单</a>
			</div>
			<div>
				<a href="javascript:;" class="weui_btn dx_btn_mini"
					onclick="lookimg2('<?php echo $row3['id']?>','查看核验单')">查看已上传核验单</a>
			</div>

		</div>
	</div>
	<div class="weui_btn_area">
		<?php if ($mkdm == "new")
			echo "<a class='weui_btn dx_btn_primary' href='new.php' id='button'>返回新增备案</a>";
		elseif ($mkdm == "bring_in")
			echo "<a class='weui_btn dx_btn_primary' href='bringIn.php' id='button'>返回新增接入</a>";
		elseif ($mkdm == "chg_zt")
			echo "<a class='weui_btn dx_btn_primary' href='chg/chgZt.php' id='button'>返回变更主体</a>";
		elseif ($mkdm == "chg_chg_wz")
		echo "<a class='weui_btn dx_btn_primary' href='chgwz/chgWz.php' id='button'>返回变更网站</a>";
		?>
	</div>
	<script src='js/jquery.min.js'></script>
	<script src="js/index.js"></script>
	<script src="js/dxba.js"></script>
	<script src="layer/layer.js"></script>
</body>
</html>
