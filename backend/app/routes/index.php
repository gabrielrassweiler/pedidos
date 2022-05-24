<?php

$rota['/pessoa'] = 'PessoaController@listar';
$rota['/pessoa/cadastrar'] = 'PessoaController@cadastrar';
$rota['/pessoa/remover'] = 'PessoaController@remover';
$rota['/pessoa/atualizar'] = 'PessoaController@atualizar';

return $rota;
