<?php
    session_start();
    session_regenerate_id(true);
    if (isset($_SESSION['login'])==false) {
        echo 'ログインされていません。<br>';
        echo '<p><a href="./staff_login.php">ログイン画面へ</a></p>';
        exit();
    }else{
        echo $_SESSION['staff_name'].'さんログイン中<br><br>';
        echo 'ショップ管理トップメニュー<br><br>';
        echo '<a href="../staff/staff_list.php">スタッフ管理</a><br><br>';
        echo '<a href="../product/pro_list.php">商品管理</a><br><br>';
        echo '<a href="../order/order_download.php">注文ダウンロード</a><br><br>';
        echo '<a href="staff_logout.php">ログアウト</a>';

    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>トップ</title>
</head>
<body>
</body>
</html>