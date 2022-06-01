<?php

include_once '../backend/app/bibliotecas/conexao.php';

class CategoriaController
{
    private $conn;

    public function __construct()
    {
        $this->conn = new conexao();
    }

    public function listar()
    {
        $aRegistrosNomeados = [];
        $aRegistros = $this->conn->getSelectTabela('categoria');

        if ($aRegistros[0]) {
            foreach ($aRegistros[1] as $key => $aRegistro) {
                // Nomeia posições
                $aRegistrosNomeados[$key]['id'] = $aRegistro[0];
                $aRegistrosNomeados[$key]['descricao'] = $aRegistro[1];
                $aRegistrosNomeados[$key]['modalidade'] = $aRegistro[2];
            }

            echo json_encode($aRegistrosNomeados);
            return;
        }

        echo false;
    }

    public function remover($sId)
    {
        $result = $this->conn->getDeleteRegistro('categoria', $sId);
        echo json_encode([$result[0], $result[1]]);
    }

    public function cadastrar($params)
    {
        if (!$params) {
            echo json_encode([false, 'Nenhum dado para realizar a atualização da categoria']);
        }
        $aParametrosQuery = $this->trataParamsUrl($params);

        $result = $this->conn->getInsertRegistro('categoria', $aParametrosQuery);
        echo json_encode([true, 'Cadastrou']);
    }

    public function atualizar($params)
    {
        if (!$params) {
            echo json_encode([false, 'Nenhum dado para realizar a atualização da categoria']);
        }
        $aParametrosQuery = $this->trataParamsUrl($params);

        $result = $this->conn->getUpdateRegistro('categoria', $aParametrosQuery);
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