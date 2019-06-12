var phoneWidth =  parseInt(window.screen.width);
var phoneScale = phoneWidth/640;
var ua = navigator.userAgent;
if (/Android (\d+\.\d+)/.test(ua)){
	var version = parseFloat(RegExp.$1);
	if(version>2.3){
		document.write('<meta name="viewport" content="width=640, minimum-scale = '+phoneScale+', maximum-scale = '+phoneScale+', target-densitydpi=device-dpi">');
	}
	else{
		document.write('<meta name="viewport" content="width=640, target-densitydpi=device-dpi">');
	}
}
else {
document.write('<meta name="viewport" content="width=640, user-scalable=yes, target-densitydpi=device-dpi">');
}

function login_form(){
    var username= $('#username').val();
    var password= $('#password').val();
    if(username.length==0){
        alert('账号不能为空！');
        return false;
    }
    if(password.length==0){
        alert('密码不能为空！');
        return false;
    }
}