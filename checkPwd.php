<?php
session_start();
if(!isset($_SESSION['userid'])){
	header("Location:login.php");
	exit();
}
if(!isset($_SERVER['HTTP_REFERER']))   {
		echo "<script>history.back(-1)</script>";
		exit;
	}
$userid = $_SESSION['userid'];
include('conn.php');
$stmt = $pdo -> prepare('SELECT * FROM `rs_usr` WHERE id = ? limit 1');
$stmt -> execute(array($userid));
$row = $stmt -> fetch();
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$oPwd = $_POST['oPwd'];
	if($row['mm'] != sha1($oPwd))
		echo "pwdno";
	else{
		$yzm = $_POST['yzm'];
		if(md5($yzm) != $_SESSION['verification'])
			echo "yzmno";
	}
}
?>