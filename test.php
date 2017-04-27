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
$str='1234425';
if(preg_match('^[0-9]*$^',$str)){
echo '此字串由全数字组成';
};