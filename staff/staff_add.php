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
    <h1>スタッフ追加</h1>
    <form action="staff_add_check.php" method="post">
        <p>スタッフ名を入力してください。</p>
        <p><input type="text" name="name" style="width:200px"></p>
        <p>パスワードを入力してください。</p>
        <p><input type="password" name="pass" style="width:100px"></p>
        <p>パスワードをもう一度入力してください。</p>
        <p><input type="password" name="pass2" style="width:100px"></p>
        <input type="button" value="戻る" onclick="history.back()">
        <input type="submit" value="OK">
    </form>
</body>
</html>