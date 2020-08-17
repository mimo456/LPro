
<?php
    echo "<pre>";
    echo var_dump($_POST);
    echo "</pre>";

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


    $inputClear='';
    $backButton='';

    require_once('../common/common.php');
    $post=sanitize($_POST);
    
    $staff_name=$post['name'];
    $staff_pass=$post['pass'];
    $staff_pass2=$post['pass2'];


    if($staff_name==''){
        echo "スタッフ名が入力されていません。<br>";
    }

    if($staff_pass==''){
        echo "パスワードが入力されていません。<br>";
    }

    if($staff_pass!=$staff_pass2){
        echo "パスワードが一致しません。<br>";
    }

    if($staff_name==''||$staff_pass==''||$staff_pass!=$staff_pass2){//入力に問題があったら戻るボタンだけを表示する。
        $backButton.= <<<eof
            <form>
                <input type="button" onclick="history.back()" value="戻る">
            </form>
        eof;
        echo $backButton;
    }else{
        // $staff_pass=md5($staff_pass);
        $staff_pass=password_hash($staff_pass, PASSWORD_DEFAULT);//より強力な暗号化
        $inputClear.=<<<eof
            <form action="staff_add_done.php" method="post">
                <input type="hidden" name="name" value="$staff_name">
                <input type="hidden" name="pass" value="$staff_pass">
                <input type="button" onclick="history.back()" value="戻る">
                <input type="submit" value="OK">
            </form>
        eof;
        echo $inputClear;
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
    
</body>
</html>