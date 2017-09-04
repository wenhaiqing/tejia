<?php 
// $filename = 'pool.jpg';
// $degrees = 30;

// // Content type
// header('Content-type: image/jpeg');

// // Load
// $source = imagecreatefromjpeg($filename);

// // Rotate
// $rotate = imagerotate($source, $degrees, 0);

// // Output
// imagejpeg($rotate);

// if(preg_match('/^(data:\s*image\/(\w+);base64,)/', $_POST['imgurl'], $result)){
//      $un_decode_base64 =  substr($content,strlen($result[1]));
//      file_put_contents('filename.png', base64_decode($un_decode_base64));
//      //后面输入路径,然后前端跳转下载服务器上的图片就可以了
// }
// echo $_SERVER['REMOTE_ADDR'];echo "<br/>".
// getenv('REMOTE_ADDR');
// echo gethostbyname("yiparkin.com");
// $str='1234425';
// if(preg_match('^[0-9]*$^',$str)){
// echo '此字串由全数字组成';
// };

// $a = array();
// //$a = array(1,2,3);
// $a['name'] = 'wenhaiqng';
// $a['sex'] = 'nan';
// $b = json_encode($a);
// $c = json_decode($b);
// var_dump($b);
// var_dump($c);
 // $a = 'a:2:{s:4:"good";a:3:{i:0;s:18:"干锅有机花菜";i:1;s:12:"麻婆豆腐";i:2;s:30:"大份香米（五常大米）";}s:3:"bad";a:1:{i:0;s:15:"青椒土豆丝";}}';
 // $b = unserialize($a);
 // var_dump($b);
$uid = 1;
    $amount = 10;
 $dbname="root";
    $dbpass="asdf#1234";
    $dbhost="127.0.0.1";
    $dbdatabase="tejia";
    //生成一个连接
    $db_connect= new mysqli($dbhost,$dbname,$dbpass,$dbdatabase);
    $db_connect->query('set names utf8');
    $final_fee = $amount;
    $case = "select credit2,credit3 from ims_mc_members where uid=".$uid;
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
               
        
        
    
