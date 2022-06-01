<?php

$rota['/pessoa'] = 'PessoaController@listar';
$rota['/pessoa/cadastrar'] = 'PessoaController@cadastrar';
$rota['/pessoa/remover'] = 'PessoaController@remover';
$rota['/pessoa/atualizar'] = 'PessoaController@atualizar';

$rota['/categoria'] = 'CategoriaController@listar';
$rota['/categoria/cadastrar'] = 'CategoriaController@cadastrar';
$rota['/categoria/remover'] = 'CategoriaController@remover';
$rota['/categoria/atualizar'] = 'CategoriaController@atualizar';

$rota['/produto'] = 'ProdutoController@listar';
$rota['/produto/cadastrar'] = 'ProdutoController@cadastrar';
$rota['/produto/remover'] = 'ProdutoController@remover';
$rota['/produto/atualizar'] = 'ProdutoController@atualizar';

$rota['/venda/cadastrar'] = 'VendaController@venda';

return $rota;
