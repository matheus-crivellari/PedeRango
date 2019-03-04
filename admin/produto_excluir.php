<?php
// Inclui a conexao
require_once '../conexao/conecta.php';

// Restrição de acesso
require_once 'entregador.php';

// Area do site
$area = 'produto';

// Obtem o id do link
$id = $_GET['id'] ?? 0;

if($id){
    $sql = "DELETE FROM produtos_tb WHERE codigo_produto=$id";

    $resultado = mysqli_query($conexao, $sql);

    if($resultado){
        $_SESSION['msg'] = 'Produto excluído com sucesso.';
        header('Location: produto_listar.php');
    }else{
        $_SESSION['erro'] = 'Houve um erro ao excluir o registro.';
        header('Location: produto_listar.php');
    }
}