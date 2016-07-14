
<?php
date_default_timezone_set('prc');
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
	$stmt3 -> execute(array($userid,$mkdm));
	$scsj = date('Y-m-d h:i:s',time());
	$year=((int)substr($scsj,0,4));
	$month=date("m");
	$wjjname=$year.$month;
	$path='/upload/file/'.$wjjname.'/'; //图片存放路径
	if(!is_dir($path1.$path)){//路径若不存在则创建
		mkdir($path1.$path,0700,true);
	}
	$upfile=$_FILES["photo"];
	$pinfo=path_info($upfile["name"]);
	$name=$pinfo['filename'];//文件名
	$newname=md5("curtainphoto".$mkdm.$name);
	$tmp_name=$upfile["tmp_name"];
	$file_type=$pinfo['extension'];//获得文件类型
	$showphpath=$path.$newname.".jpg";
	if(in_array($upfile["type"],$phtypes)){
		echo "文件类型不符！";
		exit();
	}
	if(move_uploaded_file($tmp_name,$path1.$showphpath)){
		Img($showphpath,390,250,2);
		mysqli_query($connection,"set names ’utf8’ ");
		if(!$row=$stmt3 -> fetch()){
			$stmt = $pdo -> prepare('INSERT INTO `rs_curtain_photo` (mkdm,usrId,scsj,bclj) VALUES (?,?,?,?)');
			$stmt -> execute(array($mkdm,$userid,$scsj,$showphpath));
		}else{
			$stmt = $pdo -> prepare('UPDATE `rs_curtain_photo` SET bclj=? WHERE usrId=? && mkdm = ?');
			$stmt -> execute(array($showphpath,$userid,$mkdm));
		}
	}
}
$stmt3 -> execute(array($userid,$mkdm));
$row = $stmt3 -> fetch();
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
<title>上传照片</title>

<!-- 引入 WeUI -->
<link rel="stylesheet" href="css/weui.css" />
<link rel="stylesheet" href="css/testcss.css" />


</head>
<body>
	<?php include('top.php')?>
	<div class="weui_cells_title">首页/新增备案/上传照片</div>
	<div class="dx_title">
		上传照片<a href="javascript:;" class="weui_btn dx_btn_mini"
			onclick="curtainPhoto('<?php echo $mkdm?>')">上传照片</a>
	</div>
	<div>
		<img
			src="<?php if($row['id']) echo "test2.php?id= ".$row['id']."&lx=curtain"?>"
			id="img0" width="375" >
	</div>
	<div id="lookdiv" class="dxui_dialog_alert" style="display: none">
		<div class="dxui_dialog">
			<div class="dxui_dialog_hd">
				<strong>上传照片</strong><a style="margin-left: 10px; color: red;">注意：重新上传将覆盖已上传的照片</a>
			</div>
			<form id="upload_form" enctype="multipart/form-data" method="post"
				name="form1">
				<div class="dxui_dialog_bd">
					<input type="file" name="photo" id="upload" />
				</div>
				<div class="dxui_dialog_ft">
					<a href="javascript:;" class="dxui_btn_dialog primary"
						id="dialog_ft">取消</a> <input type="submit" value="确定"
						class="dxui_btn_dialog ">
				</div>
			</form>

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
	<script type="text/javascript" src="js/dxba.js"></script>
	<script type="text/javascript" src="js/index.js"></script>
	<script type="text/javascript" src="layer/layer.js"></script>
</body>
</html>
