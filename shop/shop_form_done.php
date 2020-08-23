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

            for($i=0;$i<$max;$i++){
                $sql='SELECT name,price FROM mst_product WHERE code=?';
                $stmt=$dbh->prepare($sql);
                $data[0]=$cart[$i];
                $stmt->execute($data);//SQL文で指示を出す

                $rec=$stmt->fetch(PDO::FETCH_ASSOC);

                $name=$rec['name'];
                $price=$rec['price'];
                $suryo=$kazu[$i];
                $shokei=$price*$suryo;

                $msg=<<<EOF
                    {$name} {$price}円x {$suryo}個={$shokei}円\n
                EOF;

            }
            $dbh=null;

            $msg=<<<EOF
                送料は無料です。\n
                -------------\n\n
                代金は以下の口座にお振込みください。\n
                ろくまる銀行　やさい支店　普通口座１２３４５６７\n\n
                入金確認が取れ次第、梱包、発送させていただきます。\n\n
                □□□□□□□□□□□□□□□□□□□□□\n
                〜安心野菜のろくまる農園〜\n\n
                ○○県六丸郡六丸村１２３-４\n
                電話090-6060-xxxx\n
                メール　info@rokumarunouen.co.jp\n
                □□□□□□□□□□□□□□□□□□□□□\n
            EOF;

            echo $msg;
            //echo nl2br($msg);//改行の確認用
            
            //お客さんにメールを送信
            $title='ご注文ありがとうございます。';//メールタイトル
            $header='From:info@rokumarunouen.co.jp';//送信元アドレス
            $honbun=html_entity_decode($msg,ENT_QUOTES,'UTF-8');
            mb_language('Japanese');
            mb_internal_encoding('UTF-8');
            mb_send_mail($email,$title,$honbun,$header);//メールを送信する命令

            //お店にメールを送信
            $title='
            お客様からご注文ありました。';//メールタイトル
            $header='From:'.$email;//送信元アドレス
            $honbun=html_entity_decode($msg, ENT_QUOTES, 'UTF-8');
            mb_language('Japanese');
            mb_internal_encoding('UTF-8');
            mb_send_mail('info@rokumarunouen.co.jp', $title, $honbun, $header);//メールを送信する命令


        } catch (Expection $e) {
            print 'ただいま障害により大変ご迷惑をお掛けしております。';
            exit();//強制終了
        }
    ?>

</body>
</html>