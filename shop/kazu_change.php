<?php
    session_start();
    session_regenerate_id(true);

    require_once('../common/common.php');

    $post=sanitize($_POST);

    $max=$post['max'];//maxは商品数
    for($i=0;$i<$max;$i++){
        $kazu[]=$post['kazu'.$i];//kazu0,kazu1と$_POSTで受け取ったものをサニタイズして$kazu[]配列に代入していく。
    }

    $_SESSION['kazu']=$kazu;

    header('Location:shop_cartlook.php');
    exit();
?>