<?php
    header('Access-Control-Allow-Origin: *');
    include_once './redirecionador.php';

    $rotasPermitidas = require_once('./app/routes/index.php');
    (new redirecionador($rotasPermitidas))->rota($_SERVER['PATH_INFO']);
