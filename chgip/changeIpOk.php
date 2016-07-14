<?php
session_start();

//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['userid'])){
	header("Location:login.php");
	exit();
}
$userid = $_SESSION['userid'];
$webid= $_POST['webid'];
include('../conn.php');
$stmt = $pdo -> prepare('SELECT * FROM `rs_site` WHERE id = ?');

$i=0;
if($_SERVER['REQUEST_METHOD']=="POST"){
	if (isset($_POST['submit'])) {
		$newip = $_POST['newip'];
		if($newip==""){
			echo "<script>alert('请填入新ip地址！');history.go(-1);</script>";
			exit();
		}
		$webid = $_POST['webselect'];
		$webstmt = $pdo -> prepare('UPDATE `rs_site` SET jrIp= ? WHERE id= ?');
		$webstmt -> execute(array($newip,$webid));
		$result = $webstmt -> rowCount();
		if($result)
			echo "<script>alert('更改成功！');history.go(-1);</script>";
	}else{
		$stmt -> execute(array($webid));
		$row = $stmt -> fetch();
		echo $row['jrIp'];
		// 	$newip = $_POST['newip'];
	}

}else{
	echo "<script>location.href='Infomanage.php'</script>";
}
?>