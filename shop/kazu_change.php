<?php
    // echo '<pre>';
    // var_dump($_POST);
    // echo '</pre>';
    // exit();


    session_start();
    session_regenerate_id(true);

    require_once('../common/common.php');

    $post=sanitize($_POST);

    $max=$post['max'];//maxは商品数
    for($i=0;$i<$max;$i++){
        if(preg_match("/\A[0-9]+\z/",$post['kazu'.$i])==0){//マッチしなかった場合は0、エラーならfalse
            echo '数量に誤りがあります。';
            echo '<a href="shop_cartlook.php">カートに戻る</a>';
            exit();
        }
        if($post['kazu'.$i]<1||10<$post['kazu'.$i]){
            echo '数量は必ず1個以上、10個までです。';
            echo '<a href="shop_cartlook.php">カートに戻る</a>';
            exit();
        }
        $kazu[]=$post['kazu'.$i];//kazu0,kazu1と$_POSTで受け取ったものをサニタイズして$kazu[]配列に代入していく。
    }

    $cart=$_SESSION['cart'];
    for($i=$max;0<=$i;$i--){
        if(isset($_POST['sakujo'.$i])==true){
            array_splice($cart,$i,1);//カートの中身の数を削除
            array_splice($kazu,$i,1);//商品の数量を削除
        }
    }
    $_SESSION['cart']=$cart;
    $_SESSION['kazu']=$kazu;

    header('Location:shop_cartlook.php');
    exit();
?>