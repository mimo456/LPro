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

        $dsn= "mysql:dbname=shop;host=localhost;charset=utf8";
        $user='root';
        $password='';
        $dbh=new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//例外 を投げる

        $sql='SELECT name,price,gazou FROM mst_product WHERE code=?';
        $stmt=$dbh->prepare($sql);
        $data[]=$pro_code;
        $stmt->execute($data);

        $rec=$stmt->fetch(PDO::FETCH_ASSOC);
        $pro_name=$rec['name'];
        $pro_price=$rec['price'];
        $pro_gazou_name=$rec['gazou'];


        $dbh=null;
        
        if ($pro_gazou_name==''||$pro_gazou_name==null) {
            $disp_gazou='';
        } else {
            $disp_gazou='<img src="../product/gazou/'.$pro_gazou_name.'">';
        }
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
    <?= '<a href="shop_cartin.php?procode='.$pro_code.'">カートに入れる</a>' ?>
    <p>商品情報</p>
    商品コード<br>
    <?php echo $pro_code; ?><br>
    商品名<br>
    <?php echo $pro_name; ?><br>
    価格<br>
    <?php echo $pro_price; ?>円<br><br>
    <?php echo $disp_gazou; ?>
    <form action="pro_delete_done.php" method="post">
        <input type="button" onclick="history.back()" value="戻る">
    </form>
</body>
</html>