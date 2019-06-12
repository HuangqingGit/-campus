<?php
    $user = Trim($_GET['user']);
    $pwd = Trim($_GET['pwd']) ;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登录-微跑校园</title>
    <link rel="stylesheet" href="CSS/logo/iconfont.css">
    <link rel="stylesheet" href="CSS/login.CSS">
    <script src="JS/login.js"></script>
    <script src="JS/jquery-3.4.0.js"></script> 
</head>
<body>
    <div class="container">
            <div class="login">
                <div class="login-tab1">
                    <div class="login-tab1-1">
                        <p>登录</p>
                    </div>
                </div>
            <form action="./php/login.php" method="POST" onsubmit="return login_form(this);">
                <div class="put">            
                    <input id="username" type="text" name="username" value="<?php echo $user ?>" placeholder="请输入您的电话/邮箱">
                    <input id="password" type="password" name="password" value="<?php echo $pwd ?>"  placeholder="请输入您的密码"> 
                </div>

                <div class="found">
                    <a href="">忘记密码?</a>
                    <span></span>
                    <a href="register.html">马上注册</a>
                </div>
                <div class="but-login">
                    <input id="login" type="submit" value="登录">
                </div>
            </form>    
        </div>
    </div>
</body>
</html>