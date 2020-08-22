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
                {$onamae}様\n\n
                このたびはご注文ありがとうございました。\n\n
                ご注文商品\n
                -------------------\n
            EOF;

            $cart=$_SESSION['cart'];
            $kazu=$_SESSION['kazu'];
            $max=count($cart);

            //データベースに接続
            $dsn= "mysql:dbname=shop;host=localhost;charset=utf8";
            $user='root';
            $password='';
            $dbh=new PDO($dsn, $user, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//例外 を投げる

            for($i;$i<$max;$i++){
                $sql='SELECT FROM mst_product WHERE code=?';
                $stmt=$dbh->prepare($sql);
                $data[0]=$cart[$i];
                $stmt->execute(array($data));//SQL文で指示を出す

                $rec=$stmt->fetch(PDO::FETCH_ASSOC);

                $name=$rec['name'];
                $price=$rec['price'];
                $suryo=$kazu[$i];
                $shoukei=$price*$suryo;
            }

            

            $dbh=null;

            

        } catch (Expection $e) {
            print 'ただいま障害により大変ご迷惑をお掛けしております。';
            exit();//強制終了
        }
    ?>

</body>
</html>