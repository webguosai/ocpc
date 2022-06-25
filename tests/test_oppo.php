<?php
require_once 'vendor/autoload.php';

date_default_timezone_set('PRC');

$apiId = 'c6f47f278f0645cab70650282dc0512c';
$apiKey = '6b9fd69f3eef4319abb5baa896650732';
$ownerId = 1000155985;//广告主id
$oppo = new \Webguosai\Ocpc\Oppo($apiId, $apiKey, $ownerId);

// 监听检测(用于在官方测试检测)
//$oppo->listenCheck();

// 获取参数
//$params = $oppo->getParams();
//dump($params);

//$pageId = $params['pageId'];
//$tid    = $params['tid'];
//$lbid   = $params['lbid'];

$pageId = 1200015451;
$tid    = '1-O04Mho1gFyxjT2sLdq0cCI%2FRUYV8RxX0Og8MLTQXqdteIcY5ne%2F99JdMcHj1OjiZ1654655504ApiTestTidProfix';
$lbid   = '1_0_0';
$ip     = $_SERVER['REMOTE_ADDR'];

// 发送回传
try {
    $res = $oppo->send($pageId, $tid, $lbid, $ip);
    dump('接口返回:'.$res);
} catch (\Exception $e) {
    dump($e->getMessage());
}

?>
<script src="//libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script>
    $(function(){
        $('#sub').click(function(){

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '',
                data: {
                    pageId: '<?php echo $pageId;?>',
                    tid: '<?php echo $tid;?>',
                    lbid: '<?php echo $lbid;?>',
                },
                success: function(res) {
                    console.log(res);
                }
            });
        })
    })
</script>

<input id="sub" type="submit" value="POST"/>

<a href="?pageId=1200015451&tid=1-O04Mho1gFyxjT2sLdq0cCI%2FRUYV8RxX0Og8MLTQXqdteIcY5ne%2F99JdMcHj1OjiZ1654655504ApiTestTidProfix&lbid=1_0_0&testFlag=1">page</a>
<a href="?">referer</a>
