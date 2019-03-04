<?php
// Inclui a conexao
require_once '../conexao/conecta.php';

// Restrição de acesso
require_once 'admin.php';

// Obtem o id do link
$id = $_GET['id'] ?? 0;

if($id){
    $sql = "DELETE FROM usuarios_tb WHERE codigo_usuario=$id";

    $resultado = mysqli_query($conexao, $sql);

    if($resultado){
        $_SESSION['msg'] = 'Usuário excluído com sucesso.';
        header('Location: usuario_listar.php');
    }else{
        $_SESSION['erro'] = 'Houve um erro ao excluir o registro.';
        header('Location: usuario_listar.php');
    }
}