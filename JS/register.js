
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

/**
 * 全局变量定义
 */
var choose="phone";     //预设方式
var isemail="";         //邮箱
var isphoen="";         //电话
var result = "adminadminadmin";        //返回来的验证码,预先设定一个初始值
var state = true;				//定时器允许标志
var allowsendpm = true;			//用户条款是否允许发送数据请求
var allowsendpm1 = false;		//用户密码格式是否允许发送数据请求
var allowsendpm2 = true;		//重复用户名是否允许发送数据请求
var allowsendpm3 = true;        //综合判定结果是否允许发送数据请求

/*
用户注册方式的选择
可使用电话号码注册
也可使用邮箱注册
默认使用电话号码
*/
function Registration_mode1(){
    document.getElementById("phone").style.backgroundColor="#44a8e0";
    document.getElementById("phone").style.color="#ffffff";
    document.getElementById("E-mail").style.backgroundColor="#ffffff";
    document.getElementById("E-mail").style.color="#000000";
    document.getElementById("em").innerHTML="电话";
    document.getElementById("email").setAttribute("placeholder","请输入电话");
	$('#email').focus();
    choose="phone";
    Choose();
}

function Registration_mode2(){
    document.getElementById("phone").style.backgroundColor="#ffffff";
    document.getElementById("phone").style.color="#000000";
    document.getElementById("E-mail").style.backgroundColor="#44a8e0";
    document.getElementById("E-mail").style.color="#ffffff";
    document.getElementById("em").innerHTML="邮箱";
    document.getElementById("email").setAttribute("placeholder","请输入邮箱");
	$('#email').focus();
    choose="E-mail";
    Choose();
}
/*
    Form表单
    检查表单提交数据是否符合要求
    邮箱格式是否正确
    两次密码是否相同
    邮箱验证码是否正确
*/
function validate_form(){

    var email = $('#email').val().trim()
    var emailVer = $('#email-verify').val().trim()
    var userpass = $('#userpass').val().trim()
    var userpassCon = $('#userpassCon').val().trim()

    if(email.trim() == ""&&userpass.trim() == ""&&userpassCon.trim()==""){
        $("#span1,#span2,#span3,#span4").html("*").css('color','#F00');
        $("#icon").html("&#xe72b;");
        $("#deal").html(" * 为必填字段！");
        call();
        allowsendpm3 = false;
        return;
    }
    if(result=="adminadminadmin"){
        $("#icon").html("&#xe72b;");
        $("#deal").html("请先获取验证码!");
        call();
        allowsendpm3 = false;
        return;
    }
    if(emailVer.trim()==""){
        $("#icon").html("&#xe72b;");
        $("#deal").html("请输入您收到的邮箱验证码!");
        call();
        allowsendpm3 = false;
        return;
    }
    if(emailVer.trim()!=result){
        $("#icon").html("&#xe72b;");
        $("#deal").html("验证码错误!");
        call();
        allowsendpm3 = false;
        return;
    }
    if(!allowsendpm1){		//如果不允许发送则返回false
		$("#icon").html("&#xe72b;");
        $("#deal").html("密码格式有误！由6 - 16位字母和数字组成");
        allowsendpm3 = false;
        return;
    }
    if(userpass.trim() != userpassCon.trim()){
        $("#icon").html("&#xe72b;");
        $("#deal").html("确认密码与新密码不一致，请重新输入!");
        document.getElementById("userpassCon").focus();
        call();
        allowsendpm3 = false;
        return;
    }
	if(!allowsendpm){		//如果不允许发送则返回false
		$("#icon").html("&#xe72b;");
        $("#deal").html("请同意用户条款！");
        allowsendpm3 = false;
        return;
    }
    if(allowsendpm3){
        $.ajax({
            type:"POST",
            url:"./php/register.php",
            data: {email:email.trim(),userpass:userpass.trim()},//前面是数据名，后面是数据值，注意格式严格要求
            dataType:"json",        //数据类型json
            async:true,             //同步还是一步，false是同步，true是异步
            success:function(data){
                if(data.result){
                    $('#ic').html("&#xe730;").css('color','#006000');
                    $('#wz').html("注册成功，即将转到登陆").css('color','#006000');
                    $('#div').fadeIn();//显示
                    html();
                }
                else{
                    var a;
                    if(!data.error){a = ':该账户已注册';}
                    else{a = ',请稍后再试';}
                    $('#ic').html("&#xe735;").css('color','#f00');
					$('#wz').html("注册失败"+a).css('color','#f00');
					$('#div').fadeIn();
					Hide();
                }
            }
        });
    }
}

/*
    判断用户是否同意了服务协议
    如果不同意则不可提交注册
    同意则允许提交注册
*/
function disable(){ /*不同意协议 */
    allowsendpm = false; //用户不同意则把deal变量赋值为f表示false不同意
}
function enable(){  /*同意协议 */
    allowsendpm = true;
    $("#deal").html(""); //当用户勾选同意条款时去除提示
    $("#icon").html("");
}

/**
 * 判断Email格式是否正确
 */
function isEmail(){
    isemail = document.getElementById("email").value;
    if (isemail.length == 0){
        return false;
    }
    var index1 = isemail.indexOf("@");
    var index2 = isemail.indexOf(".");
    if (index1 < 1 || index2 < index1 || index2+4 < isemail.length){
        $("#span1").html("");
    }
    else{
        $("#span1").html("&#xe7e3;");
        $("#span1").css("color","#1afa29");

    }
}

/**
 * 判断电话格式是否正确
 */
function isPhoen(){
    isphoen = document.getElementById("email").value;
    var index1 = isphoen.indexOf("1");

    if (index1 > 0||isphoen.length!=11){
        $("#span1").html("");
    }
    else{
        $("#span1").html("&#xe7e3;");
        $("#span1").css("color","#1afa29");

    }
}
/**
 * 判断验证码是否相同
 */
function verification(){
    var emailverify=$("#email-verify").val();
    if(emailverify.length>=6){
        if(emailverify==result){
            $("#span2").html("&#xe7e3;");
            $("#span2").css("color","#1afa29");
        }
        else{
            $("#span2").html("");
        }
    }
}

/**
 * 判断密码格式
 */
function password(){
    var reg = /^(?=.*[a-zA-Z])(?=.*\d)/;
    var user = $("#userpass").val().trim();
    if(user.length>=6){
       if(reg.test(user)){
            $("#span3").html("&#xe7e3;");
            $("#span3").css("color","#1afa29");
            allowsendpm1 = true;
        }
        else{
            allowsendpm1 = false;
            $("#span3").html("");
        }
    }
	if($("#userpass").val().length<6){	
        allowsendpm1 = false;
        $("#span3").html("");
	}
}

/**
 * 判断两次密码是否相同
 */
function verifypwd(){
	if(allowsendpm1){
		var verifypwd1=$("#userpass").val();
		var verifypwd2=$("#userpassCon").val();
		if(verifypwd1.length!=0){
			if(verifypwd1==verifypwd2){
				$("#span4").html("&#xe7e3;");
				$("#span4").css("color","#1afa29");
			}
			else{
				$("#span4").html("");
			}
		}
	}
}

/**
 * 邮箱验证或者手机验证码倒计时
*/
var int;        //先定义一个空变量用存下面的定时
var NUM=60;     //定义一个全局变量存放定时多少秒
function Activate(){
	if($('#email').val()==''){
        $('#ic').html("&#xe735;").css('color','#f00');
		$('#wz').html("请输入正确的帐号").css('color','#f00');
		$('#div').fadeIn();
		Hide();
    }
	else{
		if(state){
		    num=NUM;
			int=setInterval(function(){clock();},1000);
			if(choose=="phone"){
				if(!allowsendpm2){		//如果不允许发送则返回false
					clearInterval(int);
					$("bt2").html("发送验证码");
					$('#ic').html("&#xe735;").css('color','#f00');
					$('#wz').html("该用户已被注册!").css('color','#f00');
					$('#div').fadeIn();
					Hide();
					return false;
				}
				else{
					SendPhoneAjax();//调用Ajax异步发送电话数据请求
				}
			}
			if(choose=="E-mail"){
				if(!allowsendpm2){		//如果不允许发送则返回false
					clearInterval(int);
					$("bt2").html("发送验证码");
					$('#ic').html("&#xe735;").css('color','#f00');
					$('#wz').html("该用户已被注册!").css('color','#f00');
					$('#div').fadeIn();
					Hide();
					return false;
				}
				else{
					SendEmailAjax();//调用Ajax异步发送邮件数据请求
				}
			}
		}
		else{
			$('#ic').html("&#xe735;").css('color','#f00');
            $('#wz').html("发送失败,请"+num+'秒后从新发送').css('color','#f00');
            $('#div').fadeIn();
            Hide();
		}
	}

	function clock(){
		num > 0 ?num--:clearInterval(int);
		if(num==0){
			$("#bt2").attr("value","发送验证码");
			state = true;
		}
		else{
			$("#bt2").attr("value","重新发送("+num+")s")
			state = false;
		}
	}
}

/**
 * 根据用户选择的注册方式监听input输入的账号是否符合格式要求
 */
function Choose(){
    $('#div').hide();   //隐藏弹窗
	SelectUser();
    if(choose=="phone"){
        isPhoen();
    }
    if(choose=="E-mail"){
        isEmail();
    }    
}

/**
 * 取消显示的方法可反复调用
 */
function call(){
    intt = setTimeout(function(){
        $("#icon").html("");
        $("#deal").html("");
    },2500);
}
/**
 * 隐藏弹窗时间
 */
function Hide(){
    setTimeout(function(){
        $('#div').fadeOut(400);
    },2500)
}
/**
 * 注册成功跳转主页函数
 */
function html(){
    var user = $('#email').val()
    var pwd = $('#userpass').val()
    num = 3;
    setTimeout(function(){
        result = "adminadminadmin";
        $('#div').fadeOut(400);
        $('#email').val('').focus();
        $('#email-verify').val('');
        $('#userpass').val('');
        $('#userpassCon').val('');
        $("#span1,#span2,#span3,#span4").html("");
        window.location.href='../login.php?user='+user+'&pwd='+pwd;
    },3000)
}
/**
 * 限制输入空格
 */
function astrict(){
    
}
/**
 * 发送短信验证码
 */
function SendPhoneAjax(){
    var urlphone = $("#email").val();
    $.ajax({
        type:"POST",
        url:"./php/Sendverification.php",
        data: {phone:urlphone.trim()},//前面是数据名，后面是数据值，注意格式严格要求
        dataType:"json",        //数据类型json
        async:true,             //同步还是一步，false是同步，true是异步
        success:function(data){
            if(data.res){
                $('#ic').html("&#xe730;").css('color','#006000');
                $('#wz').html("发送成功，请勿刷新页面!").css('color','#006000');
                $('#div').fadeIn();//显示
                Hide();
            }
            else{
                $('#ic').html("&#xe735;").css('color','#f00');
                $('#wz').html("发送失败").css('color','#f00');
                $('#div').fadeIn();
                Hide();
                clearInterval(int);
                $("bt2").html("发送验证码");
            }
            result= data.aray;
        }
    });
}
/**
 * 发送邮件验证码
 */
function SendEmailAjax(){
    var urlemail = $("#email").val();
    $.ajax({
        type:"POST",
        url:"./php/email.php",
        data: {email:urlemail.trim()},//前面是数据名，后面是数据值，注意格式严格要求
        dataType:"json",        //数据类型json
        async:true,             //同步还是一步，false是同步，true是异步
        success:function(data){
            if(data.res){
                $('#ic').html("&#xe730;").css('color','#006000');
                $('#wz').html("发送成功，请勿刷新页面!").css('color','#006000');
                $('#div').fadeIn();//显示
                Hide();
            }
            else{
                $('#ic').html("&#xe735;").css('color','#f00');
                $('#wz').html("发送失败").css('color','#f00');
                $('#div').fadeIn();
                Hide();
                clearInterval(int);
                $("bt2").html("发送验证码");
            }
            result= data.aray;
        }
    });
}
/**
 * 查询用户是否存在
 */
function SelectUser(){
    var selectemail = $("#email").val();
    $.ajax({
        type:"POST",
        url:"./php/SelectUser.php",
        data: {email:selectemail.trim()},//前面是数据名，后面是数据值，注意格式严格要求
        dataType:"json",        //数据类型json
        async:true,             //同步还是一步，false是同步，true是异步
        success:function(data){
            if(data.aray=="false"){
				allowsendpm2 = false;
            }
            else{
				allowsendpm2 = true;
            }
        }
    });
}