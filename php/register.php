<?php
    include('Connect Server.php');//引入外部php文件
    $email = trim($_POST['email']);//trim数据格式删除前后空格
    $password = trim($_POST['userpass']);
    $Time = time(); //系统时间函数 
        
    //如果账号密码有数据这执行else进行加密和存入数据库
    $salt = '$1$rasmusle$';  //基于 MD5 算法的散列使用 12 个字符盐值
    $hash = crypt($password,$salt);     //MD5加密
    $length = strlen($email);

    $index1 = strpos($email,"@");    //strpos函数是记录当前字符串中指定的字符第一次出现的位置如果字符串中没有出现指定的字符则返回false
    $index2 = strpos($email,".");

    if ($index1 == false && $index2 !== false||$index1 !== false && $index2 == false||$index1 > $index2) {     //判断邮箱格式是否正确
        echo "您的E-mail邮箱可能不正确！";
        return false;
    }
    if ($index1 == false && $index2 == false) {     //判断注册方式 邮箱或者电话
        $aa = 'phone';
    }
    else {
        $aa = 'email';
    }

    $sql = "SELECT count(*) FROM tb_user WHERE {$aa}= '{$email}';";    //初始SQL查询语句
    $result =  $db->query($sql);            //执行SQL查询语句
    $row= $result->fetch_array();           //获取查询的数据集
    $count1= $row['count(*)'];              //单独取出count(*)的值
    if ($count1>=1) {                       //验证邮箱是否被注册
        $result = array('result'=>false,'error'=>false);
    }
    else{
        $sqll = "INSERT INTO tb_user(username,{$aa},pwd,ZCTime)values('admin','{$email}','{$hash}','{$Time}')";   //SQL插入语句赋值
        $is= $db->query($sqll);  //执行SQL语句

        if($is){
            $result = array('result'=>true);
        }
        else{
            $result = array('result'=>false,'error'=>true);
        }
    }

    header('Content-Type:text/xml; charset=utf-8');
    echo json_encode($result);
?>

