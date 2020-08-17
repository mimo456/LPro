<?php
    session_start();
    session_regenerate_id(true);
    if (isset($_SESSION['login'])==false) {
        echo 'ログインされていません。<br>';
        echo '<p><a href="./staff_login.php">ログイン画面へ</a></p>';
        exit();
    } else {
        echo $_SESSION['staff_name'].'さんログイン中<br><br>';
        echo 'ショップ管理トップメニュー<br><br>';
        echo '<a href="../staff/staff_list.php">スタッフ管理</a><br><br>';
        echo '<a href="../product/pro_list.php">商品管理</a><br><br>';
    }


    try {
        require_once('../common/common.php');
        $post=sanitize($_POST);
        
        $pro_name=$post['name'];
        $pro_price=$post['price'];
        $pro_gazou_name=$_POST['gazou'];

        //データベースに接続
        $dsn= "mysql:dbname=shop;host=localhost;charset=utf8";
        $user='root';
        $password='';
        $dbh=new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//例外 を投げる

        $sql='INSERT INTO mst_product(name,price,gazou) VALUES(?,?,?)';
        $stmt=$dbh->prepare($sql);
        $stmt->execute(array($pro_name,$pro_price,$pro_gazou_name));//SQL文で指示を出す

        $dbh=null;

        echo $pro_name.'を追加しました<br>';
        echo '<a href="pro_list.php">戻る</a>';
    } catch (Expection $e) {
        print 'ただいま障害により大変ご迷惑をお掛けしております。';
        exit();//強制終了
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
    
</body>
</html>