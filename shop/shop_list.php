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
        $dsn= "mysql:dbname=shop;host=localhost;charset=utf8";
        $user='root';
        $password='';
        $dbh=new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//例外を投げる

        $sql='SELECT code,name,price FROM mst_product WHERE 1';
        $stmt=$dbh->prepare($sql);
        $stmt->execute();

        $dbh=null;
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
    <?php
        while (true) {
            $rec=$stmt->fetch(PDO::FETCH_ASSOC);
            if ($rec==false) {
                break;
            }
            echo '<a href="shop_product.php?procode='.$rec['code'].'">';
            echo $rec['name'].'---'.$rec['price'].'円';
            echo '</a><br>';
        }
    ?>
    <br>
    <a href="shop_cartlook.php">カートを見る</a><br><br>
    <a href="clear_cart.php">カートを空にする

    </a>
</body>
</html>
