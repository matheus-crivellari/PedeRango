<?php
// Inicia a sessão
if(!isset($_SESSION)) session_start();

// Se nao houver usuário definido na sessao
if(!isset($_SESSION['codigo_usuario'])){
    $_SESSION['erro'] = 'Somente usuários cadastrados podem visualizar este conteúdo.';
    header('Location: index.php');
    exit;
}

// Se passar na validação acima então tem tipo
// Mas se não for nenhum dos tipos permitidos
// redireciona
if($_SESSION['tipo'] != 'adm'){
    header('Location: acesso_proibido.php');
    exit;
}