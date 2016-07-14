<?php
$pdo = new PDO('mysql:dbname=wrs_new;host=127.0.0.1;charset=utf8', 'root');
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $pdo->prepare('SELECT * FROM rs_opt_state WHERE usrId = :id');
$id = "190";
$result = $stmt->execute(array('id' => $id));
$xzstmt = $pdo -> prepare('SELECT * FROM `sys_dict` WHERE id = ?');
$result = $xzstmt -> execute(array("180"));
$ifstmt2 = $pdo -> prepare('SELECT * FROM `rs_usr_cert` WHERE certId = ? limit 1 ');
$ifstmt2 -> execute(array("100"));
$ifresult = $ifstmt2 -> rowCount();
echo $ifresult;
?>