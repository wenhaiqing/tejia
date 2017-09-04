<?php
/* *
 * Ping++ Server SDK
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可根据自己网站需求按照技术文档编写, 并非一定要使用该代码。
 * 接入 webhooks 流程参考开发者中心：https://www.pingxx.com/docs/webhooks/webhooks
 * 该代码仅供学习和研究 Ping++ SDK 使用，仅供参考。
 */

require dirname(__FILE__) . '/../init.php';

/* *
 * 验证 webhooks 签名方法：
 * raw_data：Ping++ 请求 body 的原始数据即 event ，不能格式化；
 * signature：Ping++ 请求 header 中的 x-pingplusplus-signature 对应的 value 值；
 * pub_key_path：读取你保存的 Ping++ 公钥的路径；
 * pub_key_contents：Ping++ 公钥，获取路径：登录 [Dashboard](https://dashboard.pingxx.com)->点击管理平台右上角公司名称->开发信息-> Ping++ 公钥
 */
function verify_signature($raw_data, $signature, $pub_key_path) {
    $pub_key_contents = file_get_contents($pub_key_path);
    // php 5.4.8 以上，第四个参数可用常量 OPENSSL_ALGO_SHA256
    return openssl_verify($raw_data, base64_decode($signature), $pub_key_contents, 'sha256');
}

$raw_data = file_get_contents('php://input');
// 示例
// $raw_data = '{"id":"evt_eYa58Wd44Glerl8AgfYfd1sL","created":1434368075,"livemode":true,"type":"charge.succeeded","data":{"object":{"id":"ch_bq9IHKnn6GnLzsS0swOujr4x","object":"charge","created":1434368069,"livemode":true,"paid":true,"refunded":false,"app":"app_vcPcqDeS88ixrPlu","channel":"wx","order_no":"2015d019f7cf6c0d","client_ip":"140.227.22.72","amount":100,"amount_settle":0,"currency":"cny","subject":"An Apple","body":"A Big Red Apple","extra":{},"time_paid":1434368074,"time_expire":1434455469,"time_settle":null,"transaction_no":"1014400031201506150354653857","refunds":{"object":"list","url":"/v1/charges/ch_bq9IHKnn6GnLzsS0swOujr4x/refunds","has_more":false,"data":[]},"amount_refunded":0,"failure_code":null,"failure_msg":null,"metadata":{},"credential":{},"description":null}},"object":"event","pending_webhooks":0,"request":"iar_Xc2SGjrbdmT0eeKWeCsvLhbL"}';

$headers = \Pingpp\Util\Util::getRequestHeaders();
// 签名在头部信息的 x-pingplusplus-signature 字段
$signature = isset($headers['X-Pingplusplus-Signature']) ? $headers['X-Pingplusplus-Signature'] : NULL;
// 示例
// $signature = 'BX5sToHUzPSJvAfXqhtJicsuPjt3yvq804PguzLnMruCSvZ4C7xYS4trdg1blJPh26eeK/P2QfCCHpWKedsRS3bPKkjAvugnMKs+3Zs1k+PshAiZsET4sWPGNnf1E89Kh7/2XMa1mgbXtHt7zPNC4kamTqUL/QmEVI8LJNq7C9P3LR03kK2szJDhPzkWPgRyY2YpD2eq1aCJm0bkX9mBWTZdSYFhKt3vuM1Qjp5PWXk0tN5h9dNFqpisihK7XboB81poER2SmnZ8PIslzWu2iULM7VWxmEDA70JKBJFweqLCFBHRszA8Nt3AXF0z5qe61oH1oSUmtPwNhdQQ2G5X3g==';

// Ping++ 公钥，获取路径：登录 [Dashboard](https://dashboard.pingxx.com)->点击管理平台右上角公司名称->开发信息-> Ping++ 公钥
$pub_key_path = __DIR__ . "/your_rsa_public_key.pem";

$result = verify_signature($raw_data, $signature, $pub_key_path);
// if ($result === 1) {
//     // 验证通过
// } elseif ($result === 0) {
//     http_response_code(400);
//     echo 'verification failed';
//     $event = json_decode($raw_data, true);
//     var_dump($event);
//     exit;
// } else {
//     http_response_code(400);
//     echo 'verification error';
//     exit;
// }

$event = json_decode($raw_data, true);
$id = $event['data']['object']['body'];
$uid = $event['data']['object']['description'];
$amount = $event['data']['object']['amount']/100;
// var_dump($event['type']);
// var_dump($id);
// $id=320;

if ($event['type'] == 'charge.succeeded') {
    $charge = $event['data']['object'];
    // ...
     $dbname="root";
    $dbpass="asdf#1234";
    $dbhost="127.0.0.1";
    $dbdatabase="tejia";

    //生成一个连接
    $db_connect= new mysqli($dbhost,$dbname,$dbpass,$dbdatabase);
    $db_connect->query('set names utf8');
    if ($id) {
        $strsql="update ims_tiny_wmall_order set is_pay=1 where id=".$id;

        $result=$db_connect->query($strsql);
        // 释放资源
        $result->close();
    }else{
        $final_fee = $amount;
        $credit = $db_connect->query("select credit2,credit3 from ims_mc_members where uid=".$uid);
        while($row=$credit->fetch_array()){
            $credit3 = $row['credit3'];
            $credit2 = $row['credit2'];
        }
        if ($final_fee>100) {
            $credit3 = $credit3+$final_fee;
            $credit3 = round($credit3,2);
            $sql = "update ims_mc_members set credit3=" .$credit3. " where uid=".$uid;
            $result = $db_connect->query($sql);
            $credittype = 'credit3';
        }else{
            $credit2 = $credit2+$final_fee;
            $credit2 = round($credit2,2);
            $sql = "update ims_mc_members set credit2=" .$credit2. " where uid=".$uid;
            $result = $db_connect->query($sql);
            $credittype = 'credit2';
        }
        $createtime = time();
        
        $sql1 = "insert into ims_mc_credits_record (uid,uniacid,credittype,num,createtime,remark,clerk_type) values ({$uid},2,'{$credittype}',{$amount},{$createtime},'会员充值',2)";
        var_dump($sql1);
        $result1 = $db_connect->query($sql1);
        
        $sql2 = "insert into ims_mc_credits_recharge (uid,uniacid,type,status,createtime,backtype,fee) values ({$uid},2,'credit',1,{$createtime},2,{$amount})";
        $result2 = $db_connect->query($sql2);
    }
    

    
    // 关闭连接
    $db_connect->close();
    http_response_code(200); // PHP 5.4 or greater
} elseif ($event['type'] == 'refund.succeeded') {
    $refund = $event['data']['object'];
    // ...
    http_response_code(200); // PHP 5.4 or greater
} else {
    /**
     * 其它类型 ...
     * - summary.daily.available
     * - summary.weekly.available
     * - summary.monthly.available
     * - transfer.succeeded
     * - red_envelope.sent
     * - red_envelope.received
     * ...
     */
    http_response_code(200);

    // 异常时返回非 2xx 的返回码
    // http_response_code(400);
}
