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
$arr1 = array();
$arr2 = array();
include('conn.php');
$arr = array($userid);
$czlx = "new";
$version = 0;
$stmt = $pdo -> prepare('SELECT * FROM `rs_host_org` WHERE usrId = ? limit 1');
$stmt2 = $pdo-> prepare('SELECT * FROM `rs_per_in_chc` WHERE usrId = ? limit 1');
$stmt3 = $pdo -> prepare('SELECT * FROM `rs_site` WHERE usrId = ?&& version = ?');
$ztstmt = $pdo -> prepare('SELECT * FROM `rs_opt_state` WHERE usrId = ? && czlx = ?');
$stmt ->execute($arr);
$stmt2 ->execute($arr);
$stmt3 ->execute(array($userid,$version));
$ztstmt ->execute(array($userid,$czlx));
$row = $stmt -> fetch();
$row2 = $stmt2 -> fetch();
$ztrow = $ztstmt -> fetch();

$allstmt = $pdo -> prepare('SELECT * FROM `sys_dict` WHERE type=?');
$allstmt -> execute(array("host_org_xz"));
$xzrow = $allstmt -> fetchAll();
$allstmt -> execute(array("host_org_zjlx"));
$zjlxrow = $allstmt -> fetchAll();
$allstmt -> execute(array("site_yzjfzd"));
foreach ($allstmt AS $fzdrow){
	$arr1[$fzdrow['value']] = $fzdrow['name'];
}
$allstmt -> execute(array("site_fwnr"));
foreach ($allstmt AS $fwnrrow){
	$fwnrdata[]=$fwnrrow;
}
$allstmt -> execute(array("site_yylb"));
foreach ($allstmt AS $yylbrow){
	$yylbdata[]=$yylbrow;
}
$allstmt -> execute(array("site_fzr_zjlx"));
foreach ($allstmt AS $fzrzjlxrow){
	$fzrzjlxdata[]=$fzrzjlxrow;
}
$allstmt -> execute(array("site_jrfs"));
foreach ($allstmt AS $jrfsrow){
	$jrfsdata[]=$jrfsrow;
}
$row3 = $stmt3 -> fetchAll();
$num = count($row3);
$i=0;//网站信息列表数据序号

// foreach ($sfygsstmt AS $sfygsrow){
// 	$arr2[$sfygsrow['value']] = $sfygsrow['name'];
// }



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
	<?php include('top.php')?>
	<div class="dx_title">ICP备案主体信息</div>
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
				<a class="weui_input"> <?php for ($i=0;$i<count($xzrow);$i++){
					if($xzrow[$i]["value"]==$row["xz"])
						echo $xzrow[$i]["name"];
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
				<label class="dx_infoshow_label">主办单位证件住所 </label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"> <?php echo $row["zjzs"]?>
				</a>
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
				<a class="weui_input"><?php for ($i=0;$i<count($zjlxrow);$i++){
					if($zjlxrow[$i]["value"]==$row2["zjlx"])
						echo $xzrow[$i]["name"];
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
				<textarea class="weui_textarea" name="bz" rows="3">
					<?php echo $row2["bz"]?>
				</textarea>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_infoshow_label">备案/许可证号</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"> </a>
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
					elseif ($ztrow['czzt']==112) echo "报备阶段-待管局审核-上报成功";
					?></a>
			</div>
		</div>
	</div>
	<div class="dx_title">
		ICP备案网站信息列表(共
		<?php echo $num ?>
		个)
	</div>
	<?php for ($i=0;$i<count($row3);$i++): ?>
	<div class="dx_cells dx_cells_form">
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_infoshow_label"><?php echo $row3[$i]["mc"]?> </label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"> <?php echo $row3[$i]["sywz"]?>
				</a>
			</div>
		</div>
		<div class="weui_cells_title">网站基本信息</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_infoshow_label">网站备案号</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"> </a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_infoshow_label">网站域名 </label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"> <?php echo $row3[$i]["ym"]?>
				</a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_infoshow_label">服务内容</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"><?php  for($k=0;$k<count($fwnrdata);$k++){
					$fwnrstr= $row3[$i]["fwnr"];$str=explode(",",$fwnrstr);
					for ($j=0;$j<count($str);$j++){
						if($fwnrdata[$k]['value']==$str[$j])
							echo $fwnrdata[$k]['name']."&nbsp;&nbsp;";
					}
				}?> </a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_infoshow_label">语言类别 </label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"> <?php  for($k=0;$k<count($yylbdata);$k++){
					$yylbstr= $row3[$i]["yylb"];$str=explode(",",$yylbstr);
					for ($j=0;$j<count($str);$j++){
						if($yylbdata[$k]['value']==$str[$j])
							echo $yylbdata[$k]['name']."&nbsp;&nbsp;";
					}
				}?>
				</a>
			</div>
		</div>
		<div class="weui_cells_title">网站负责人基本情况</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_infoshow_label">负责人姓名</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"><?php echo $row3[$i]["fzrXm"]?> </a>
			</div>

		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_infoshow_label">电子邮箱</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"> <?php echo $row3[$i]["fzrDzyx"]?>
				</a>
			</div>

		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_infoshow_label">办公电话</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"> <?php echo $row3[$i]["fzrBgdh"]?>
				</a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_infoshow_label">手机号码</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"> <?php echo $row3[$i]["fzrSjhm"]?>
				</a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_infoshow_label">证件类型</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"> <?php for($k=0;$k<count($fzrzjlxdata);$k++){
						if($fzrzjlxdata[$k]['value']==$row3[$i]['fzrZjlx'])
							echo $fzrzjlxdata[$k]['name']."&nbsp;&nbsp;";
				}?>
				</a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_infoshow_label">证件号码</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"> <?php echo $row3[$i]["fzrZjhm"]?>
				</a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_infoshow_label">MSN</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"> <?php echo $row3[$i]["fzrMsn"]?>
				</a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_infoshow_label">QQ</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"> <?php echo $row3[$i]["fzrQq"]?>
				</a>
			</div>
		</div>
		<div class="weui_cells_title">网站接入信息</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_infoshow_label">接入方式</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"> <?php for($k=0;$k<count($jrfsdata);$k++){
						if($jrfsdata[$k]['value']==$row3[$i]['jrfs'])
							echo $jrfsdata[$k]['name']."&nbsp;&nbsp;";
				}?>
				</a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_infoshow_label">服务器放置地</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"> <?php if($row3[$i]["yzjfzd"]) echo $arr1[$row3[$i]["yzjfzd"]];?>
				</a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_infoshow_label">IP</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<a class="weui_input"> <?php echo $row3[$i]["jrIp"]?>
				</a>
			</div>
		</div>
	</div>
	<?php endfor; ?>
	<div class="weui_btn_area">	
	<input type="button" class="weui_btn dx_btn_primary"
			onclick="javascript:history.back(-1);" value="上一步">
	</div>
	<div class="weui_dialog_alert" style="display: none;">
		<div class="weui_mask"></div>
		<div class="weui_dialog">
			<div class="weui_dialog_hd">
				<strong class="weui_dialog_title">弹窗标题</strong>
			</div>
			<div class="weui_dialog_bd">弹窗内容，告知当前页面信息等</div>
			<div class="weui_dialog_ft">
				<a href="javascript:;" class="weui_btn_dialog primary">确定</a>
			</div>
		</div>
	</div>
	<script src='js/jquery.min.js'></script>
	<script src="js/index.js"></script>
	<script src="js/city2.js"></script>
	<script src="js/dxba.js"></script>
	<script type="text/javascript" src="js/citySelect2.js"></script>

</body>
</html>
