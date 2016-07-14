<?php
session_start();
if(!isset($_SERVER['HTTP_REFERER']))   {
	echo "<script>history.back(-1)</script>";
	exit;
}
//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['userid'])){
	header("Location:login.php");
	exit();
}
$mkdm = "new";
$version = "0";
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$cjsj = date('y-m-d h:i:s',time());
$gxsj = date('y-m-d h:i:s',time());
$mc = $_POST['mc'];
$zbdwzjlx = $_POST['zbdwzjlx'];
$xz = $_POST['xz'];
$dz = $_POST['dz'];
$zjhm = $_POST['zjhm'];
$zjzs = $_POST['zjzs'];
$txdz = $_POST['txdz'];
$tzzhsjzgdw = $_POST['tzzhsjzgdw'];

$xm = $_POST['xm'];
$per_zjlx = $_POST['per_zjlx'];
$per_zjhm = $_POST['per_zjhm'];
$per_dzyx = $_POST['per_dzyx'];
$bgdh = $_POST['bgdh'];
$per_sjhm = $_POST['per_sjhm'];
$msn = $_POST['msn'];
$qq = $_POST['qq'];
$bz = $_POST['bz'];
//包含数据库连接文件
include('conn.php');
//判断数据是否存在
$ifstmt = $pdo -> prepare('SELECT * FROM `rs_host_org` WHERE usrId = :usrId');
$ifstmt -> execute(array('usrId' => $userid)) ;
$ifresult = $ifstmt -> fetch();
$stmt = $pdo -> prepare('INSERT INTO `rs_host_org` (mkdm,version,usrId,cjsj,gxsj,mc,xz,dz,zjlx,zjhm,zjzs,txdz,tzzhsjzgdw)
VALUES (:mkdm,:version,:usrId,:cjsj,:gxsj,:mc,:xz,:dz,:zbdwzjlx,:zjhm,:zjzs,:txdz,:tzzhsjzgdw)');
$stmt2 = $pdo -> prepare('INSERT INTO `rs_per_in_chc` (mkdm,version,usrId,cjsj,gxsj,xm,zjlx,zjhm,dzyx,bgdh,sjhm,msn,qq,bz)
VALUES (:mkdm,:version,:usrId,:cjsj,:gxsj,:xm,:per_zjlx,:per_zjhm,:per_dzyx,:bgdh,:per_sjhm,:msn,:qq,:bz)');
$updtstmt = $pdo -> prepare('UPDATE `rs_host_org` SET gxsj=:gxsj,mc=:mc,xz=:xz,dz=:dz,zjlx=:zbdwzjlx,zjhm=:zjhm,zjzs=:zjzs,txdz=:txdz,tzzhsjzgdw=:tzzhsjzgdw WHERE usrId = :usrId');
$updtstmt2 = $pdo -> prepare('UPDATE `rs_per_in_chc` SET gxsj=:gxsj,xm=:xm,zjlx=:per_zjlx,zjhm=:per_zjhm,dzyx=:per_dzyx,bgdh=:bgdh,sjhm=:per_sjhm,msn=:msn,qq=:qq,bz=:bz WHERE usrId = :usrId');

if($ifresult){
	$result = $updtstmt -> execute(array('gxsj'=>$gxsj,'mc'=>$mc,'xz'=>$xz,'dz'=>$dz,'zbdwzjlx'=>$zbdwzjlx,'zjhm'=>$zjhm,'zjzs'=>$zjzs,'txdz'=>$txdz,'tzzhsjzgdw'=>$tzzhsjzgdw,'usrId'=>$userid));
	$result2 = $updtstmt2 -> execute(array('gxsj'=>$gxsj,'xm'=>$xm,'per_zjlx'=>$per_zjlx,'per_zjhm'=>$per_zjhm,'per_dzyx'=>$per_dzyx,'bgdh'=>$bgdh,'per_sjhm'=>$per_sjhm,'msn'=>$msn,'qq'=>$qq,'bz'=>$bz,'usrId'=>$userid));
}else {
	$result = $stmt -> execute(array('mkdm'=>$mkdm,'version'=>$version,'usrId' =>$userid,'cjsj'=>$cjsj,'gxsj'=>$gxsj,'mc'=>$mc,'xz'=>$xz,'dz'=>$dz,'zbdwzjlx'=>$zbdwzjlx,'zjhm'=>$zjhm,'zjzs'=>$zjzs,'txdz'=>$txdz,'tzzhsjzgdw'=>$tzzhsjzgdw));
	$result2 = $stmt2 -> execute(array('mkdm'=>$mkdm,'version'=>$version,'usrId' =>$userid,'cjsj'=>$cjsj,'gxsj'=>$gxsj,'xm'=>$xm,'per_zjlx'=>$per_zjlx,'per_zjhm'=>$per_zjhm,'per_dzyx'=>$per_dzyx,'bgdh'=>$bgdh,'per_sjhm'=>$per_sjhm,'msn'=>$msn,'qq'=>$qq,'bz'=>$bz));
}
if($result && $result2){
	echo "<script>window.location= 'Infoshow.php';</script>";
}else{
	echo '抱歉！添加数据失败：.<br />';
	echo '点击此处 <a href="javascript:history.back(-1);">返回</a> 重试';
}
?>