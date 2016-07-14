<?php
	$statestmt = $pdo -> prepare('SELECT * FROM `rs_opt_state` WHERE usrId = ? && czlx = ?');
	$statestmt -> execute(array($userid,$mkdm));
	$statrow = $statestmt -> fetch();
	if ($statrow['czzt'] > $czzt) {
		echo "<script>alert('当前状态不能操作！')</script>";
		echo "<script>history.go(-1)</script>";
		exit();
	}
?>