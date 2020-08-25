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
                {$onamae}様\n
                このたびはご注文ありがとうございました。\n
                ご注文商品\n
                -----------------------------------------\n
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

            for($i=0;$i<$max;$i++){//注文した野菜をデータベースから取得して変数に格納する。
                $sql='SELECT name,price FROM mst_product WHERE code=?';
                $stmt=$dbh->prepare($sql);
                $data[0]=$cart[$i];
                $stmt->execute($data);//SQL文で指示を出す

                $rec=$stmt->fetch(PDO::FETCH_ASSOC);

                $name=$rec['name'];
                $price=$rec['price'];
                $kakaku[]=$price;
                $suryo=$kazu[$i];
                $shokei=$price*$suryo;

                $msg.=<<<EOF
                    {$name} {$price}円x {$suryo}個={$shokei}円\n
                EOF;

            }
            //同時に登録できないようにここでロックする。
            $sql='LOCK TABLES dat_sales WRITE,dat_sales_product WRITE';
            $stmt=$dbh->prepare($sql);
            $stmt->execute();

            //お客様情報をデータベースに保存
            $sql='INSERT INTO dat_sales(code_member,name,email,postal1,postal2,address,tel) VALUES(?,?,?,?,?,?,?)';
            $stmt=$dbh->prepare($sql);
            $data=array();
            $data[]=0;
            $data[]=$onamae;
            $data[]=$email;
            $data[]=$postal1;
            $data[]=$postal2;
            $data[]=$address;
            $data[]=$tel;
            $stmt->execute($data);

            //追加されたばかりの注文コードを取得。
            $sql='SELECT LAST_INSERT_ID()';//auto_incrementで最も最近に発番された番号を取得できる。
            //SELECT code FROM dat_sales　WHERE code=1 みたいな感じになるはず。
            $stmt=$dbh->prepare($sql);
            $stmt->execute();
            $rec=$stmt->fetch(PDO::FETCH_ASSOC);
            $lastcode=$rec['LAST_INSERT_ID()'];

            //注文明細データ
            for($i=0;$i<$max;$i++){
                //複数の商品を購入している場合data_sales_productに商品の詳細を追加していく。
                $sql='INSERT INTO dat_sales_product(code_sales,code_product,price,quantity) VALUES(?,?,?,?)';
                $stmt=$dbh->prepare($sql);
                $data=array();
                $data[]=$lastcode;//ここで取得したauto_incrementの番号を使う。
                $data[]=$cart[$i];
                $data[]=$kakaku[$i];
                $data[]=$kazu[$i];
                $stmt->execute($data);
            }


            //ロックの解除
            $sql='UNLOCK TABLES';
            $stmt=$dbh->prepare($sql);
            $stmt->execute();

            $dbh=null;

            $msg.=<<<EOF
                送料は無料です。\n
                -----------------------------------------\n
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

            //echo $msg;
            echo nl2br($msg);//改行の確認用
            
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

            //カートを空にする。
            session_start();
            $_SESSION=array();//セッション変数を空にしている。
            if (isset($_COOKIE[session_name()])==true) {
                setcookie(session_name(), '', time()-42000, '/');
                //ブラウザ側ではクッキーとしてsession_idが保存されている（ブラウザとサーバーの合言葉）、ブラウザ側ではsession_name()をkeyとして保存されている。
                //第2引数のvalueを''にして、valueの中身を空にしている。,
            }
            session_destroy();//セッションを破棄する。



        } catch (Expection $e) {
            print 'ただいま障害により大変ご迷惑をお掛けしております。';
            exit();//強制終了
        }
    ?>
    <br>
    <a href="shop_list.php">商品画面へ</a>
</body>
</html>