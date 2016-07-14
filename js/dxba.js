var text1, text2;
function checkzt(czzt){
	if(czzt != 200)
		alert("当前没有已经成功的备案信息可供变更！");
	else
		window.location.href = "chg/chgZt.php";
}

function getproTextVal(_text) {
	text1 = _text;
}
function getcityTextVal(_text) {
	text2 = _text;

}
function setdzTextVal(_text) {
	if (typeof (text2) != "undefined")
		document.getElementById("dz").value = text1 + text2 + _text;
	else
		document.getElementById("dz").value = text1 + _text;

}
function setidTextVal(id, _text) {
	document.getElementById(id).value = _text;

}

var i = 0;
var j = 0;
function show() {
	if (i % 2 == 0) {
		document.getElementById("fwnr").style.display = "";
	} else {
		document.getElementById("fwnr").style.display = "none";
	}
	i++;
}
function show2() {
	if (j % 2 == 0) {
		document.getElementById("yylb").style.display = "";
	} else {
		document.getElementById("yylb").style.display = "none";
	}
	j++;
}
function cancel(zt, mkdm) {
	if (zt != 100 && zt != 101) {
		alert("当前状态下不能撤销！");
	} else {
		if (confirm("您确定要撤销吗？ "))
			$.ajax({
				type : 'POST',
				url : mkdm + '.php',
				data : "zt=" + '100',
				success : function() {
					alert("撤销成功！");
					window.location.reload(true);
				} // 显示操作提示
			});
	}
}
function submitInfo(zt, mkdm) {
	if (zt != 101 && zt != 103 && zt != 110 && zt != 112) {
		alert("当前状态下不能提交！");
	} else {
		if (confirm("您确定要提交吗？ ")) {
			$.ajax({
				type : 'POST',
				url : mkdm + '.php',
				data : "zt=" + zt,
				success : function() {
					alert("提交成功，请耐心等候！");
					window.location.reload(true);
				} // 显示操作提示
			});
		}

	}
}
function changeds(jrs) {
	if (jrs != "zgdx") {
		alert("接入商不是中国电信，不能变更！");
		location.href = "changeds.php";
	} else {
		alert("接入商是中国电信，可以变更！");
		location.href = "changeds.php";
	}
}
function showIp() {
	var webselect = document.getElementById("webselect");
	webid = webselect.value;
	$.ajax({
		type : 'POST',
		url : 'changeIpOk.php',
		data : "webid=" + webid,
		success : function(msg) {
			document.getElementById("oldip").innerText = msg;
		} // 显示操作提示
	});
}
function showmore(id) {
	var checkbox = document.getElementById(id);//
	if (checkbox.checked) {
		document.getElementById("yzjfzd").style.display = "";
		document.getElementById("sfygssl").style.display = "";
	} else {
		document.getElementById("yzjfzd").style.display = "none";
		document.getElementById("sfygssl").style.display = "none";
	}
}
function InputCheck(LoginForm) {
	if (LoginForm.username.value == "") {
		alert("请输入用户名!");
		LoginForm.username.focus();
		return (false);
	}
	if (LoginForm.password.value == "") {
		alert("请输入密码!");
		LoginForm.password.focus();
		return (false);
	}
}
function RegCheck(regForm) {
	var regun = /^[\w\x80-\xff]{6,15}$/;
	var regdzyx = /^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[-_a-z0-9][-_a-z0-9]*\.)*(?:[a-z0-9][-a-z0-9]{0,62})\.(?:(?:[a-z]{2}\.)?[a-z]{2,})$/i;
	var un = regForm.username.value;
	var dzyx = regForm.dzyx.value;
	var flag = true;
	$.ajax({
		type : 'POST',
		async:false, 
		url : 'regCheck.php',
		data : {"checkpic" :regForm.checkpic.value,"username":regForm.username.value},
		success:function(msg) {
			if(msg == "dlmno"){
				alert('用户名已存在！');
				regForm.username.focus();
				flag = false;
			}else if(msg == "yzmno"){
				alert('验证码输入错误！');
				regForm.checkpic.focus();
				flag = false;
			}
		}
	});
	if(!flag)
		return false;
	if (!regun.exec(un)) {
		alert("用户名不符合规定!");
		regForm.username.focus();
		return false;
	}
	if (regForm.password.value.length < 8) {
		alert("密码长度不符合规定！");
		regForm.password.focus();
		return false;
	}
	if (regForm.password.value != regForm.password2.value) {
		alert("两次密码不相等！");
		regForm.password2.focus();
		return false;
	}
	if (!regdzyx.test(dzyx)) {
		alert("电子邮箱格式错误！");
		regForm.dzyx.focus();
		return false;
	}

}
function changePwdCheck(changeForm) {
	var flag = true;
	if (changeForm.oPwd.value == "") {
		alert("请输入旧密码!");
		changeForm.oPwd.focus();
		return (false);
	}
	$.ajax({
		type : 'POST',
		async:false, 
		url : 'checkPwd.php',
		data : {"oPwd" :changeForm.oPwd.value,"yzm":changeForm.checkpic.value},
		success:function(msg) {
			if(msg == "pwdno"){
				alert('旧密码输入有误，请重新输入！');
				changeForm.oPwd.focus();
				flag = false;
			}else if(msg == "yzmno"){
				alert('验证码输入错误！');
				changeForm.checkpic.focus();
				flag = false;
			}
		}
	});
	if(!flag)
		return false;
	if (changeForm.nPwd.value.length < 8) {
		alert("密码长度不符合规定！");
		changeForm.nPwd.focus();
		return false;
	}
	if (changeForm.nPwd.value == "") {
		alert("请输入新密码!");
		changeForm.nPwd.focus();
		return (false);
	}
	if (changeForm.rPwd.value == "") {
		alert("请再次输入新密码!");
		changeForm.rPwd.focus();
		return (false);
	}
	if(changeForm.nPwd.value != changeForm.rPwd.value){
		alert("两次密码不相等");
		changeForm.rPwd.focus();
		return (false);
	}
}
function entryCheck(entryForm) {
	var zzbgdh = /^((086)-)((0\d{2,3})-)(\d{7,8})?$/;
	var bgdh = entryForm.bgdh.value;
	if (!zzbgdh.exec(bgdh)) {
		alert("电话格式不正确!");
		entryForm.bgdh.focus();
		return false;
	}
}

function zbzjlxChange() {
	var xz = document.getElementById("xz");
	var zbzjlx = document.getElementById("zbzjlx");
	zbzjlx.options.length = 0;
	zbzjlx.options.add(new Option("请选择", "0"));
	if (xz.value == "jd")
		zbzjlx.options.add(new Option("军队代号", "jddh"));
	else if (xz.value == "zfjg")
		zbzjlx.options.add(new Option("组织机构代码证", "zzjgdmz"));
	else if (xz.value == "sydw") {
		zbzjlx.options.add(new Option("组织机构代码证", "zzjgdmz"));
		zbzjlx.options.add(new Option("事业法人证", "syfrz"));
	} else if (xz.value == "qy") {
		zbzjlx.options.add(new Option("组织机构代码证", "zzjgdmz"));
		zbzjlx.options.add(new Option("工商营业执照", "gsyyzz"));
	} else if (xz.value == "gr") {
		zbzjlx.options.add(new Option("身份证", "sfz"));
		zbzjlx.options.add(new Option("护照", "hz"));
		zbzjlx.options.add(new Option("军官证", "jgz"));
		zbzjlx.options.add(new Option("台胞证", "tbz"));
	} else if (xz.value == "shtt") {
		zbzjlx.options.add(new Option("组织机构代码证", "zzjgdmz"));
		zbzjlx.options.add(new Option("社团法人证", "stfrz"));
	}
}
function fbentry() {
	alert("当前状态不能录入！");
}
function ifUpzj(num, mkdm) {
	if (num) {
		layer.open({
			type : 2,
			title : '证件管理',
			area : [ '98%', '17em' ],
			shadeClose : false, // 点击遮罩关闭
			content : 'choosezj.php?mkdm=' + mkdm
		});
	} else if (confirm("当前没有证件可选择，需要上传吗？"))
		window.location.href = "cert1.php?mkdm=" + mkdm;
}
function upzj(zjid, mkdm) {
	$.ajax({
		type : 'POST',
		url : 'choosezj.php?mkdm=' + mkdm,
		data : "zjid=" + zjid,
		success : function() {
			// alert("成功");
			var index = parent.layer.getFrameIndex(window.name);
			parent.location.reload();
			parent.layer.close(index);
		} // 显示操作提示
	});
}
function tozjgl() {
	var index = parent.layer.getFrameIndex(window.name);
	parent.location.href = "zjgl.php";
	parent.layer.close(index);
}
function lookimg2(id, zjlx) {
	var lx = "cert";
	if (zjlx == "查看核验单")
		lx = "hyd";
	if (id)
		layer.open({
			type : 1,
			title : zjlx,
			area : [ '98%', '300px' ],
			shadeClose : true, // 点击遮罩关闭
			content : '<img id="look" width="380" src='
					+ 'test2.php?id=' + id + '&lx=' + lx + '>'
		});
	else 
		alert("当前并无核验单，请上传！")
}
function lookdiv(id) {
	document.getElementById("look").src = "test2.php?id=" + id + "&lx=cert";
	document.getElementById("lookdiv").style.display = "";
}
function closediv() {
	document.getElementById("lookdiv").style.display = "none";
}
function changemb(){
	var sr;
	var sr2;
	var img1 = document.getElementById("imgmb1");
	var img2 = document.getElementById("imgmb2");
	var name = document.getElementById("cert_zjlx").value;
		if(name == "ztfzrsfz"){
			if(img2.style.display == "")
				img2.style.display = "none";
			sr = "images/ztfzrsfz.jpg";
		}
		else if(name == "wzfzrsfz"){
			if(img2.style.display == "")
				img2.style.display = "none";
			sr = "images/wzfzrsfz.jpg";
		}
		else if(name == "zsxhyd"){
			if(img2.style.display == "")
				img2.style.display = "none";
			sr = "images/hyd.png";
		}
		else if (name == "yyzzhjgdmz") {
			sr = "images/zzjgdmz.jpg";
			sr2 = "images/gsyyzz.png";
			img2.src = sr2;
			img2.style.display = "";
		}
		img1.src = sr;
		if(img1.style.display == "none")
			img1.style.display = "";
		
}
function showmb(img) {
	src = img.src;
	layer.open({
		type : 1,
		title : "证件模板",
		area : [ '98%', '300px' ],
		shadeClose : true, // 点击遮罩关闭
		content : '<img id="look" width="380" src='+src+'>'
	});
}

var phoneWidth =  parseInt(window.screen.width);
var phoneScale = phoneWidth/375;
var ua = navigator.userAgent;
if (/Android (\d+\.\d+)/.test(ua)){
    var version = parseFloat(RegExp.$1);
    if(version>2.3){
        document.write('<meta name="viewport" content="width=375, minimum-scale = '+phoneScale+', maximum-scale = '+phoneScale+', target-densitydpi=device-dpi">');
    }else{
        document.write('<meta name="viewport" content="width=375, target-densitydpi=device-dpi">');
    }
} else {
    document.write('<meta name="viewport" content="width=375, user-scalable=no, target-densitydpi=device-dpi">');
}
