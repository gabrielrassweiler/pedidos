<?php

include_once '../backend/app/bibliotecas/conexao.php';

class VendaController
{
    private $conn;

    public function __construct()
    {
        $this->conn = new conexao();
    }

    public function cadastrar($params)
    {
        if (!$params) {
            echo json_encode([false, 'Nenhum dado para realizar o cadastramento da venda']);
        }
        $aParametrosQuery = $this->trataParamsUrl($params);

        $result = $this->conn->getInsertRegistro('venda', $aParametrosQuery);
        echo json_encode([true, 'Cadastrou']);
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