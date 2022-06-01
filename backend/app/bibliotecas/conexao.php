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
            $result = $stmt->fetchAll(PDO::FETCH_NUM);

            return $result ? [true, $result] : [false, 'Falha ao executar sql'];
        } catch (Exception $e) {
            return [false, 'Falha ao executar sql: ' . $e->getMessage()];
        }
    }

    /**
     * Busca todos os registros de acordo com a tabela passada como parametro.
     */
    public function getSelectTabela($sTabela){
        $sSql = "SELECT * FROM {$sTabela} order by id desc";
        return $this->executaSql($sSql);
    }

    /**
     * Busca os dados do registro de acordo com a tabela e chave passadas como paramêtro.
     */
    public function getSelectRegistroFromCodigo($sTabela, $id) {
        $sSql =  "SELECT * FROM {$sTabela} WHERE id = {$id}";
        return $this->executaSql($sSql);
    }

    /**
     * Deleta o registro de acordo com a tabela e chave passadas como paramêtro.
     */
    public function getDeleteRegistro($sTabela, $id) {
        $sSql =  "DELETE FROM {$sTabela} WHERE id = {$id} ";
        return $this->executaSql($sSql);
    }

    /**
     * Realiza a inserção de um registro de acordo com os paramêtros passados.
     */
    public function getInsertRegistro($sTabela, $aRegistros){
        $sSql = '';

        switch($sTabela){
            case 'pessoa':
                $sSql = "INSERT INTO {$sTabela} (nome, sexo, idade, cpf, email, telefone, cep) VALUES (
                '". $aRegistros['nome'] ."', '". $aRegistros['sexo'] ."', '". $aRegistros['idade'] ."', '". $aRegistros['cpf'] ."',
                '". $aRegistros['email'] ."', '". $aRegistros['telefone'] ."', '". $aRegistros['cep'] ."')";
                break;
            case 'categoria':
                $sSql = "INSERT INTO {$sTabela} (descricao, modalidade) VALUES (
                '". $aRegistros['descricao'] ."', '". $aRegistros['modalidade'] ."')";
                break;
            case 'produto':
                $sSql = "INSERT INTO {$sTabela} (categoria_id, titulo, valor, descricao) VALUES (
                '". $aRegistros['categoria'] ."', '". $aRegistros['titulo'] ."', '". $aRegistros['valor'] ."', '". $aRegistros['descricao'] ."')";
                break;
            case 'venda':
                $sSql = "INSERT INTO {$sTabela} (id, pessoa_id, produto_id, quantidade, situacao) VALUES ('". $aRegistros['id'] ."', 
                '". $aRegistros['pessoa'] ."', '". $aRegistros['produto'] ."', '". $aRegistros['quantidade'] ."', '". $aRegistros['situacao'] ."')";
                break;
            case 'usuario':
                $sSql = "INSERT INTO {$sTabela} (login, usuario) VALUES ('". $aRegistros['login'] ."', '". $aRegistros['usuario'] ."')";
                break;
        }

        return !$sSql ? 'Falha ao gerar sql para inserir registro' : $this->executaSql($sSql);
    }

    /**
     * Realiza a alteração do registro de acordo com o código do registro
     * e as informações passadas como paramêtro.
     */
    public function getUpdateRegistro($sTabela, $aRegistros){
        switch($sTabela){
            case 'pessoa':
                $sSql = "UPDATE {$sTabela} SET nome = '". $aRegistros['nome'] ."', sexo = '". $aRegistros['sexo'] ."',
                idade = '". $aRegistros['idade'] ."', cpf = '". $aRegistros['cpf'] ."', email = '". $aRegistros['email'] ."',
                telefone = '". $aRegistros['telefone'] ."', cep = '". $aRegistros['cep'] ."' WHERE id = " . $aRegistros['id'];
                break;
            case 'categoria':
                $sSql = "UPDATE  {$sTabela} SET descricao = '". $aRegistros['descricao'] ."', modalidade = '". $aRegistros['modalidade'] ."' 
                WHERE id = " . $aRegistros['id'];
                break;
            case 'produto':
                $sSql = "UPDATE {$sTabela} SET categoria_id = '". $aRegistros['categoria'] ."', titulo = '". $aRegistros['titulo'] ."',
                valor = '". $aRegistros['valor'] ."', descricao = '". $aRegistros['descricao'] ."' WHERE id = " . $aRegistros['id'];
                break;
            case 'venda':
                $sSql = "UPDATE {$sTabela} SET pessoa_id = '". $aRegistros['pessoa'] ."', produto_id = '". $aRegistros['produto'] ."',
                quantidade = '". $aRegistros['quantidade'] ."', situacao = '". $aRegistros['situacao'] ."' WHERE id = " . $aRegistros['id'];
                break;
            case 'usuario':
                $sSql = "UPDATE {$sTabela} SET login = '". $aRegistros['login'] ."', usuario = '". $aRegistros['usuario'] ."' WHERE id = " . $aRegistros['id'];
                break;
        }

        return $this->executaSql($sSql);
    }
}