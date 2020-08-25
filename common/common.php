<?php
    //サニタイズ
    function sanitize($before){
        foreach ($before as $key => $value) {
            $after[$key]=htmlspecialchars($value,ENT_QUOTES,'UTF-8');
        }
        return $after;
    }

    //年
    function pulldown_year(){
        echo '<select name="year">';
            echo '<option value="2017">2017</option>';
            echo '<option value="2018">2018</option>';
            echo '<option value="2019">2019</option>';
            echo '<option value="2020">2020</option>';
        echo '</select>';
    }

    //月
    function pulldown_month(){
        echo'<select name="month">';
            echo'<option value="1">1</option>';
            echo'<option value="2">2</option>';
            echo'<option value="3">3</option>';
            echo'<option value="4">4</option>';
            echo'<option value="5">5</option>';
            echo'<option value="6">6</option>';
            echo'<option value="7">7</option>';
            echo'<option value="8">8</option>';
            echo'<option value="9">9</option>';
            echo'<option value="10">10</option>';
            echo'<option value="11">11</option>';
            echo'<option value="12">12</option>';
        echo'</select>';
    }
    
    //日
    function pulldown_day(){
        echo'<select name="day">';
            echo'<option value="1">1</option>';
            echo'<option value="2">2</option>';
            echo'<option value="3">3</option>';
            echo'<option value="4">4</option>';
            echo'<option value="5">5</option>';
            echo'<option value="6">6</option>';
            echo'<option value="7">7</option>';
            echo'<option value="8">8</option>';
            echo'<option value="9">9</option>';
            echo'<option value="10">10</option>';
            echo'<option value="11">11</option>';
            echo'<option value="12">12</option>';
            echo'<option value="13">13</option>';
            echo'<option value="14">14</option>';
            echo'<option value="15">15</option>';
            echo'<option value="16">16</option>';
            echo'<option value="17">17</option>';
            echo'<option value="18">18</option>';
            echo'<option value="19">19</option>';
            echo'<option value="20">20</option>';
            echo'<option value="21">21</option>';
            echo'<option value="22">22</option>';
            echo'<option value="23">23</option>';
            echo'<option value="24">24</option>';
            echo'<option value="25">25</option>';
            echo'<option value="26">26</option>';
            echo'<option value="27">27</option>';
            echo'<option value="28">28</option>';
            echo'<option value="29">29</option>';
            echo'<option value="30">30</option>';
            echo'<option value="31">31</option>';
        echo'</select>';
    }
?>