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
        
        if($pro_gazou_name==''||$pro_gazou_name==NULL){
            $disp_gazou='';
        }else{
            $disp_gazou='<img src="./gazou/'.$pro_gazou_name.'">';
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
    <title>Document</title>
</head>
<body>
    <p>商品情報参照</p>
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