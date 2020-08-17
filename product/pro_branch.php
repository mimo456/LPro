<?php
    session_start();
    session_regenerate_id(true);
    if (isset($_SESSION['login'])==false) {
        echo 'ログインされていません。<br>';
        echo '<a href="../staff_login/staff_login.php">ログイン画面へ</a>';
        exit();
    }

    if (isset($_POST['disp'])==true) {//参照

        if (isset($_POST['procode'])==false) {
            header('Location:pro_ng.php');
            exit();
        }
        $pro_code=$_POST['procode'];
        header('Location:pro_disp.php?procode='.$pro_code);
        exit();
    }

    if (isset($_POST['add'])==true) {//追加
        $pro_code=$_POST['procode'];
        header('Location:pro_add.php');
        exit();
    }

    if (isset($_POST['edit'])==true) {//更新
        if (isset($_POST['procode'])==false) {
            header('Location:pro_ng.php');
            exit();
        }
        $pro_code=$_POST['procode'];
        header('Location:pro_edit.php?procode='.$pro_code);
        exit();
    }
    if (isset($_POST['delete'])==true) {//削除
        if (isset($_POST['procode'])==false) {
            header('Location:pro_ng.php');
            exit();
        }

        $pro_code=$_POST['procode'];
        header('Location:pro_delete.php?procode='.$pro_code);
        exit();
    }
