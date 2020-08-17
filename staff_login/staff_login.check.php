<?php
    try {
        require_once('../common/common.php');
        $post=sanitize($_POST);
        
        $staff_code=$post['code'];
        $staff_pass=$post['pass'];

        //$staff_pass=password_hash($staff_pass, PASSWORD_DEFAULT);//より強力な暗号化

        //echo $staff_code.'<br>',$staff_pass;

        //データベースに接続
        $dsn= "mysql:dbname=shop;host=localhost;charset=utf8";
        $user='root';
        $password='';
        $dbh=new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//例外 を投げる

        $sql='SELECT name,password FROM mst_staff WHERE code=?';
        $stmt=$dbh->prepare($sql);
        $stmt->execute(array($staff_code));//SQL文で指示を出す

        $dbh=null;


        $rec=$stmt->fetch(PDO::FETCH_ASSOC);

        if(password_verify($staff_pass,$rec['password'])){
            //セッションの開始
            session_start();
            $_SESSION['login']=1;
            $_SESSION['staff_code']=$staff_code;
            $_SESSION['staff_name']=$rec['name'];
            header('Location:staff_top.php');
            exit();
        }else{
            echo 'スタッフコードかパスワードが間違っています<br>';
            echo '<a href=staff_login.php>戻る</a>';
        }


    } catch (Expection $e) {
        print 'ただいま障害により大変ご迷惑をお掛けしております。';
        exit();//強制終了
    }
?>