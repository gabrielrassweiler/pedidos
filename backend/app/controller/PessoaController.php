<?php

class PessoaController
{
    public function cadastrar()
    {
        echo json_encode([true, 'cadastrou']);
    }

    public function listar()
    {
        echo json_encode([
            [
                'id' => '1',
                'nome' => 'Gabriel',
                'idade' => 20,
                'cpf' => '11976432901',
                'email' => 'gabriel_rassweiler@hotmail.com',
            ],
            [
                'id' => '2',
                'nome' => 'Julia',
                'idade' => 19,
                'cpf' => '11976432902',
                'email' => 'julia@hotmail.com',
            ]
        ]);
    }

    public function remover()
    {
        echo json_encode([true, 'remover']);
    }

    public function atualizar()
    {
        echo json_encode([true, 'atualizou']);
    }
}