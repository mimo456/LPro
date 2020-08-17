<?php
    session_start();
    session_regenerate_id(true);
    if(isset($_SESSION['login'])==false){
        echo 'ログインされていません。<br>';
        echo '<a href="../staff_login/staff_login.php">ログイン画面へ</a>';
        exit();
    }

    if (isset($_POST['disp'])==true) {//参照

        if (isset($_POST['staffcode'])==false) {
            header('Location:staff_ng.php');
            exit();
        }
        $staff_code=$_POST['staffcode'];
        header('Location:staff_disp.php?staffcode='.$staff_code);
        exit();
    }

    if (isset($_POST['add'])==true) {//追加
        $staff_code=$_POST['staffcode'];
        header('Location:staff_add.php');
        exit();
    }

    if(isset($_POST['edit'])==true){//更新
        if(isset($_POST['staffcode'])==false){
            header('Location:staff_ng.php');
            exit();
        }
        $staff_code=$_POST['staffcode'];
        header('Location:staff_edit.php?staffcode='.$staff_code);
        exit();
    }
    if(isset($_POST['delete'])==true){//削除
        if (isset($_POST['staffcode'])==false) {
            header('Location:staff_ng.php');
            exit();
        }

        $staff_code=$_POST['staffcode'];
        header('Location:staff_delete.php?staffcode='.$staff_code);
        exit();
    }
?>