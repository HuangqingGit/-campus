<?php

require __DIR__ . "/NoteSend/src/index.php";                // 引入index.php文件

$phone = '17345240339';                                   //通过POST方法获取电话号码
$aray = rand(100000,999999);                                //rand()函数生成随机验证码

$appid = 1400200126;                                        // 短信应用 SDK AppID 以1400开头
$appkey = "4814e25ad040ec4a021bd9f7821d391d";               // 短信应用 SDK AppKey
$phoneNumbers = ["$phone"];                                 // 需要发送短信的手机号码
$templateId = 313189;                                       // 短信模板 ID，需要在短信应用中申请 
$smsSign = "皮皮虾技术分享";                                 // 签名参数使用的是`签名内容`，而不是`签名ID`。

use Qcloud\Sms\SmsSingleSender; 
try {
    $ssender = new SmsSingleSender($appid, $appkey);
    $params = ["$aray", "2"]; //这是一个数组对应模板的变量个数，变量个数必须与腾讯云模板的变量个数相同

    $result = $ssender->sendWithParam("86", $phoneNumbers[0], $templateId, $params, $smsSign, "", "");  // 签名参数未提供或者为空时，会使用默认签名发送短信
    $rsp = json_decode($result);    //把发送完成的返回信息转换成Json对象数据类型以方便判断是否发送成功
} 
catch(\Exception $e) {
    return $e;
}

if($rsp->errmsg == "OK"){        //通过Json对象类型获取数据，判断信息是否发送成功，如果发送成功把res设为true否则设为false
    $a = $rsp->errmsg;
    $result = array(
        "aray"=>$aray,      //验证码
        "res"=>true        //返回信息！
    );
    header('Content-Type:text/xml; charset=utf-8'); 
    echo json_encode($result);
}
else{
    $a = $rsp->errmsg;
    $result = array(
        "aray"=>$aray,      //验证码
        "res"=>false        //返回信息！
    );
    header('Content-Type:text/xml; charset=utf-8'); 
    echo json_encode($result);
}
