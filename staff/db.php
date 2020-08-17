<?php
class DB
{
    //MySQLとやり取りをするクラス
    private $USER = "root";
    private $PW   = ""; //正しいパスワードを設定してください
    private $dns  = "mysql:dbname=salesmanagement;host=localhost;charset=utf8";

    private function Connectdb()
    {
        try {
            $pdo = new PDO($this->dns, $this->USER, $this->PW);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (Exception $e) {
            echo 'ただいま障害により大変ご迷惑をお掛けしております。';
            return false;
        }
    }

    public function executeSQL($sql)
    {
        //SQLを実行する関数
        try {
            if (!$pdo = $this->Connectdb()) {
                return false;
            }
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $pdo=null;//データベース切断
            return $stmt;   //戻り値はPDOStatementのインスタンス
        } catch (Exception $e) {
            echo 'ただいま障害により大変ご迷惑をお掛けしております。';
            return false;
        }
    }
}
