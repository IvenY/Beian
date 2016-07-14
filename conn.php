<?php
$pdo = new PDO('mysql:dbname=wrs_new;host=127.0.0.1;charset=utf8', 'root');
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>