<?php
// Incializa a sessao
if(!isset($_SESSION)) session_start();

// Cria a conexao com o banco
$conexao = mysqli_connect('localhost','root','','rango');

// Se houver erro na conexao, mata o código exibindo o erro
if(mysqli_errno($conexao)){
    die(mysqli_error($conexao));
}

mysqli_set_charset($conexao, 'utf8');

// Permite conexões ajax de qualquer origem
// Essencial para o webservice do app mobile
header('Access-Control-Allow-Origin: *');