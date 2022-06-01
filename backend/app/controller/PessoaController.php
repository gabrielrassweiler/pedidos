<?php

include_once '../backend/app/bibliotecas/conexao.php';

class PessoaController
{
    private $conn;

    public function __construct()
    {
        $this->conn = new conexao();
    }

    public function listar()
    {
        $aRegistros = $this->conn->getSelectTabela('pessoa');
        echo json_encode($aRegistros);
    }

    public function remover($params)
    {
        $id = explode('=', $params)[1];
        $this->conn->getDeleteRegistro('pessoa', $id);
        echo json_encode([true, 'removeu']);
    }

    public function cadastrar($params)
    {
        try {
            if (!$params) {
                echo json_encode([false, 'Nenhum dado para realizar a atualização da pessoa']);
            }
            $aParametrosQuery = $this->trataParamsUrl($params);

            $result = $this->conn->getInsertRegistro('pessoa', $aParametrosQuery, count($aParametrosQuery));
            echo json_encode($result);
        } catch(PDOException $e) {
            echo json_encode([true, 'ERROR SQL: ' . $e->getMessage()]);
        }

        echo json_encode([true, 'cadastrou']);
    }

    public function atualizar($params)
    {
        try {
            if (!$params) {
                echo json_encode([false, 'Nenhum dado para realizar a atualização da pessoa']);
            }
            $aParametrosQuery = $this->trataParamsUrl($params);

            $result = $this->conn->executaSql("
                update pessoa set
                    nome = {$aParametrosQuery['id']},
                    sexo = {$aParametrosQuery['sexo']},
                    idade = {$aParametrosQuery['idade']},
                    cpf = {$aParametrosQuery['cpf']},
                    email = {$aParametrosQuery['email']},
                    telefone = {$aParametrosQuery['telefone']},
                    cep = {$aParametrosQuery['cep']},
                    where id = {$aParametrosQuery['id']}
            ");
        } catch(PDOException $e) {
            echo json_encode([true, 'ERROR SQL: ' . $e->getMessage()]);
        }

        echo json_encode([true, 'atualizou']);
    }

    public function trataParamsUrl($params)
    {
        $paramQuery = explode('&', $params);

        $aParametrosQuery = [];
        foreach ($paramQuery as $param) {
            $parametro = explode('=', $param);
            $aParametrosQuery[$parametro[0]] = $parametro[0] === 'email'
                ? str_replace('!', '.', $parametro[1])
                : $parametro[1];
        }

        return $aParametrosQuery;
    }
}