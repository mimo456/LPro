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
        if(isset($_SESSION['cart'])==true){
            $cart=$_SESSION['cart'];
            $kazu=$_SESSION['kazu'];//kazu_change.phpで代入されていれば$kazuに選んだ商品数が代入される。
            $max=count($cart);//cart配列の配列数を数える
        }else{
            $max=0;
        }
    
        if($max==0){//カートに商品が入っていない場合
            echo 'カートに商品が入っていません。<br><br>';
            echo '<a href="shop_list.php">商品一覧に戻る</a>';
            exit();
        }

        // echo '<pre>';
        // var_dump($cart);
        // echo '</pre>';

        $dsn= "mysql:dbname=shop;host=localhost;charset=utf8";
        $user='root';
        $password='';
        $dbh=new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//例外 を投げる

        foreach ($cart as $key => $value) {//カートに追加した商品名、画像、値段を表示。
            $sql='SELECT code,name,price,gazou FROM mst_product WHERE code=?';
            $stmt=$dbh->prepare($sql);
            $data[0]=$value;//executeは配列型でなければ実行できないため。
            $stmt->execute($data);

            $rec=$stmt->fetch(PDO::FETCH_ASSOC);

            //sqlで取得した商品情報を配列にどんどん入れていく。
            $pro_name[]=$rec['name'];
            $pro_price[]=$rec['price'];
            if($rec['gazou']==''){
                $pro_gazou[]='';
            }else{
                $pro_gazou[]='<img src="../product/gazou/'.$rec['gazou'].'">';
            }
        }
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
    <p>カートの中身</p>
    <form action="kazu_change.php" method="post">
        <!-- //カートの中身を表示する -->
        <table border="1">
            <tr>
                <td>商品</td>
                <td>商品画像</td>
                <td>価格</td>
                <td>数量</td>
                <td>小計</td>
                <td>削除</td>
            </tr>
            <?php for($i=0;$i<$max;$i++){ ?>
                <tr>
                    <td><?= $pro_name[$i]; ?></td>
                    <td><?= $pro_gazou[$i]; ?></td>
                    <td><?= $pro_price[$i].'円 '; ?></td>
                    <td><input type="text" name="kazu<?= $i ?>" value="<?= $kazu[$i];?>"></td>
                    <td><?= $pro_price[$i]*$kazu[$i]; ?>円</td>
                    <td><input type="checkbox" name="sakujo<?= $i; ?>"><br></td>
                </tr>
            <?php } ?>
        </table>
        <br>
        <input type="hidden" name="max" value="<?= $max;?>">
        <input type="submit" value="数量変更"><br>
        <input type="button" onclick="history.back()" value="戻る">
    </form>
    <br>
    <a href="shop_form.html">ご購入手続きへ進む</a><br>
</body>
</html>
