<?php
session_start();
$array = array(
		"jddh" => "军队代号"	,
		"zzjgdmz" => "组织机构代码证",
		"syfrz" => "事业法人证",
		"gsyyzz" => "工商营业执照",
		"sfz" => "身份证",
		"hz" => "护照",
		"jgz" => "军官证",
		"tbz" => "台胞证",
		"stfrz" => "社团法人证"
);
//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['userid'])){
	header("Location:login.php");
	exit();
}
$userid = $_SESSION['userid'];
$mkdm = "new";
$version = 0;
include('conn.php');
$stmt = $pdo -> prepare('SELECT * FROM `rs_host_org` WHERE usrId = :usrId');
$stmt2 = $pdo -> prepare('SELECT * FROM `rs_per_in_chc` WHERE usrId = :usrId');
$stmt3 = $pdo -> prepare('SELECT * FROM `rs_site` s WHERE id in(SELECT CASE WHEN s.id is null THEN t.id ELSE s.id END FROM(SELECT * FROM `rs_site` WHERE mkdm = ? AND usrId = ?)t
		LEFT JOIN `rs_site` s ON s.mkdm = ? AND t.usrId = s.usrId AND t.id = s.old)');
$ztstmt = $pdo -> prepare('SELECT * FROM `rs_opt_state` WHERE usrId = :usrId && czlx = :czlx');
$xzstmt = $pdo -> prepare('SELECT * FROM `sys_dict` WHERE type = :xztype');
$zjlxstmt = $pdo -> prepare('SELECT * FROM `sys_dict` WHERE type = :zjlxtype');
$usrArr = array('usrId' => $userid);
$stmt -> execute($usrArr);
$stmt2 -> execute($usrArr);
$stmt3 -> execute(array("new",$userid,"chg_chg_wz"));
$ztstmt -> execute(array('usrId' => $userid,'czlx' => "new"));
$xzstmt -> execute(array('xztype' => "host_org_xz"));
$zjlxstmt -> execute(array('zjlxtype' => "host_org_zjlx"));
$row = $stmt -> fetch();
$row2 = $stmt2 ->fetch();
$ztrow = $ztstmt -> fetch();

$sql = "SELECT * FROM `rs_host_org` WHERE usrId = $userid";
$sql2 = "SELECT * FROM `rs_per_in_chc` WHERE usrId = $userid";
$sql3 = "SELECT * FROM `rs_site` WHERE usrId = $userid";
$ztsql = "SELECT * FROM `rs_opt_state` WHERE usrId = $userid && czlx = 'new'";

$i=0;//网站信息列表数据序号
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>备案主体信息</title>
<!-- 引入 WeUI -->
<link rel="stylesheet" href="css/weui.css" />
<link rel="stylesheet" href="css/testcss.css" />

</head>
<body>
	<form action="Webinfook.php" method="post">
		<div class="dx_title">备案主体信息</div>
		<div class="weui_cells_title">主办单位信息</div>
		<div class="dx_cells dx_cells_form">
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_infoshow_label">主办单位名称 </label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<a class="weui_input"> <?php echo $row["mc"]?>
					</a>
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_infoshow_label">主办单位性质 </label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<a class="weui_input"> <?php 
					foreach ($xzstmt AS $xzrow){
						if($xzrow["value"]==$row["xz"])
							echo $xzrow["name"];
						}?>
					</a>
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_infoshow_label">主办单位所在地 </label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<a class="weui_input"><?php echo $row["dz"]?> </a>
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_infoshow_label">有效证件类型 </label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<a class="weui_input"> <?php echo $array[$row["zjlx"]]?> </a>
				</div>

			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_infoshow_label">有效证件号码 </label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<a class="weui_input"><?php echo $row["zjhm"]?> </a>
				</div>

			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_infoshow_label">投资者或上级主管 </label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<a class="weui_input"> <?php echo $row["tzzhsjzgdw"]?>
					</a>
				</div>

			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_infoshow_label">主办单位通信地址 </label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<a class="weui_input"> <?php echo $row["txdz"]?>
					</a>
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_infoshow_label">备案阶段</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<a class="weui_input"> <?php if($ztrow['czzt']==100) echo "报备阶段-信息录入";
					elseif ($ztrow['czzt']==101) echo "报备阶段-提交证件";
					elseif ($ztrow['czzt']==102) echo "报备阶段-待预审核";
					elseif ($ztrow['czzt']==103) echo "报备阶段-待提交幕布照片";
					elseif ($ztrow['czzt']==104) echo "报备阶段-待核验";
					elseif ($ztrow['czzt']==105) echo "报备阶段-待提交管局";
					elseif ($ztrow['czzt']==106) echo "报备阶段-未提交至部系统";
					elseif ($ztrow['czzt']==107) echo "报备阶段-待前置审批";
					elseif ($ztrow['czzt']==108) echo "报备阶段-待管局审核";
					elseif ($ztrow['czzt']==109) echo "报备阶段-退回接入服务提供者修改";
					elseif ($ztrow['czzt']==110) echo "报备阶段-退回主办者修改";
					elseif ($ztrow['czzt']==111) echo "报备阶段-待管局审核-上报失败";
					elseif ($ztrow['czzt']==120) echo "报备阶段-待管局审核-上报成功";
					?>
					</a>
				</div>
			</div>
		</div>
		<div class="weui_cells_title">主体负责人基本情况</div>
		<div class="dx_cells dx_cells_form">
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_infoshow_label">姓名</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<a class="weui_input"> <?php echo $row2["xm"]?>
					</a>
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_infoshow_label">电子邮箱 </label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<a class="weui_input"> <?php echo $row2["dzyx"]?>
					</a>
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_infoshow_label">证件类型 </label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<a class="weui_input"><?php foreach ($zjlxstmt AS $zjlxrow){
						if($zjlxrow["value"]==$row2["zjlx"])
							echo $zjlxrow["name"];
					}?> </a>
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_infoshow_label">证件号码 </label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<a class="weui_input"> <?php echo $row2["zjhm"]?>
					</a>
				</div>

			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_infoshow_label">办公电话</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<a class="weui_input"><?php echo $row2["bgdh"]?> </a>
				</div>

			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_infoshow_label">手机号码</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<a class="weui_input"> <?php echo $row2["sjhm"]?>
					</a>
				</div>

			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_infoshow_label">MSN </label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<a class="weui_input"> <?php echo $row2["msn"]?>
					</a>
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_infoshow_label">QQ</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<a class="weui_input"> <?php echo $row2["qq"]?>
					</a>
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label">备注</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<textarea class="weui_textarea" name="bz" rows="3" disabled="disabled"><?php echo $row2["bz"]?></textarea>
				</div>
			</div>
			
		</div>
		<div class="dx_title">
			ICP备案网站信息列表<a href='Webinfo.php' class='weui_btn dx_btn_mini'>新增网站</a>
		</div>
		<div>
			<table class="dx_table">
				<tr>
					<th width="50">序号</th>
					<th width="200">网站名称</th>
					<th width="60">操作</th>
				</tr>
				<?php foreach ($stmt3 AS $row3): $i++;?>
				<tr align="center">
					<td class="dx_td"><?php echo $i ?></td>
					<td class="dx_td"><?php echo $row3["mc"] ?></td>
					<td class="dx_td tag bg-blue"
						onclick="location.href='<?php echo 'Webedit2.php?id='.$row3["id"] ?>'">查看</td>
				</tr>
				<?php endforeach; $pdo = null; ?>
			</table>
		</div>
		<div class="weui_btn_area">
			<a class="weui_btn dx_btn_primary" href="cert.php?mkdm=new">继续上传证件</a>
		</div>
		<div class="weui_btn_area">
			<input type="button" class="weui_btn dx_btn_primary"
			onclick="javascript:history.back(-1);" value="上一步">
		</div>
	</form>
	<script src='js/jquery.min.js'></script>
	<script src="js/city2.js"></script>
	<script type="text/javascript" src="js/dxba.js"></script>
	<script type="text/javascript" src="js/citySelect2.js"></script>

</body>
</html>
