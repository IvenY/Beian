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
$username = $_POST['username'];
$yzm = $_POST['checkpic'];
$stmt = $pdo -> prepare('SELECT * FROM `rs_usr` WHERE dlm = ? limit 1');
$stmt -> execute(array($username));
$result = $stmt -> rowCount();
if($_SERVER['REQUEST_METHOD'] == "POST"){
	if($result)
		echo "dlmno";
	else{
		if(md5($yzm) != $_SESSION['verification'])
			echo "yzmno";
	}
}
?>