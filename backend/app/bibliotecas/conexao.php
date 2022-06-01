<?php

class conexao {
    private $dataBase = 'pedidos';
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function __construct()
    {
        try {
            $conn = new PDO(
                "mysql:host={$this->host};dbname={$this->dataBase}",
                $this->username,
                $this->password
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this->conn = $conn;
        } catch (PDOException $e) {
            echo json_encode([false, 'Falha ao conectar com o banco de dados']);
        }
    }

    public function getConn()
    {
        return $this->conn;
    }

    public function executaSql($sql)
    {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_NUM);
        } catch (Exception $e) {
            echo json_encode([false, 'Falha ao buscar os dados']);
        }
    }

    /**
     * Busca todos os registros de acordo com a tabela passada como parametro.
     */
    public function getSelectTabela($sTabela){
        $sSql = "SELECT * FROM {$sTabela}";
        return $this->executaSql($sSql);
    }

    /**
     * Deleta o registro de acordo com a tabela e chave passadas como paramêtro.
     */
    public function getDeleteRegistro($sTabela, $iCodigo) {
        $sSql =  "DELETE FROM {$sTabela} WHERE id = {$iCodigo} ";
        return $this->executaSql($sSql);
    }

    /**
     * Busca os dados do registro de acordo com a tabela e chave passadas como paramêtro.
     */
    public function getSelectRegistroFromCodigo($sTabela, $iCodigo) {
        $sSql =  "SELECT * FROM {$sTabela} WHERE id = {$iCodigo}";
        return $this->executaSql($sSql);
    }

    public function getInsertRegistro($sTabela, $aParametros, $tamParametros){
        $sSql = "INSERT INTO {$sTabela} (";

        foreach ($aParametros as $parametro) {
            $sSql .= "{$parametro}, ";
        }
        $sSql = substr($sSql, 0, -2);

        foreach () {

        }
    }
}