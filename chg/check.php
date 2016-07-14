<?php
// if(!isset($_SERVER['HTTP_REFERER']))   {
// 	echo "<script>history.back(-1)</script>";
// 	exit;
// }
include('../conn.php');
$checkstmt = $pdo -> prepare('SELECT * FROM `rs_opt_state` WHERE usrId = ? AND czlx = ?');
$checkstmt -> execute(array($userid,"new"));
$checkrow = $checkstmt -> fetch();
if (!$checkstmt->rowCount() || $checkrow['czzt'] != 200) {
	echo "<script>history.back(-1)</script>";
}
?>