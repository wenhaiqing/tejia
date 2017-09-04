<?php
header("Content-Type: text/html; charset=UTF-8");

defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;

$do = 'goods';
mload()->model('store');
mload()->model('goods');
$userres = pdo_get('mc_members',array('uid'=>$_W['member']['uid']),array('name'));
$username = $userres['name'];
$this->checkAuth();
    $dbname="root";
    $dbpass="asdf#1234";
    $dbhost="127.0.0.1";
    $dbdatabase="tejia";

    //生成一个连接
    $db_connect= new mysqli($dbhost,$dbname,$dbpass,$dbdatabase);
    $db_connect->query('set names utf8');

    // 获取查询结果
    $strsql="select * from `ims_tiny_wmall_store` where `status` = '1' order by displayorder desc";


    $result=$db_connect->query($strsql);
    $data = array();
    // 循环取出记录
    while ($row=mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    for ($i=0;$i<count($data);$i++){
        $categorysql = pdo_get('tiny_wmall_goods_category',array('sid'=>$data[$i]['id'],'title'=>$username));
        $category = $categorysql['id'];
        
        $strsql1="select * from `ims_tiny_wmall_goods` where `status` = '1' and `sid` = ".$data[$i]['id'] ." and `cid`= ".$category." order by cid ";
        $result1=$db_connect->query($strsql1);
        // 循环取出记录
        while ($row1=mysqli_fetch_assoc($result1))
        {
            $data[$i]['qibushigoods'][] = $row1;
        }
    }
	
    // 释放资源
    $result->close();
    // 关闭连接
    $db_connect->close();

?>
<!DOCTYPE html>
<html>
<head>
    <title>更新库存</title>
<style>

body {
    width: 600px;
    margin: 40px auto;
    font-family: 'trebuchet MS', 'Lucida sans', Arial;
    font-size: 14px;
    color: #444;
}

table {
    *border-collapse: collapse; /* IE7 and lower */
    border-spacing: 0;
    width: 100%;    
}

.bordered {
    border: solid #ccc 1px;
    -moz-border-radius: 6px;
    -webkit-border-radius: 6px;
    border-radius: 6px;
    -webkit-box-shadow: 0 1px 1px #ccc; 
    -moz-box-shadow: 0 1px 1px #ccc; 
    box-shadow: 0 1px 1px #ccc;         
}

.bordered tr:hover {
    background: #fbf8e9;
    -o-transition: all 0.1s ease-in-out;
    -webkit-transition: all 0.1s ease-in-out;
    -moz-transition: all 0.1s ease-in-out;
    -ms-transition: all 0.1s ease-in-out;
    transition: all 0.1s ease-in-out;     
}    
    
.bordered td, .bordered th {
    border-left: 1px solid #ccc;
    border-top: 1px solid #ccc;
    padding: 10px;
    text-align: left;    
}

.bordered th {
    background-color: #dce9f9;
    background-image: -webkit-gradient(linear, left top, left bottom, from(#ebf3fc), to(#dce9f9));
    background-image: -webkit-linear-gradient(top, #ebf3fc, #dce9f9);
    background-image:    -moz-linear-gradient(top, #ebf3fc, #dce9f9);
    background-image:     -ms-linear-gradient(top, #ebf3fc, #dce9f9);
    background-image:      -o-linear-gradient(top, #ebf3fc, #dce9f9);
    background-image:         linear-gradient(top, #ebf3fc, #dce9f9);
    -webkit-box-shadow: 0 1px 0 rgba(255,255,255,.8) inset; 
    -moz-box-shadow:0 1px 0 rgba(255,255,255,.8) inset;  
    box-shadow: 0 1px 0 rgba(255,255,255,.8) inset;        
    border-top: none;
    text-shadow: 0 1px 0 rgba(255,255,255,.5); 
}

.bordered td:first-child, .bordered th:first-child {
    border-left: none;
}

.bordered th:first-child {
    -moz-border-radius: 6px 0 0 0;
    -webkit-border-radius: 6px 0 0 0;
    border-radius: 6px 0 0 0;
}

.bordered th:last-child {
    -moz-border-radius: 0 6px 0 0;
    -webkit-border-radius: 0 6px 0 0;
    border-radius: 0 6px 0 0;
}

.bordered th:only-child{
    -moz-border-radius: 6px 6px 0 0;
    -webkit-border-radius: 6px 6px 0 0;
    border-radius: 6px 6px 0 0;
}

.bordered tr:last-child td:first-child {
    -moz-border-radius: 0 0 0 6px;
    -webkit-border-radius: 0 0 0 6px;
    border-radius: 0 0 0 6px;
}

.bordered tr:last-child td:last-child {
    -moz-border-radius: 0 0 6px 0;
    -webkit-border-radius: 0 0 6px 0;
    border-radius: 0 0 6px 0;
}



/*----------------------*/

.zebra td, .zebra th {
    padding: 10px;
    border-bottom: 1px solid #f2f2f2;    
}

.zebra tbody tr:nth-child(even) {
    background: #f5f5f5;
    -webkit-box-shadow: 0 1px 0 rgba(255,255,255,.8) inset; 
    -moz-box-shadow:0 1px 0 rgba(255,255,255,.8) inset;  
    box-shadow: 0 1px 0 rgba(255,255,255,.8) inset;        
}

.zebra th {
    text-align: left;
    text-shadow: 0 1px 0 rgba(255,255,255,.5); 
    border-bottom: 1px solid #ccc;
    background-color: #eee;
    background-image: -webkit-gradient(linear, left top, left bottom, from(#f5f5f5), to(#eee));
    background-image: -webkit-linear-gradient(top, #f5f5f5, #eee);
    background-image:    -moz-linear-gradient(top, #f5f5f5, #eee);
    background-image:     -ms-linear-gradient(top, #f5f5f5, #eee);
    background-image:      -o-linear-gradient(top, #f5f5f5, #eee); 
    background-image:         linear-gradient(top, #f5f5f5, #eee);
}

.zebra th:first-child {
    -moz-border-radius: 6px 0 0 0;
    -webkit-border-radius: 6px 0 0 0;
    border-radius: 6px 0 0 0;  
}

.zebra th:last-child {
    -moz-border-radius: 0 6px 0 0;
    -webkit-border-radius: 0 6px 0 0;
    border-radius: 0 6px 0 0;
}

.zebra th:only-child{
    -moz-border-radius: 6px 6px 0 0;
    -webkit-border-radius: 6px 6px 0 0;
    border-radius: 6px 6px 0 0;
}

.zebra tfoot td {
    border-bottom: 0;
    border-top: 1px solid #fff;
    background-color: #f1f1f1;  
}

.zebra tfoot td:first-child {
    -moz-border-radius: 0 0 0 6px;
    -webkit-border-radius: 0 0 0 6px;
    border-radius: 0 0 0 6px;
}

.zebra tfoot td:last-child {
    -moz-border-radius: 0 0 6px 0;
    -webkit-border-radius: 0 0 6px 0;
    border-radius: 0 0 6px 0;
}

.zebra tfoot td:only-child{
    -moz-border-radius: 0 0 6px 6px;
    -webkit-border-radius: 0 0 6px 6px
    border-radius: 0 0 6px 6px
}
  
</style>
    <script type="text/javascript" src="jquery-1.11.1.min.js"></script>
</head>

<body>
<?php foreach ($data as $k=>$v){ ?>
<h2><?php echo $v['title'] ?><span></span></h2>
<table class="bordered">
    <thead>
    <tr>
        <th>ID</th>
        <th>菜名</th>
        <th>价格</th>
        <th>规格</th>
        <!-- <th>下架</th> -->
    </tr>
    </thead>
    <form action="index.php?i=2&c=entry&do=appsubmit&m=we7_wmall&op=goods1&sid=<?php echo $v['id'] ?>" method="post" id="goods-form">
    <?php foreach($v['qibushigoods'] as $key=>$val){ ?>
    <tr>
        <td><?php echo $val['id'] ?></td>
        <td><?php echo $val['title'] ?></td>
        <td><input type="text" name="goods[<?php echo $val['id']; ?>]['price']" data-id="<?php echo $val['id'] ?>" data-name="<?php echo $val['title'] ?>" value=""></td>
<td><input type="text" name="goods[<?php echo $val['id']; ?>]['unitname']" data-id="<?php echo $val['id'] ?>" data-name="<?php echo $val['title'] ?>" value=""></td>
        <input type="hidden" value="<?php echo $val['title'] ?>" name="goods[<?php echo $val['id']; ?>]['title']"> 
        <!-- <td>
            下架:<input type="radio" data-id="<?php echo $val['id'] ?>" data-name="<?php echo $val['title'] ?>" name="status" value="0"  />
        </td> -->
    </tr>        
    <?php } ?>
</form>

</table>
<input type="button" value="提交" class="btn2" onclick = "checkUser();" />
<?php } ?>
<br><br>

<br>
<script type="text/javascript">
    function checkUser(){
        $('#goods-form').submit();
    }

    $(function(){
        $("input[name=total]").blur(function(){
            var total = $(this).val();
            var id = $(this).attr("data-id");
            var title = $(this).attr("data-name");
            gstatus('total',total,id,title);
        });

        $("input[name=status]").click(function(){
            var status = $(this).val();
            var id = $(this).attr("data-id");
            var title = $(this).attr("data-name");
            gstatus('status',status,id,title);
        });
    });

    function gstatus(name,val,id,title){
        $.ajax({
            url:'http://qibushi.zdxinfo.com/app/index.php?i=3&c=entry&do=appcategory&m=we7_wmall&suiji='+Math.random(),
            type:'POST', //GET
            async:true,    //或false,是否异步
            data:{
                goodsname:name,val:val,id:id,title:title
            },
            dataType:'json',    //返回的数据格式：json/xml/html/script/jsonp/text
            success:function(data){
                if(data.code == 1){
                    alert('修改成功');
                window.location.reload();
            }else{
                alert('修改失败，请重新修改');
                window.location.reload();
            }
                
            }
        })
    }

</script>

</body>
</html>
