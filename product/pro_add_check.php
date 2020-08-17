<?php
    // echo "<pre>";
    // var_dump($_FILES);
    // echo "</pre>";

    session_start();
    session_regenerate_id(true);
    if (isset($_SESSION['login'])==false) {
        echo 'ログインされていません。<br>';
        echo '<p><a href="./staff_login.php">ログイン画面へ</a></p>';
        exit();
    } else {
        echo $_SESSION['staff_name'].'さんログイン中<br><br>';
        echo 'ショップ管理トップメニュー<br><br>';
        echo '<a href="../staff/staff_list.php">スタッフ管理</a><br><br>';
        echo '<a href="../product/pro_list.php">商品管理</a><br><br>';
    }

    require_once('../common/common.php');
    $post=sanitize($_POST);
    
    $pro_name=$post['name'];
    $pro_price=$post['price'];
    $pro_gazou=$_FILES['gazou'];//画像はFILESで受け取る

    if($pro_name==''){
        echo '商品名が入力されていません。<br>';
    }else{
        echo '商品名:'.$pro_name.'<br>';
    }

    if(preg_match('/\A[0-9]+\z/',$pro_price)==0){
        echo '価格をきちんと入力してください。<br>';
    }else{
        echo '価格:'.$pro_price.'円<br>';
    }

    if($pro_gazou['size']>0){//画像サイズ
        if($pro_gazou['size']>1000000){
            echo '画像が大きすぎます';
        }else{
            move_uploaded_file($pro_gazou['tmp_name'],'./gazou/'.$pro_gazou['name']);
            echo '<img src="./gazou/'.$pro_gazou['name'].'">';
            echo '<br>';
        }
    }

    if($pro_name==''||preg_match('/\A[0-9]+\z/',$pro_price)==0||$pro_gazou['size']>1000000){
        $formText=<<<EOF
            <input type="button" onclick="history.back()" value="戻る">
        EOF;
        echo $formText;
    }else {
        $formText=<<<EOF
            <form action="pro_add_done.php" method="post">
                <input type="hidden" name="name" value="{$pro_name}">
                <input type="hidden" name="price" value="{$pro_price}">
                <input type="hidden" name="gazou" value="{$pro_gazou['name']}">
                <input type="button" onclick="history.back()" value="戻る">
                <input type="submit" value="OK">
            </form>
        EOF;
        echo $formText;
    }

