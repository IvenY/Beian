<?php
	$path = "D:wrs/";
	$filename ="doox.docx";
	ob_clean();
	header("Content-Type: application/force-download");
	header('Content-Disposition: attachment; filename="'.$filename.'"'); //指定下载文件的描述
	header('Content-Length:'.filesize($path.$filename)); //指定下载文件的大小
// 	将文件内容读取出来并直接输出，以便下载
	echo readfile($path.$filename);
// }

?>