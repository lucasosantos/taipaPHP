<?php

namespace App\core;
use App\db\database;
use PDOException;
use App\helpers\SqlHelper;
use PDO;

class Model {

    protected $table;
    protected $columns = array();

    private function getCon(){
        $con = new Database;
        return $con->getCon();
    }

    public function insert(array $colunas, array $valores) {

        $str_colunas = SqlHelper::Sql_concat($colunas);
        $str_interro = SqlHelper::Sql_interro($valores);

        try {
            $stmt = $this->getCon()->prepare("INSERT INTO " . $this->table . " (" . $str_colunas . ") VALUES (" . $str_interro . ")");
            $stmt = SqlHelper::Sql_prep($stmt, $valores);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }

    }

    public function listAll()
    {
        try {
            $stmt = $this->getCon()->prepare("SELECT * FROM" . $this->table);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro: ".$e->getMessage();
            return false;
        }
    }

    public function listWhere($coluna,$condicao)
    {
        try {
            $stmt = $this->getCon()->prepare("SELECT * FROM " . $this->table . " WHERE " . $coluna . " = ?");
            $stmt = SqlHelper::Sql_prep($stmt, array($condicao));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getOne($condicao, string $coluna) {
        try {
            $stmt = $this->getCon()->prepare("SELECT * FROM " . $this->table . " WHERE " . $coluna . " = ?");
            $stmt = SqlHelper::Sql_prep($stmt, array($condicao));
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($condicao, string $coluna) {
        # code...
    }

    public function update($condicao, string $coluna, $coluna_alteracao, $novo_valor) {
        # code...
    }
}

?>