<?php
    $tsuki=$_POST['tsuki'];

    $yasai=array('','ブロッコリー','カリフラワー','レタス','みつば','アスパラガス','セロリ','ナス','ピーマン','オクラ','さつまいも','大根','ほうれんそう');

    echo $tsuki.'月は'.$yasai[$tsuki].'が旬です';
?>