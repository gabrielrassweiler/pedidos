<?php
    include_once './redirecionador.php';
    header('Access-Control-Allow-Origin: *');

    $rotas = require_once('./app/routes/index.php');
    (new redirecionador)->rota($rotas[$_SERVER['PATH_INFO']]);
