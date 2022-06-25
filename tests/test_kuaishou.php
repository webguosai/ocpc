<?php
require_once '../vendor/autoload.php';

date_default_timezone_set('PRC');

$kuaiShou = new \Webguosai\Ocpc\KuaiShou();

?>

<script src="//libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>

<?php echo $kuaiShou->getJsBase();?>
<script>
    $(function(){
        $('#sub').click(function(){
            <?php echo $kuaiShou->getJsConversion();?>
        })
    })
</script>

<input id="sub" type="submit" value="POST" value="JS联调"/>
