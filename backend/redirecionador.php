<?php

include './app/controller/PessoaController.php';
include './app/controller/CategoriaController.php';
include './app/controller/ProdutoController.php';
include './app/controller/VendaController.php';

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
            case 'produto':
                $this->produto($controllerRota);
                break;
            case 'venda':
                $this->venda($controllerRota);
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
        $this->redirecionaController($controller, $controllerRota);
    }

    public function categoria($controllerRota)
    {
        $controller = new CategoriaController();
        $this->redirecionaController($controller, $controllerRota);
    }

    public function produto($controllerRota)
    {
        $controller = new ProdutoController();
        $this->redirecionaController($controller, $controllerRota);
    }

    public function venda($controllerRota)
    {
        $controller = new VendaController();
        $this->redirecionaController($controller, $controllerRota);
    }

    public function redirecionaController($controller, $controllerRota)
    {
        switch ($controllerRota[2]) {
            case 'listar':
                $controller->listar();
                break;
            case 'venda':
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