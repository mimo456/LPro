<?php
class DB
{
    //MySQL�Ƃ���������N���X
    private $USER = "root";
    private $PW   = ""; //�������p�X���[�h��ݒ肵�Ă�������
    private $dns  = "mysql:dbname=salesmanagement;host=localhost;charset=utf8";

    private function Connectdb()
    {
        try {
            $pdo = new PDO($this->dns, $this->USER, $this->PW);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (Exception $e) {
            echo '�������܏�Q�ɂ���ς����f�����|�����Ă���܂��B';
            return false;
        }
    }

    public function executeSQL($sql)
    {
        //SQL�����s����֐�
        try {
            if (!$pdo = $this->Connectdb()) {
                return false;
            }
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $pdo=null;//�f�[�^�x�[�X�ؒf
            return $stmt;   //�߂�l��PDOStatement�̃C���X�^���X
        } catch (Exception $e) {
            echo '�������܏�Q�ɂ���ς����f�����|�����Ă���܂��B';
            return false;
        }
    }
}
