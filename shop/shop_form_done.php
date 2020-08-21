<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
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

        // echo '<pre>';
        // var_dump($_POST);
        // echo '</pre>';
        try {
            require_once('../common/common.php');

            $post=sanitize($_POST);

            $onamae=$post['onamae'];
            $email=$post['email'];
            $postal1=$post['postal1'];
            $postal2=$post['postal2'];
            $address=$post['address'];
            $tel=$post['tel'];
            //確認した文章をdoneで表示する
            $msg=<<<EOF
                {$onamae}様<br>
                ご注文ありがとうございました。<br>
                {$email}にメールを送りましたのでご確認ください。<br>
                商品は以下の住所に発送させていただきます。<br>
                {$postal1}-{$postal2}<br>
                {$address}<br>
                {$tel}<br>
            EOF;

            echo $msg;

            //データベースに接続
            $dsn= "mysql:dbname=shop;host=localhost;charset=utf8";
            $user='root';
            $password='';
            $dbh=new PDO($dsn, $user, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//例外 を投げる

            $sql='DELETE FROM mst_product WHERE code=?';
            $stmt=$dbh->prepare($sql);
            $stmt->execute(array($pro_code));//SQL文で指示を出す

            $dbh=null;

            if ($pro_gazou_name!='') {//画像のリンクがあった場合削除(unlink)する。
                unlink('./gazou/'.$pro_gazou_name);
            }
            echo '削除しました。';

        } catch (Expection $e) {
            print 'ただいま障害により大変ご迷惑をお掛けしております。';
            exit();//強制終了
        }
    ?>

</body>
</html>