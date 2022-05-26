<?php

include './app/controller/PessoaController.php';
include './app/controller/CategoriaController.php';

class redirecionador {
    private $rotasPermitidas;

    public function __construct($rotasPermitidas)
    {
        $this->rotasPermitidas = $rotasPermitidas;
    }

    public function rota($rota)
    {
        $controllerRota = $this->validaUrl($rota);
        if (!$controllerRota[0]) {
            echo json_encode([false, 'Rota incorreta, entre em contato com o administrador do sistema']);
        }

        switch ($controllerRota[1]) {
            case 'pessoa':
                $this->pessoa($controllerRota);
                break;
            case 'categoria':
                $this->categoria($controllerRota);
                break;
        }
    }

    public function validaUrl($rota)
    {
        $paramRota = explode('/', $rota);
        // Retira a primeira posição pois ele seta a primeira posição por causa da primeira barra
        unset($paramRota[0]);

        if (count($paramRota) === 3) {
            // Monta rota sem param para verificar se esta entre as permitidas
            $rotaSemParam = '/' . $paramRota[1] . '/' . $paramRota[2];
            $permiteRota = $this->rotasPermitidas[$rotaSemParam];
            if (!$permiteRota) {
                return [false];
            }

            $controllerRota = explode('@', $permiteRota);
            return [true, $paramRota[1], $controllerRota[1], $paramRota[3]];
        } else {
            $permiteRota = $this->rotasPermitidas[$rota];
            if (!$permiteRota) {
                return [false];
            }
            $controllerRota = explode('@', $permiteRota);
            return [true, $paramRota[1], $controllerRota[1]];
        }
    }

    public function pessoa($controllerRota)
    {
        $controller = new PessoaController();
        switch ($controllerRota[2]) {
            case 'listar':
                $controller->listar();
                break;
            case 'cadastrar':
                $controller->cadastrar($controllerRota[3]);
                break;
            case 'remover':
                $controller->remover($controllerRota[3]);
                break;
            case 'atualizar':
                $controller->atualizar($controllerRota[3]);
                break;
        }
    }

    public function categoria($controllerRota)
    {
        $controller = new CategoriaController();
        switch ($controllerRota[2]) {
            case 'listar':
                $controller->listar();
                break;
            case 'cadastrar':
                $controller->cadastrar($controllerRota[3]);
                break;
            case 'remover':
                $controller->remover($controllerRota[3]);
                break;
            case 'atualizar':
                $controller->atualizar($controllerRota[3]);
                break;
        }
    }
}