<?php
session_start();

//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['userid'])){
	header("Location:login.php");
	exit();
}
$userid = $_SESSION['userid'];
include('conn.php');
$fwqfzdstmt = $pdo->prepare('SELECT jrd FROM `rs_usr` WHERE id = :userId limit 1');
$fzdstmt = $pdo->prepare('SELECT * FROM `sys_dict` WHERE type=:site_yzjfzd');
$fwnrstmt = $pdo->prepare('SELECT * FROM `sys_dict` WHERE type=:site_fwnr');
$yylbstmt = $pdo->prepare('SELECT * FROM `sys_dict` WHERE type=:site_yylb');
$fzrzjlxstmt = $pdo->prepare('SELECT * FROM `sys_dict` WHERE type=:site_fzr_zjlx');
$jrfsstmt = $pdo->prepare('SELECT * FROM `sys_dict` WHERE type=:site_jrfs');
$sfygsstmt = $pdo->prepare('SELECT * FROM `sys_dict` WHERE type=:site_sfygssl');

$fwqfzdstmt -> execute(array('userId'=>$userid));
$fzdstmt -> execute(array('site_yzjfzd'=> "site_yzjfzd"));
$fwnrstmt -> execute(array('site_fwnr'=> "site_fwnr"));
$yylbstmt -> execute(array('site_yylb'=> "site_yylb"));
$fzrzjlxstmt -> execute(array('site_fzr_zjlx'=>"site_fzr_zjlx"));
$jrfsstmt -> execute(array('site_jrfs'=>"site_jrfs"));
$sfygsstmt -> execute(array('site_sfygssl'=>"site_sfygssl"));

$fwqfzdrow = $fwqfzdstmt -> fetch();

if (isset($_POST['submit'])) {
	$fwnrstr = '';
	$yylbstr = '';
	$jrfsstr = '';
	$userid = $_SESSION['userid'];
	$username = $_SESSION['username'];
	$cjsj = date('y-m-d h:i:s',time());
	$gxsj = date('y-m-d h:i:s',time());
	$mc = $_POST['mc'];
	$sywz = $_POST['sywz'];
	$ym = $_POST['ym'];
	$fwnr = $_POST['fwnr'];
	$yylb = $_POST['yylb'];
	$jrfs = $_POST['jrfs'];
	$yzjfzd = $_POST['yzjfzd'];
	$sfygssl = $_POST['sfygssl'];
	for($i=0;$i<count($fwnr);$i++){
		if($i == 0){
			$fwnrstr=$fwnr[0];
		}else{
			$fwnrstr.=",".$fwnr[$i];
		}
	}
	for($i=0;$i<count($yylb);$i++){
		if($i == 0){
			$yylbstr=$yylb[0];
		}else{
			$yylbstr.=",".$yylb[$i];
		}
	}
	for($i=0;$i<count($jrfs);$i++){
		if($i == 0){
			$jrfsstr=$jrfs[0];
		}else{
			$jrfsstr.=",".$jrfs[$i];
		}
	}
	$fzrXm = $_POST['fzrxm'];
	$fzrZjlx =$_POST['fzrZjlx'];
	$fzrZjhm= $_POST['fzrZjhm'];
	$fzrDzyx = $_POST['fzrDzyx'];
	$fzrBgdh = $_POST['fzrBgdh'];
	$fzrSjhm = $_POST['fzrSjhm'];
	$fzrMsn = $_POST['fzrMsn'];
	$fzrQq= $_POST['fzrQq'];
	$jrIp= $_POST['jrIp'];
	//包含数据库连接文件
	include('conn.php');
	//判断数据是否存在
	$stmt = $pdo -> prepare('INSERT INTO `rs_site` (mkdm,version,usrId,cjsj,gxsj,mc,sywz,ym,fwnr,yylb,fzrXm,fzrZjlx,fzrZjhm,fzrDzyx,fzrBgdh,fzrSjhm,fzrMsn,fzrQq,jrfs,yzjfzd,sfygssl,jrIp)
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
	$stmt2 = $pdo -> prepare('UPDATE `rs_opt_state` SET czzt= ? WHERE usrId = ? && czlx = ?');
	$czzt = "101";
	$mkdm = "new";
	$version = "0";
	$arr = array($mkdm,$version,$userid,$cjsj,$gxsj,$mc,$sywz,$ym,$fwnrstr,$yylbstr,$fzrXm,$fzrZjlx,$fzrZjhm,$fzrDzyx,$fzrBgdh,$fzrSjhm,$fzrMsn,$fzrQq,$jrfsstr,$yzjfzd,$sfygssl,$jrIp);
	$arr2 = array($czzt,$userid,$mkdm);
	$result2 = $stmt2 -> execute($arr2);
	if($result2){
		$result = $stmt -> execute($arr);
		if($result)
			echo "<script>window.location= 'Infoshow.php?type=lr';</script>";
		else {
			echo '抱歉！添加数据失败：<br />';
			echo '点击此处 <a href="javascript:history.back(-1);">返回</a> 重试';
		}
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>网站基本信息</title>
<!-- 引入 WeUI -->
<link rel="stylesheet" href="css/weui.css" />
<link rel="stylesheet" href="css/testcss.css" />
<script type="text/javascript" src="js/dxba.js"></script>
</head>
<body>
	<form action="" method="post">
		<div class="weui_cells_title">第2步:填写ICP备案网站信息</div>
		<div class="dx_title">网站基本信息</div>
		<div class="dx_cells weui_cells_form">
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label">网站名称 <span style="color: red">*</span>
					</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" name="mc" type="text" required="required"
						placeholder="网站名称填全称，不能缩写" />
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label">首页网址 <span style="color: red">*</span>
					</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<textarea class="weui_textarea" name="sywz"
						placeholder="可输入多个，以;分开，或者换行填写，不要加http://" rows="3"></textarea>
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
						rows="3"></textarea>
				</div>
			</div>
			<div class="demo">
				<div class="weui_cell_hd">
					<label class="dx_infoslct" onclick="show();">点击选择服务内容 <span
						style="color: red">*</span>
					</label>
				</div>
			</div>
			<div class="demo" id="fwnr" style="display: none">
				<div class="dx_cells weui_cells_checkbox">
					<?php foreach ($fwnrstmt AS $fwnrrow):?>
					<label class="dx_cell weui_check_label"
						for="<?php echo "f".$fwnrrow["seq"]?>"> <input type="checkbox"
						name="fwnr[]" value="<?php echo $fwnrrow["value"]?>"
						id="<?php echo "f".$i?>"> <?php echo $fwnrrow["name"]?>
					</label>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="demo">
				<div class="weui_cell_hd">
					<label class="dx_infoslct" onclick="show2();">点击选择语言类别 <span
						style="color: red">*</span>
					</label>
				</div>
			</div>
			<div class="demo" id="yylb" style="display: none">
				<div class="dx_cells weui_cells_checkbox">
					<?php foreach($yylbstmt AS $yylbrow):?>
					<label class="dx_cell weui_check_label"
						for="<?php echo "y".$yylbrow["seq"]?>"> <input type="checkbox"
						name="yylb[]" value="<?php echo $yylbrow["value"]?>"
						id="<?php echo "y".$yylbrow["seq"]?>"> <?php echo $yylbrow["name"]?>
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
					<input class="weui_input" name="fzrxm" type="text" placeholder="说明" />
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label_second">有效证件类型<span style="color: red">*</span>
					</label>
				</div>
				<div>
					<select class="dx_slct" name="fzrZjlx">
						<option value="0">请选择</option>
						<?php foreach($fzrzjlxstmt AS $fzrzjlxrow): ?>
						<option value="<?php echo $fzrzjlxrow["value"]?>">
							<?php echo $fzrzjlxrow["name"]?>
						</option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label_second">有效证件号码 <span style="color: red">*</span>
					</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" name="fzrZjhm" type="number"
						placeholder="说明" />
				</div>
			</div>

			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label">电子邮箱 <span style="color: red">*</span>
					</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" name="fzrDzyx" type="text"
						placeholder="说明" />
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label">办公电话 <span style="color: red">*</span>
					</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" name="fzrBgdh" type="text"
						placeholder="格式：086-010-02998299" />
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label">手机号码 <span style="color: red">*</span>
					</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" name="fzrSjhm" type="number"
						placeholder="说明" />
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label">MSN </label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" name="fzrMsn" type="text"
						placeholder="说明" />
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label">QQ </label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" name="fzrQq" type="number"
						placeholder="说明" />
				</div>
			</div>
			<div class="dx_title">网站接入信息</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_infoshow_label">服务器放置地 </label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<a class="weui_input"> <?php echo $fwqfzdrow['jrd']?>
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
						name="jrfs[]" value="<?php echo $jrfsrow["value"]?>"
						id="<?php echo "j".$jrfsrow["seq"]?>"
						<?php if ($jrfsrow["value"]=="qtfs") {
							echo "onchange=showmore("."'j".$jrfsrow["seq"]."')";
						}?>> <?php echo $jrfsrow["name"]?>
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
						<select class="dx_slct" name="yzjfzd">
							<option>请选择</option>
							<?php foreach ($fzdstmt AS $fzdrow): $i++;?>
							<option value="<?php echo $fzdrow["value"]?>">
								<?php echo $fzdrow["name"]?>
							</option>
							<?php endforeach?>
						</select>
					</div>
			</div>
			<div class="weui_cell" id="sfygssl" style="display: none">
					<div class="weui_cell_hd">
						<label class="dx_label_third">是否云公司受理 <span style="color: red">*</span>
						</label>
					</div>
					<div class="weui_cell_hd">
						<select class="dx_slct" name="sfygssl">
							<option>请选择</option>
							<?php foreach ($sfygsstmt AS $sfygsrow): $i++;?>
							<option value="<?php echo $sfygsrow["value"]?>">
								<?php echo $sfygsrow["name"]?>
							</option>
							<?php endforeach;$pdo = null; ?>
						</select>
					</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="dx_label_second">网站IP地址</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<textarea class="weui_textarea" name="jrIp" placeholder="请输入IP地址"
						rows="3"></textarea>
				</div>
			</div>
		</div>
		<input hidden="true" name="lx" value="0">
		<div class="weui_btn_area">
			<input type="submit" value="保存信息" name="submit"
				class="weui_btn dx_btn_primary" />
		</div>

	</form>
	<script src='js/jquery.min.js'></script>

</body>
</html>
