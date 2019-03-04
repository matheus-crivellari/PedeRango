<?php
// Inclui a conexao
require_once '../conexao/conecta.php';

// Restrição de acesso
require_once 'admin.php';

// Area do site
$area = 'pedido';

if(isset($_POST['status'])){
    $id = $_POST['id'] ?? '';
    $status = $_POST['status'] ?? '';

    if($status == 'pago'){
        $sql = "UPDATE pedidos_tb SET status_pedido='$status', data_fechamento=now() WHERE id_pedido = $id";
    }else{
        $sql = "UPDATE pedidos_tb SET status_pedido='$status' WHERE id_pedido = $id";
    }

    $resultado = mysqli_query($conexao, $sql);

    if($resultado){
        $_SESSION['msg'] = 'Status alterado com sucesso.';
        header('Location: pedido_listar.php');
        exit;
    }else{
        $_SESSION['erro'] = 'Houve um erro ao alterar o registro.';
        header('Location: pedido_listar.php');
        exit;
    }
}else{
    $_SESSION['erro'] = 'Houve um erro ao alterar o registro.';
    header('Location: pedido_listar.php');
    exit;
}
