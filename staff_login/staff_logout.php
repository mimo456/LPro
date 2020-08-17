<?php
    session_start();
    $_SESSION=array();//セッション変数を空にしている。
    if(isset($_COOKIE[session_name()])==true){
        setcookie(session_name(),'',time()-42000,'/');
        //ブラウザ側ではクッキーとしてsession_idが保存されている（ブラウザとサーバーの合言葉）、ブラウザ側ではsession_name()をkeyとして保存されている。
        //第2引数のvalueを''にして、valueの中身を空にしている。,
    
    }
    session_destroy();//セッションを破棄する。
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
    ログアウトしました。<br>
    <a href="../staff_login/staff_login.php">ログイン画面へ</a>
</body>
</html>