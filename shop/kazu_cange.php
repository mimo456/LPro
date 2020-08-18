<?php
    session_start();
    session_regenerate_id(true);

    require_once('../common/common.php');

    $post=sanitaize($_POST);

    $max=$post['max'];//maxは商品数
    for($i=0;$i<$max;$i++){
        $kazu[]=$post['kazu'.$i];
    }

    $_SESSION['kazu']=$kazu;

    header('Location:shop_cartlook.php');
    exit();
?>