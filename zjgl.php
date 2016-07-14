<?php
date_default_timezone_set('prc');
session_start();
//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['userid'])){
	header("Location:login.php");
	exit();
}
$userid = $_SESSION['userid'];
include('uploadImg.php');
if($_SERVER['REQUEST_METHOD']=='POST'){
	if (!is_uploaded_file($_FILES["photo"]['tmp_name'])){
		echo "<script>alert('请选择图片')</script>";
	}

	$zjlx=$_POST['cert_zjlx'];
	$zjsm=$_POST['zjsm'];
	$scsj = date('Y-m-d h:i:s',time());
	$year=((int)substr($scsj,0,4));
	$month=date("m");
	$wjjname=$year.$month;
	$path='/upload/file/'.$wjjname.'/'; //图片存放路径
	if(!is_dir($path1.$path)){//路径若不存在则创建
		mkdir($path1.$path,0700,true);
	}
	$upfile=$_FILES["photo"];
	$imgsize = $_FILES["photo"]['size'];
	$pinfo=path_info($upfile["name"]);
	$name=$pinfo['filename']."nw";//文件名
	$tmp_name=$upfile["tmp_name"];
	$file_type=$pinfo['extension'];//获得文件类型
	$showphpath=$path.$newname.".".$file_type;
	 
	if(in_array($upfile["type"],$phtypes)){
		echo "文件类型不符！";
		exit();
	}
	if(move_uploaded_file($tmp_name,$path1.$showphpath)){
		Img($path1.$showphpath,$imgsize,1);
		$stmt = $pdo -> prepare('INSERT INTO `rs_cert` (usrId,deleted,scsj,zjlx,bclj,zjsm) VALUES (?,?,?,?,?,?)');
		$stmt -> execute(array($userid,"0",$scsj,$zjlx,$showphpath,$zjsm));
		$sql="INSERT INTO `rs_cert` (deleted,usrId,scsj,zjlx,bclj,zjsm) VALUES ('0','$userid','$scsj','$zjlx','$showphpath','$zjsm')";
		$result = $stmt -> rowCount();		
		if($result){
			echo "<script>alert('上传成功！')</script>";
			echo "<script>history.go(-2);</script>";
		}
		//   mysqli_query($connection, $sql2);
	}
	
	//   echo "<img src=\"".$showphpath."\" />";
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
$zjlxstmt = $pdo->prepare('SELECT * FROM `sys_dict` WHERE type= ?');
$zjlxstmt -> execute(array("cert_zjlx"));

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>证件上传</title>
<!-- 引入 WeUI -->
<link rel="stylesheet" href="css/weui.css" />
<link rel="stylesheet" href="css/testcss.css" />
</head>
<body>
	<?php include('top.php')?>
	<div class="weui_cells_title">上传主体负责人的身份证信息</div>
	<div class="weui_cells weui_cells_form">
		<div class="weui_cell">
			<div class="weui_cell_bd weui_cell_primary">
				<div class="weui_uploader">
					<div class="weui_uploader_hd weui_cell">
						<div class="weui_cell_bd weui_cell_primary">示例:</div>
					</div>
					<div class="dx_uploader_bd">
						<img id="imgmb1" height="210px" src="" onclick="showmb(this)" style="display: none" /> 
						<img id="imgmb2" height="210px" src="" onclick="showmb(this)" style="display: none" /> 
					</div>

				</div>
			</div>
		</div>
	</div>

	<form id="upload_form" enctype="multipart/form-data" method="post"
		name="form1">

		<div class="weui_cells weui_cells_form">
			<div class="weui_cell">
				<div class="weui_cell_bd weui_cell_primary">
					<div class="weui_uploader">
						<div class="weui_uploader_hd weui_cell">
							<div class="weui_cell_hd">
								<label class="dx_label_second">上传证件类型<span style="color: red">*</span>
								</label>
							</div>
							<div>
								<select id="cert_zjlx" class="dx_slct" name="cert_zjlx" onchange="changemb()">
									<option value="1">请选择</option>
									<?php foreach ($zjlxstmt AS $zjlxrow):?>
									<option value="<?php echo $zjlxrow['value']?>"><?php echo $zjlxrow['name']?></option>
									<?php endforeach;?>
								</select>
							</div>
						</div>
						<div>
							<img src="" id="img0" width="310px" style="display: none">
						</div>
						<div>
							<div class="weui_uploader_input_wrp">
								<input class="weui_uploader_input" type="file" name="photo"
									id="upload" size="20" />
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd">
				<label class="dx_label">证件说明</label>
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<textarea class="weui_textarea" placeholder="请输入证件说明" name="zjsm"
					rows="3"></textarea>
			</div>
		</div>

		<div class="weui_btn_area">
			<input type="submit" value="上传" class="weui_btn dx_btn_primary" />
		</div>
		<div class="weui_btn_area">
			<input type="button" class="weui_btn dx_btn_primary"
				onclick="javascript:history.back(-1);" value="上一步">
		</div>
	</form>

	<script type="text/javascript" src='js/jquery.min.js'></script>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/dxba.js"></script>
	<script type="text/javascript" src="layer/layer.js"></script>
	<script>	
		$("#upload").change(function(){
			var objUrl = getObjectURL(this.files[0]) ;
			console.log("objUrl = "+objUrl) ;
			if (objUrl) {
				$("#img0").attr("src", objUrl) ;
				document.getElementById("img0").style.display="";
			}
		}) ;
		
		function getObjectURL(file) {
			var url = null ; 
			if (window.createObjectURL!=undefined) { // basic
				url = window.createObjectURL(file) ;
			} else if (window.URL!=undefined) { // mozilla(firefox)
				url = window.URL.createObjectURL(file) ;
			} else if (window.webkitURL!=undefined) { // webkit or chrome
				url = window.webkitURL.createObjectURL(file) ;
			}
			return url ;
		}
</script>
</body>
</html>
