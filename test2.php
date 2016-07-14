<?php
ini_set("display_errors", "off");
session_start();
$userid = $_SESSION['userid'];
//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['userid'])){
	header("Location:login.php");
	exit();
}
ob_clean();
// header( "Content-type: image/jpeg");
$id = $_GET['id'];
$lx = $_GET['lx'];

if($id && $lx){
	include('conn.php');
	
	if($lx == "cert")
		$stmt = $pdo -> prepare('SELECT * FROM `rs_cert` WHERE id = ? AND usrId = ? limit 1');
	else if($lx == "hyd")
		$stmt = $pdo -> prepare('SELECT * FROM `rs_usr_ver_bill` WHERE id = ? AND usrId = ? limit 1');
	else if($lx == "curtain")
		$stmt = $pdo -> prepare('SELECT * FROM `rs_curtain_photo` WHERE id = ? AND usrId = ? limit 1');
	$stmt -> execute(array($id,$userid));
	$row = $stmt -> fetch();
	if($row){
		$url = $row['bclj'];
		$urlinfo = pathinfo($url);
		$type = $urlinfo['extension'];
		header( "Content-type: image/$type");
		$path = "D:wrs/";
		$PSize = filesize($path.$url);
		$handle = fopen($path.$url, "r");
		$picturedata = fread($handle, $PSize);
		echo $picturedata;
		fclose($handle);
	}
	
}else {
	echo "<script>alert('图片不存在！')</script>
		  <script>history.back(-1);</script>";
}

// $PSize = filesize($path.$url);
// $handle = fopen($path.$url, "r");
// $picturedata = fread($handle, $PSize);
// echo $picturedata;
// fclose($handle)
?>

