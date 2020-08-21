<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php

        // echo '<pre>';
        // var_dump($_POST);
        // echo '</pre>';

        require_once('../common/common.php');

        $post=sanitize($_POST);

        $onamae=$post['onamae'];
        $email=$post['email'];
        $postal1=$post['postal1'];
        $postal2=$post['postal2'];
        $address=$post['address'];
        $tel=$post['tel'];
        $okflg=true;


        if($onamae==''){
            echo 'お名前が入力されていません。<br><br>';
            $okflg=false;
        }else{
            echo 'お名前<br>'.$onamae.'<br><br>';
        }

        if (preg_match('/\A[\w\-\.]+\@[\w\-\.]+\.([a-z]+)\z/',$email)==0) {
            echo 'メールアドレスを正確に入力してください。<br><br>';
            $okflg=false;
        }else{
            echo 'メールアドレス<br>'.$email.'<br><br>';
        }

        if (preg_match('/\A[0-9]+\z/', $postal1)==0) {
            echo '郵便番号は半角数字で入力してください。<br><br>';
            $okflg=false;
        }else{
            echo '郵便番号<br>'.$postal1.'-'.$postal2.'<br><br>';
        }

        // if (preg_match('/\A[0-9]+\z/', $postal2)==0) {
        //     echo '郵便番号は半角数字で入力してください。<br><br>';
        // }else{
        //     echo $postal2.'<br>';
        // }

        if($address==''){
            echo '住所が入力されていません。<br><br>';
            $okflg=false;
        }else{
            echo '住所<br>'.$address.'<br><br>';
        }

        if (preg_match('/\A\d{2,5}-?\d{2,5}-?\d{4,5}\z/', $tel)==0) {
            echo '電話番号を正確に入力してください。<br><br>';
            $okflg=false;
        }else{
            echo '電話番号<br>'.$tel.'<br><br>';
        }

        if($okflg==true){
            $form=<<<EOF
            <form action="shop_form_done.php" method="post">
                <input type="hidden" name="onamae" value="{$onamae}">
                <input type="hidden" name="email" value="{$email}">
                <input type="hidden" name="postal1" value="{$postal1}">
                <input type="hidden" name="postal2" value="{$postal2}">
                <input type="hidden" name="address" value="{$address}">
                <input type="hidden" name="tel" value="{$tel}">
                <input type="submit" value="OK"><br>
            </form>
            EOF;
            echo $form;
        }else{
            $form=<<<EOF
                <form>
                    <input type="button" value="戻る" onclick="history.back()">
                </form>
            EOF;
            echo $form;
        }
        
    ?>

    
</body>
</html>
