<?php
session_start();

//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['userid'])){
	header("Location:login.php");
	exit();
}
$userid = $_SESSION['userid'];
$mkdm = $_GET['mkdm'];
$czzt = "110";
include('uploadImg.php');
include('judgeState.php');
$stmt3 = $pdo -> prepare('SELECT * FROM `rs_curtain_photo` WHERE usrId = ? && mkdm = ?');
if($_SERVER['REQUEST_METHOD']=='POST'){
	if (!is_uploaded_file($_FILES["photo"]['tmp_name'])){
		echo "<script>alert('请选择图片')</script>";
	}
	$scsj = date('Y-m-d H:i:s',time());
	$year=((int)substr($scsj,0,4));
	$month=date("m");
	$wjjname=$year.$month;
	$path='/upload/file/'.$wjjname.'/'; //图片存放路径
	if(!is_dir($path1.$path)){//路径若不存在则创建
		mkdir($path1.$path,0700,true);
	}
	$upfile=$_FILES["photo"];
	$imgsize = $_FILES['photo']['size'];
	$pinfo=path_info($upfile["name"]);
	$name=$pinfo['filename'];//文件名
	$tmp_name=$upfile["tmp_name"];
	$file_type=$pinfo['extension'];//获得文件类型
	$showphpath=$path.$newname.".".$file_type;
	if(in_array($upfile["type"],$phtypes)){
		echo "文件类型不符！";
		exit();
	}
	if(move_uploaded_file($tmp_name,$path1.$showphpath)){
		Img($path1.$showphpath,$imgsize,1);
		$stmt3 -> execute(array($userid,$mkdm));
		$row3 = $stmt3 -> fetch();
		if(!$row3){
			$stmt1 = $pdo -> prepare('INSERT INTO `rs_curtain_photo` (mkdm,usrId,scsj,bclj) VALUES (?,?,?,?)');
			$arr = array($mkdm,$userid,$scsj,$showphpath);
			$stmt1 -> execute($arr);
		}else{
			$stmt1 = $pdo -> prepare('UPDATE `rs_curtain_photo` SET bclj=? WHERE usrId=? && mkdm = ?');
			$arr = array($showphpath,$userid,$mkdm);
			$stmt1 -> execute($arr);
			$result = $stmt1 ->rowCount();
			if($result)
				@unlink($path1.$row3['bclj']);
		}
		
		echo "<script>var index = parent.layer.getFrameIndex(window.name);
								parent.location.reload();
					parent.layer.close(index);
					alert('上传成功！')</script>";
	}
}

function path_info($filepath)
{
	$path_parts = array();
	$path_parts ['dirname'] = rtrim(substr($filepath, 0, strrpos($filepath, '/')),"/")."/";
	$path_parts ['basename'] = ltrim(substr($filepath, strrpos($filepath, '/')),"/");
	$path_parts ['extension'] = substr(strrchr($filepath, '.'), 1);
	$path_parts ['filename'] = ltrim(substr($path_parts ['basename'], 0, strrpos($path_parts ['basename'], '.')),"/");
	return $path_parts;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport"
	content="width=device-width,initial-scale=1,user-scalable=0">
<title>上传证件及核验单</title>
<!-- 引入 WeUI -->
<link rel="stylesheet" href="css/weui.css" />
<link rel="stylesheet" href="css/testcss.css" />

</head>
<body>
	<div id="upldiv" class="dxui_dialog_alert">
			<div style="margin-left: 1.3em; color: red;">
				<strong>注意：</strong><a>重新上传将覆盖已上传的照片</a>
			</div>
			<form id="upload_form" enctype="multipart/form-data" method="post"
				name="form1"  action="">
				<div class="dxui_dialog_bd" style="padding: 2em 1.5em 0">
					<input type="file" name="photo" id="upload" />
				</div>
				<div class="dxui_dialog_ft" style="padding-top: .7em">
					<a href="javascript:;" class="dxui_btn_dialog primary"
						id="dialog_ft2" onclick="closehyd()">取消</a> <input type="submit" value="确定"
						class="dxui_btn_dialog ">
				</div>
			</form>
	</div>
	<script src='js/jquery.min.js'></script>
	<script src="js/index.js"></script>
	<script src="js/dxba.js"></script>
	<script src="layer/layer.js"></script>
	
</body>
</html>
