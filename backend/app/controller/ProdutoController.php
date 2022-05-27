<?php

//include_once '../bibliotecas/conexao.php';

class ProdutoController
{
//    private $conn;

    public function __construct()
    {
//        $this->conn = new conexao();
    }

    public function listar()
    {
        echo json_encode([
            [
                'id' => '1',
                'categoria' => 1,
                'titulo' => 'Gabriel',
                'descricao' => 'Gabriel',
                'valor' => 20,
            ],
            [
                'id' => '2',
                'categoria' => 2,
                'titulo' => 'Fulle',
                'descricao' => 'Vendendo o fulle',
                'valor' => 0.01,
            ]
        ]);
    }

    public function remover($params)
    {
        $id = explode('=', $params)[1];
        echo json_encode([true, 'removeu']);
    }

    public function cadastrar($params)
    {
        try {
            if (!$params) {
                echo json_encode([false, 'Nenhum dado para realizar a atualização da pessoa']);
            }
            $aParametrosQuery = $this->trataParamsUrl($params);

            $result = $this->conn->executaSql("
                INSERT INTO pessoa (nome, sexo, idade, cpf, email, telefone, cep) values (
                    {$aParametrosQuery['nome']}, {$aParametrosQuery['sexo']}, {$aParametrosQuery['idade']},
                    {$aParametrosQuery['cpf']}, {$aParametrosQuery['email']}, {$aParametrosQuery['telefone']},
                    {$aParametrosQuery['cep']},
                )
            ");
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