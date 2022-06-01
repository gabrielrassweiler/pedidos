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
        $aRegistrosNomeados = [];
        $aRegistros = $this->conn->getSelectTabela('pessoa');

        if ($aRegistros[0]) {
            foreach ($aRegistros[1] as $key => $aRegistro) {
                // Nomeia posições
                $aRegistrosNomeados[$key]['id'] = $aRegistro[0];
                $aRegistrosNomeados[$key]['nome'] = $aRegistro[1];
                $aRegistrosNomeados[$key]['sexo'] = $aRegistro[2];
                $aRegistrosNomeados[$key]['idade'] = $aRegistro[3];
                $aRegistrosNomeados[$key]['cpf'] = $aRegistro[4];
                $aRegistrosNomeados[$key]['email'] = $aRegistro[5];
                $aRegistrosNomeados[$key]['telefone'] = $aRegistro[6];
                $aRegistrosNomeados[$key]['cep'] = $aRegistro[7];
            }

            echo json_encode($aRegistrosNomeados);
            return;
        }

        echo false;
    }

    public function remover($sId)
    {
        $result = $this->conn->getDeleteRegistro('pessoa', $sId);
        echo json_encode([$result[0], $result[1]]);
    }

    public function cadastrar($params)
    {
        if (!$params) {
            echo json_encode([false, 'Nenhum dado para realizar a atualização da pessoa']);
        }
        $aParametrosQuery = $this->trataParamsUrl($params);

        $result = $this->conn->getInsertRegistro('pessoa', $aParametrosQuery);
        echo json_encode([true, 'Cadastrou']);
    }

    public function atualizar($params)
    {
        if (!$params) {
            echo json_encode([false, 'Nenhum dado para realizar a atualização da pessoa']);
        }
        $aParametrosQuery = $this->trataParamsUrl($params);

        $result = $this->conn->getUpdateRegistro('pessoa', $aParametrosQuery);
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