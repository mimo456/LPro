
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

    $inputClear='';
    $backButton='';

    require_once('../common/common.php');
    $post=sanitize($_POST);
    
    $pro_name=$post['code'];
    $pro_pass=$post['name'];
    $pro_pass2=$post['price'];
    $pro_gazou_name_old=$_POST['gazou_name_old'];
    $pro_gazou=$_FILES['gazou'];

    if ($pro_name=='') {
        echo "スタッフ名が入力されていません。<br>";
    }

    if ($pro_price=='') {
        echo "料金が入力されていません。<br>";
    }

    if ($pro_gazou['size']>0) {//画像サイズ
        if ($pro_gazou['size']>1000000) {
            echo '画像が大きすぎます';
        } else {
            move_uploaded_file($pro_gazou['tmp_name'], './gazou/'.$pro_gazou['name']);
            echo '<img src="./gazou/'.$pro_gazou['name'].'">';
            echo '<br>';
        }
    }


    if ($pro_name==''||$pro_price==''||$pro_gazou['size']>1000000) {//入力に問題があったら戻るボタンだけを表示する。
        $backButton.= <<<eof
            <form>
                <input type="button" onclick="history.back()" value="戻る">
            </form>
        eof;
        echo $backButton;
    } else {
        $inputClear.=<<<eof
            商品名:{$pro_name}<br>
            価格:{$pro_price}円
            <p>上記のように変更します。</p>
            <form action="pro_edit_done.php" method="post">
                <input type="hidden" name="code" value="$pro_code">
                <input type="hidden" name="name" value="$pro_name">
                <input type="hidden" name="price" value="$pro_price">
                <input type="hidden" name="gazou_name_old" value="$pro_gazou_name_old">
                <input type="hidden" name="gazou_name" value="{$pro_gazou['name']}">
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