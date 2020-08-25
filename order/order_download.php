<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    ダウンロードしたい注文日を選んでください。<br><br>
    <?php require_once('../common/common.php'); ?>
    <form action="order_download_done.php" method="post">
        <?php pulldown_year(); ?>年
        <?php pulldown_month(); ?>月
        <?php pulldown_day(); ?>日
    <br><br>
    <input type="submit" value="ダウンロードへ">
    </form>
</body>
</html>