<?php
if($_GET['out'])
{
    if($_GET['out'] = "1"){
    //设置cookie超时
    setcookie("rid",'',1,'/');

    //刷新页面
    echo '<script type="text/javascript">location.href="../../index.php"</script>';
    mysql_close($con);
    exit('成功退出');
    }
    echo '<script type="text/javascript">location.href="../../index.php"</script>';
    mysql_close($con);
    exit('get');
    
}
?>