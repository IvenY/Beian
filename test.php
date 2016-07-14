<?php 
$image = imagecreatefromstring(file_get_contents($_FILES['photo']['tmp_name']));
$exif = exif_read_data($_FILES['photo']['tmp_name']);
var_dump($exif);
if(!empty($exif['Orientation'])) {
	switch($exif['Orientation']) {
		case 8:
			$image = imagerotate($image,90,0);
			break;
		case 3:
			$image = imagerotate($image,180,0);
			break;
		case 6:
			$image = imagerotate($image,-90,0);
			break;
	}
}
echo $exif['Orientation'];
?>
<form id="upload_form" enctype="multipart/form-data" method="post"
				name="form1"  action="">
				<div class="dxui_dialog_bd" style="padding: 2em 1.5em 0">
					<input type="file" name="photo" id="upload" />
				</div>
				<div class="dxui_dialog_ft" style="padding-top: .7em">
					<a href="javascript:;" class="dxui_btn_dialog primary"
						id="dialog_ft2" onclick="closehyd()">取消</a> <input type="submit" value="确定"
						class="dxui_btn_dialog ">
				</div>
			</form>