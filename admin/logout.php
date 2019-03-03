<?php
// Abrir ou restaruar sessao
if(!isset($_SESSION)){
    session_start();
}

// Armazenar os dados do usuario na sessao
unset($_SESSION['codigo_usuario']);
unset($_SESSION['username']);
unset($_SESSION['nome_completo']);
unset($_SESSION['tipo']);

session_destroy();

header('Location: index.php');