<?php
    session_start();
    session_regenerate_id(true);
    if (isset($_SESSION['login'])==false) {
        echo 'ログインされていません。<br>';
        echo '<p><a href="./staff_login.php">ログイン画面へ</a></p>';
        exit();
    } else {
        echo $_SESSION['staff_name'].'さんログイン中<br><br>';
        echo '<a href="../staff/staff_list.php">スタッフ管理</a><br><br>';
        echo '<a href="../product/pro_list.php">商品管理</a><br><br>';
    }

    try {

        require_once('../common/common.php');
        $post=sanitize($_POST);
        
        $pro_name=$post['code'];
        $pro_pass=$post['name'];
        $pro_pass2=$post['price'];
        $pro_gazou_name_old=$_POST['gazou_name_old'];
        $pro_gazou_name=$_POST['gazou_name'];

        //データベースに接続
        $dsn= "mysql:dbname=shop;host=localhost;charset=utf8";
        $user='root';
        $password='';
        $dbh=new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//例外 を投げる

        $sql='UPDATE mst_product SET name=?,price=?,gazou=? WHERE code=?';
        $stmt=$dbh->prepare($sql);
        $stmt->execute(array($pro_name,$pro_price,$pro_gazou_name,$pro_code));//SQL文で指示を出す

        $dbh=null;
        
        if($pro_gazou_name_old!=$pro_gazou_name){
            if ($pro_gazou_name_old!='') {//もし古い画像があれば削除する
                unlink('./gazou/'.$pro_gazou_name_old);
            }
        }
        

        echo '修正しました。<br>';
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