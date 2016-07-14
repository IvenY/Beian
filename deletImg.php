<?php
session_start();

//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['userid'])){
	header("Location:login.php");
	exit();
}
$userid = $_SESSION['userid'];
include('conn.php');
if($_SERVER['REQUEST_METHOD']=="POST"){
	$id= $_POST['id'];
	$mkdm = $_GET['mkdm'];
	$stmt = $pdo->prepare('DELETE FROM `rs_usr_cert` WHERE certId = ? && mkdm = ?');
	$stmt -> execute(array($id,$mkdm));
	$result = $stmt -> rowCount();
	if($result)
		return true;
}else {
	echo "<script> alert('非法访问！')</script>";
}
?>