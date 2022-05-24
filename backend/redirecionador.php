<?php

include './app/controller/PessoaController.php';

class redirecionador {
    public function rota($rota)
    {
        if (!$rota) {
            echo json_encode([false, 'Rota incorreta, entre em contato com o administrador do sistema']);
        }

        $controllerRota = explode('@', $rota);
        $controller = new PessoaController();

        switch ($controllerRota[1]) {
            case 'listar':
                $controller->listar();
                break;
            case 'cadastrar':
                $controller->cadastrar();
                break;
            case 'remover':
                $controller->remover();
                break;
            case 'atualizar':
                $controller->atualizar();
                break;
        }
    }
}