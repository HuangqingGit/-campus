<?php

include('Connect Server.php');  //引入外部文件
$username = trim($_POST['username']);
$password = trim($_POST['password']);

$salt = '$1$rasmusle$';  //基于 MD5 算法的散列使用 12 个字符盐值
$hash = crypt($password,$salt);     //MD5加密
$length = strlen($username);

if ( $length == 0){         //判断用户名的长度是否为0 如果未0给出提示
    echo '请输入电话/邮箱';
    return false;
}
$index1 = strpos($username,"@");    //strpos函数是记录当前字符串中指定的字符第一次出现的位置如果字符串中没有出现指定的字符则返回false
$index2 = strpos($username,".");

if ($index1 == false && $index2 !== false||$index1 !== false && $index2 == false||$index1 > $index2) {     //判断邮箱格式是否正确
    echo "您的E-mail邮箱可能不正确！";
    return false;
}
if ($index1 == false && $index2 == false) {     //判断登录方式 邮箱或者电话  此处测试电弧暂时用用户名代替
    $aa = 'phone';
}
else {
    $aa = 'email';
}


$sql = "SELECT count(*) from tb_user where {$aa}= '{$username}' and pwd= '{$hash}'";    //初始SQL查询语句


$result =  $db->query($sql);            //执行SQL查询语句

$row= $result->fetch_array();           //获取查询的数据集

$count1= $row['count(*)'];              //单独取出count(*)的值
if ($count1==1) {                       //验证登录返回值如果为 1 则登录成功 为 0 或其他则登录失败
    echo "登录成功！";
}
else {
    echo "登录失败！";
    echo "\r";
    if ($aa=='username') {              //验证登录方式如果登录失败 则给出相应的错误提示
        echo "用户不存在 / 密码不正确！";
    }
    else {
        echo "E-mail用户不存在 / 密码不正确！";
    }
}
?>