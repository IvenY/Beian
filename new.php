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
$stmt = $pdo->prepare('SELECT * FROM `rs_opt_state` WHERE usrId = :usrId && czlx = :czlx');
$stmt -> execute(array('usrId' => $userid ,'czlx' => $mkdm));
$row = $stmt -> fetch();
$bgsj = date('y-m-d H:i:s',time());
if(!$row){
	$stmtIn = $pdo->prepare('INSERT INTO `rs_opt_state` (usrId,czlx,czzt,bgsj) VALUES (:usrId,:czlx,:czzt,:bgsj)');
	$stmtIn -> execute(array('usrId' => $userid ,'czlx' => $mkdm,'czzt' => "100",'bgsj'=>$bgsj));
}
if($_SERVER['REQUEST_METHOD']=="POST"){
	$czzt= $_POST['zt'];
	if($czzt == 101 || $czzt == 103){
		$zt = 102; 
		$stmt2 = $pdo->prepare('UPDATE `rs_opt_state` SET czzt=:czzt,bgsj=:bgsj WHERE usrId = :usrId && czlx = :czlx');
		$stmt2 ->execute(array('czzt' => $zt,'bgsj' =>$bgsj,'usrId'=>$userid,'czlx'=>$mkdm));
	}else if($czzt == 110 || $czzt == 112){
		$zt = 111;
		$stmt2 = $pdo->prepare('UPDATE `rs_opt_state` SET czzt=:czzt,bgsj=:bgsj WHERE usrId = :usrId && czlx = :czlx');
		$stmt2 ->execute(array('czzt' => $zt,'bgsj' =>$bgsj,'usrId'=>$userid,'czlx'=>$mkdm));
	}else if($czzt == 100){
		$delstmt = $pdo->prepare('DELETE FROM `rs_per_in_chc` WHERE usrId = :usrId');
		$delstmt2 = $pdo->prepare('DELETE FROM `rs_host_org` WHERE usrId = :usrId');
		$delstmt3 = $pdo->prepare('DELETE FROM `rs_site` WHERE usrId = :usrId');
		$arr = array('usrId'=>$userid);
		$delstmt ->execute($arr);
		$delstmt2 ->execute($arr);
		$delstmt3 ->execute($arr);
	}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>备案主体信息</title>
<!-- 引入 WeUI -->
<link rel="stylesheet" href="css/weui.css" />
<link rel="stylesheet" href="css/testcss.css" />
<script type="text/javascript" src="js/dxba.js"></script>
<script src='js/jquery.min.js'></script>
</head>
<body>
	<?php include('top.php')?>
	<div class="weui_cells_title">新增备案需要进行如下步骤</div>
	<div class="dx_cells weui_cells_form">
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label <?php if ($row['czzt']<=100){
					echo "style='color:red'";}else{
				 	echo "style='color:#073F89'";}?>>第一步、 <span style="color: black;">信息录入</span>
				</label>
			</div>
			<div class="dx_tag">
				<a class="tag bg-blue" <?php if($row['czzt']<102)
					echo "href='Infoentry.php'";
				else 
					echo "onclick='fbentry()'";?>>开始录入</a> 
				<a class="tag bg-blue" href="show.php">查看录入信息</a> 
				<a class="tag bg-yellow" href="javascript:void(0)" onclick="cancel(<?php echo $row['czzt']?>,'new')">撤销备案</a>
			</div>
		</div>
		<div class="weui_cell" >
			<div class="weui_cell_hd">
				<label <?php if ($row['czzt']==101){
					echo "style='color:red'";}else{
				 	echo "style='color:#073F89'";}?>>第二步、 <span style="color: black;">上传证件及核验单</span>
				</label>
			</div>
		<div class="dx_tag" <?php if ($row['czzt']<101) echo "style='display: none'";?>>
				<a class="tag bg-blue" href="cert.php?mkdm=new">开始上传</a> 
				<a class="tag bg-green" href="javascript:void(0)" onclick="submitInfo(<?php 
				if($row['czzt']==101 || $row['czzt']==103) 
					echo $row['czzt'];
				else
					echo 0;?>,'new')">提交审核</a> 
			</div>
			
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label <?php if ($row['czzt']==102 || $row['czzt']==103){
					echo "style='color:red'";}else{
				 	echo "style='color:#073F89'";}?>>第三步、 <span style="color: black;">备案信息初审</span>
				</label>
			</div>
			<div class="dx_tag" <?php if ($row['czzt']<102) echo "style='display: none'";?>>
				<a class="tag bg-yellow" href="reject.php?mkdm=new">查看退回信息</a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label <?php if ($row['czzt']==110){
					echo "style='color:red'";}else{
				 	echo "style='color:#073F89'";}?>>第四步、 <span style="color: black;">申请幕布拍照上传</span>
				</label>
			</div>
			<div class="dx_tag" <?php if ($row['czzt']<110) echo "style='display: none'";?>>
				<a class="tag bg-blue" href="applyCurtain.php?mkdm=new">申请幕布</a> 
				<a class="tag bg-blue" href="curtainPhoto.php?mkdm=new">上传照片</a> 
				<a class="tag bg-green" href="javascript:void(0)" onclick="submitInfo(<?php 
				if($row['czzt']==110 || $row['czzt']==112) 
					echo $row['czzt'];
				else
					echo 0;?>,'new')">提交核验</a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label <?php if ($row['czzt']==111 || $row['czzt']==112){
					echo "style='color:red'";}else{
				 	echo "style='color:#073F89'";}?>>第五步、 <span style="color: black;">信息核验</span>
				</label>
			</div>
			<div class="dx_tag" <?php if ($row['czzt']<111) echo "style='display: none'";?>>
				<a class="tag bg-yellow" href="reject.php?mkdm=new">查看退回信息</a>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label <?php if ($row['czzt']==120){
					echo "style='color:red'";}else{
				 	echo "style='color:#073F89'";}?>>第六步、 <span style="color: black;">提交管局备案</span>
				</label>
			</div>
			<div class="dx_tag" >
				<a class="tag bg-blue" href="progress.php">进度查询</a> 
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label <?php if ($row['czzt']==200){
					echo "style='color:red'";}else{
				 	echo "style='color:#073F89'";}?>>第七步、 <span style="color: black;">备案成功</span>
				</label>
			</div>
			<div class="dx_tag" <?php if ($row['czzt']<200) echo "style='display: none'";?>>
				<a class="tag bg-blue" href="show.php">备案信息</a> 
			</div>
		</div>
	</div>
	<div class="weui_btn_area">
		<a class="weui_btn dx_btn_primary" href="Infomanage.php">返回备案桌面</a>
	</div>
</body>
</html>
