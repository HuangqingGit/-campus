<?php

include('Connect Server.php');  //引入外部文件
$username = trim($_POST['email']);
$return = "";
$index1 = strpos($username,"@");    //strpos函数是记录当前字符串中指定的字符第一次出现的位置如果字符串中没有出现指定的字符则返回false
$index2 = strpos($username,".");
$length = strlen($username);

if ( $length == 0){         //判断用户名的长度是否为0 如果为0给出提示
    exit;
}
if ($index1 == false && $index2 == false) {     //判断登录方式 邮箱或者电话  此处测试电弧暂时用用户名代替
    $aa = 'phone';
}
else {
    $aa = 'email';
}

$sql = "SELECT count(*) from tb_user where {$aa}= '{$username}'";    //初始SQL查询语句

$result =  $db->query($sql);            //执行SQL查询语句

$row= $result->fetch_array();           //获取查询的数据集

$count1= $row['count(*)'];              //单独取出count(*)的值
if ($count1==1) {                       //验证登录返回值如果为 1 则用户已存在 为 0 则用户未注册
    $return = "false";
}
else {
    $return = "true";
}

$result = array(
    "aray"=>$return
);

header('Content-Type:text/xml; charset=utf-8');

echo json_encode($result);

?>