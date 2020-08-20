<?php
    session_start();
    session_regenerate_id(true);
    if (isset($_SESSION['member_login'])==false) {
        echo 'ようこそゲスト様<br>';
        echo '<p><a href="./staff_login.php">会員ログイン画面へ</a></p>';
    } else {
        echo 'ようこそ'.$_SESSION['member_name'].'様<br><br>';
        echo '<a href="./member_loguto.php">ログアウト</a><br><br>';
    }

    try {
        $pro_code=$_GET['procode'];

        if(isset($_SESSION['cart'])){
            $cart=$_SESSION['cart'];
            $kazu=$_SESSION['kazu'];
            if(in_array($pro_code,$cart)==true){//ダブっているものを探すので、カートの中身が存在する場合にin_arrayでダブっているものを探す。
                echo 'その商品はすでにカートに入っています。<br>';
                echo '<a href="shop_list.php">商品一覧に戻る</a>';
                exit();
            }
        }
        $cart[]=$pro_code;//$_SESSION['cart']の中身がある場合はそこに追加する追加する
        $kazu[]=1;
        $_SESSION['cart']=$cart;//Sessionにカートの内容を保存する
        $_SESSION['kazu']=$kazu;
    } catch (Exsetion $e) {
        echo 'ただいま障害により大変ご迷惑をおかけしております。';
        exit();
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ろくまる農園</title>
</head>
<body>
    カートに追加しました。<br><br>
    <a href="shop_list.php">商品一覧に戻る</a>
</body>
</html>