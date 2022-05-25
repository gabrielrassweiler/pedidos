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
}
