<?php

$email = $_POST['email'];

$aray = rand(111111,999999);

function sendMail($to,$title,$content) {
    // 这个PHPMailer 就是之前从 Github上下载下来的那个项目
    require './PHPMailer/PHPMailerAutoload.php';
    // 实例化PHPMailer核心类
    $mail = new PHPMailer();
    // 使用smtp鉴权方式发送邮件
    $mail->isSMTP();
    // smtp需要鉴权 这个必须是true
    $mail->SMTPAuth = true;
    // 链接qq域名邮箱的服务器地址
    $mail->Host = 'smtp.qq.com';
    // 设置使用ssl加密方式登录鉴权
    $mail->SMTPSecure = 'ssl';
    // 设置ssl连接smtp服务器的远程服务器端口号
    $mail->Port = 465;
    // 设置发送的邮件的编码
    $mail->CharSet = 'UTF-8';
    // 设置发件人昵称 显示在收件人邮件的发件人邮箱地址前的发件人姓名
    $mail->FromName = '微跑校园';
    // smtp登录的账号 QQ邮箱即可
    $mail->Username = '1666385075@qq.com';
    // smtp登录的密码 使用生成的授权码
    $mail->Password = 'gukqugtlhlnbehca';
    // 设置发件人邮箱地址 同登录账号
    $mail->From = '1666385075@qq.com';
    // 邮件正文是否为html编码 注意此处是一个方法
    $mail->isHTML(true);
    // 设置收件人邮箱地址
    $mail->addAddress($to);
    // 添加该邮件的主题
    $mail->Subject = $title;
    // 添加邮件正文
    $mail->Body = $content;
    // 为该邮件添加附件
    //$mail->addAttachment("Material/11.png");

    //调用send发送邮件并返回结果
    if(!$mail->send()){
        return false ;
    }
    else{
        return true;
    }
}

// 调用发送方法，并在页面上输出发送邮件的状态
$res= sendMail($email,'微跑校园注册验证',"
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=0.5, minimum-scale=0.6, maximum-scale=0.7, user-scalable=no' /> 
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>E-mail</title>
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        #main{  
            width: 800px;
            margin: 0 auto;
            padding-top: 50px;
            padding-bottom: 70px;
            background-image: url(http://www.cxwt.xyz/Material/yt.png);
        }
        #BigBox{
            width: 740px;
            margin: 0 auto;
            background-color: #333;
        }
        #Information-first{
            height:40px;
            background-color: #333;
        }
        #Information-first a{
            color: #ddd;
            text-decoration: none;
            float: right;
            margin-right: 40px;
            line-height: 40px;
            font-size: 14px;
        }
        #Information-first a:hover{
            color: #ff6700;
        }
        #logo{
            margin-left: 5%;
            float: left;
            border-bottom-left-radius: 80px;
            border-bottom-right-radius: 80px;
            width: 110px;
            height: 65px;
            background-color: #ff6700;
        }
        #imglogo{
            float: left;
            margin-top: 8px;
            margin-left: 8px;
            width: 25px;
            height: 25px;
        }
        #p1{
            margin-top: 10px;
			color: #fff;
        }
        #primary{
            width: 87%;
            margin: 0 auto;
            padding: 3%;
            margin-top: 31px;
            border-top-style: outset;
            border-top-color: #f46700;
            background-color: #ddd;
        }
        #bottom{
            padding: 3%;
        }
        h1{
            text-align: center;
        }
        #wxgzQRcode{
            width: 100px;
            height: 100px;
        }
        #QR-code{
            padding-top: 16px;
            width: 100px;
            height: 100px;
            margin: 0 auto;
        }
        #bottom p{
            text-align: center;
            color: #ddd;
            font-size: 14px;
        }
        #Copyright{
            margin-top: 40px;
        }
        #bottom p a{
            text-decoration: none;
            font-size: 14px;
            color: #999;
        }
        #bottom p a:hover{
            color: #ff6700;
        }
        #email{
            color: #8E8E38;
        }
        #verify{
            font-size: 30px;
            color: #1E90FF;
        }
    </style>
</head>
<body>
    <div id='main'>
        <div id='BigBox'>
            <div id='Information-first'>
                <div id='logo'>
                    <img src='http://www.cxwt.xyz/Material/1.ico' id='imglogo'>
                    <p id='p1'>微跑校园</p>
                </div>
                <a href='http://www.cxwt.xyz'>官方网站</a>
            </div>
            <div id='primary'>
                <h1 id='zch1'>感谢您注册微跑校园</h1><br><br>
                <p>尊敬的微跑用户，您好！</p><br>
                <p>您正在使用邮箱 <a href='mailto: $email' rel='noopener' target='_blank' id='email'> $email </a> 注册微跑服务用户。</p><br>
                <p>您的注册验证码为: <span id='verify'> $aray </span></p>
                <br><br>
                <p>请回填以上6位阿拉伯数字组成的验证码</p>
                <br>
                <p>验证码在30分钟内有效，30分钟后需要重新激活邮箱</p>
                
            </div>
            <div id='bottom'>
                <p>此为系统邮件，请勿回复。<a href='http://www.cxwt.xyz'>不再推送</a></p>
                <div id='QR-code'>
                    <img src='http://www.cxwt.xyz/Material/wxgz.jpg' id='wxgzQRcode'>
                    <p>官方公众号</p>
                </div>
                <p id='Copyright'>Copyright © 2018-2019 Smile Run.</p>
                <P>All Rights Reserved.微跑校园 版权所有</P>
            </div>
        </div>
    </div>
</body>
</html>
");

$result = array(
    "aray"=>$aray,
    "res"=>$res
);

header('Content-Type:text/xml; charset=utf-8');

echo json_encode($result);

?>