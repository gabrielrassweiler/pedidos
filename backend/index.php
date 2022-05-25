<?php
    include_once './redirecionador.php';
    header('Access-Control-Allow-Origin: *');

    $rotasPermitidas = require_once('./app/routes/index.php');
    (new redirecionador($rotasPermitidas))->rota($_SERVER['PATH_INFO']);
