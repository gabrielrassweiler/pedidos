<?php

include_once '../backend/app/bibliotecas/conexao.php';

class ProdutoController
{
    private $conn;

    public function __construct()
    {
        $this->conn = new conexao();
    }

    public function listar()
    {
        $aRegistrosNomeados = [];
        $aRegistros = $this->conn->getSelectTabela('produto');

        if ($aRegistros[0]) {
            foreach ($aRegistros[1] as $key => $aRegistro) {
                // Busca a descricao da categoria
                $aResult = $this->conn->getSelectRegistroFromCodigo('categoria', $aRegistro[1]);
                if ($aResult[0]) {
                    $sCategoria = $aRegistro[1] . ' - ' . $aResult[1][0][1];
                } else {
                    echo false;
                    return;
                }

                // Nomeia posições
                $aRegistrosNomeados[$key]['id'] = $aRegistro[0];
                $aRegistrosNomeados[$key]['categoria'] = $sCategoria;
                $aRegistrosNomeados[$key]['titulo'] = $aRegistro[2];
                $aRegistrosNomeados[$key]['valor'] = $aRegistro[3];
                $aRegistrosNomeados[$key]['descricao'] = $aRegistro[4];
                $aRegistrosNomeados[$key]['imagem'] = $aRegistro[5];
            }

            echo json_encode($aRegistrosNomeados);
            return;
        }

        echo false;
    }

    public function remover($sId)
    {
        $result = $this->conn->getDeleteRegistro('produto', $sId);
        echo json_encode([$result[0], $result[1]]);
    }

    public function cadastrar($params)
    {
        if (!$params) {
            echo json_encode([false, 'Nenhum dado para realizar a atualização do produto']);
        }
        $aParametrosQuery = $this->trataParamsUrl($params);

        $result = $this->conn->getInsertRegistro('produto', $aParametrosQuery);
        echo json_encode([true, 'Cadastrou']);
    }

    public function atualizar($params)
    {
        if (!$params) {
            echo json_encode([false, 'Nenhum dado para realizar a atualização do produto']);
        }
        $aParametrosQuery = $this->trataParamsUrl($params);

        $result = $this->conn->getUpdateRegistro('produto', $aParametrosQuery);
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