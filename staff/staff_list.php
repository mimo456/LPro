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

    try{
        $dsn= "mysql:dbname=shop;host=localhost;charset=utf8";
        $user='root';
        $password='';
        $dbh=new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//例外を投げる

        $sql='SELECT code,name FROM mst_staff WHERE 1';
        $stmt=$dbh->prepare($sql);
        $stmt->execute();

        $dbh=null;

    }catch(Exsetion $e){
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
    
    <form action="staff_branch.php" method="post">
        <?php 
            while(true){
                $rec=$stmt->fetch(PDO::FETCH_ASSOC);
                if($rec==false){
                    break;
                }
                echo '<input type="radio" name="staffcode" value="'.$rec['code'].'">';
                echo $rec['name'].'<br>';
            }
        ?>
        <input type="submit" name="disp" value="参照">
        <input type="submit" name="add" value="追加">
        <input type="submit" name="edit" value="修正">
        <input type="submit" name="delete" value="削除">
    </form>
    <p><a href="../staff_login/staff_top.php">トップページへ</a></p>
</body>
</html>