function closehyd(){
	var index = parent.layer.getFrameIndex(window.name);
	parent.layer.close(index);
}
function opendiv(mkdm){
	layer.open({
        type: 2,
        title: '上传核验单',
        area: ['98%', '260px'],
        shadeClose: false, //点击遮罩关闭
        content: 'uphyd.php?mkdm='+mkdm,
        });
}
function lookimg(url,zjlx){
	document.getElementById("dialog_hd").innerHTML=zjlx;
	document.getElementById("look").src=".."+url;
	document.getElementById("lookdiv").style.display="";
}

//	var dialog_hd = document.getElementById("dialog_hd");
//	if(dialog_hd)
//		dialog_hd.innerHTML=zjlx;
//	document.getElementById("look").src="../Beian"+url;
//	document.getElementById("lookdiv").style.display="";
function removeimg(id,mkdm){
		$.ajax({
			type : 'POST',
			url : 'deletImg.php?mkdm='+mkdm,
			data : "id=" + id,
			success : function() {
				window.location.reload(true);
			} // 显示操作提示
		});
}
function delimg(id){
	$.ajax({
		type : 'POST',
		url : 'cert1.php',
		data : "id=" + id,
		success : function() {
			window.location.reload(true);
		} // 显示操作提示
	});
}
function lookhyd(url){
	document.getElementById("dialog_hd").innerHTML="查看核验单";
	document.getElementById("look").src=".."+url;
	document.getElementById("lookdiv").style.display="";
}
function lookhyd2(url){
	document.getElementById("dialog_hd").innerHTML="查看核验单";
	document.getElementById("look").src="../Beian"+url;
	document.getElementById("lookdiv").style.display="";
}
function changing(){
    document.getElementById('checkpic').src="checkcode.php?"+Math.random();
} 
function curtainPhoto(mkdm) {
	layer.open({
        type: 2,
        title: '上传照片',
        area: ['380px', '200px'],
        shadeClose: false, //点击遮罩关闭
        content: 'upCurtainPhoto.php?mkdm='+mkdm,
        });
}
