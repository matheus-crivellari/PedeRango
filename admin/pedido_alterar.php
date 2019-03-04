<?php
// Inclui a conexao
require_once '../conexao/conecta.php';

// Restrição de acesso
require_once 'entregador.php';

// Area do site
$area = 'pedido';

// Se estiver definido o $_POST['id'], entao o usuario enviou o form de alterar
// altera o pedido no banco
if(isset($_POST['id'])){
    $id =            $_POST['id'] ?? '';
    $cod_usuario =   $_POST['usuario'] ?? '';
    $data_pedido =   $_POST['data_pedido'] ?? '';
    $status_pedido = $_POST['status'] ?? '';

    if($id){
        $sql = "UPDATE pedidos_tb SET cod_usuario='$cod_usuario',data_pedido='$data_pedido',status_pedido='$status_pedido' WHERE id_pedido=$id";

        $resultado = mysqli_query($conexao, $sql);

        if($resultado){
            $_SESSION['msg'] = 'Pedido alterado com sucesso.';
        }else{
            $_SESSION['erro'] = 'Houve um erro ao alterar o registro.';
        }
    }
}

// Se estiver definido o $_GET['id'], obtem os dados do pedido para alterar
if(isset($_GET['id'])){
    $id = $_GET['id'] ?? '';

    // Obtem dados do pedido
    $resultado = mysqli_query($conexao, "SELECT * FROM pedidos_tb WHERE id_pedido=$id");
    if($resultado){
        $pedido = mysqli_fetch_object($resultado);
    }else{
        $pedido = null;
    }

    // Obtem produtos do pedido
    $resultado = mysqli_query($conexao, "SELECT produtos_tb.*, produtos_pedidos.qtd_produto FROM produtos_pedidos INNER JOIN produtos_tb ON produtos_tb.codigo_produto = produtos_pedidos.cod_produto WHERE produtos_pedidos.cod_pedido = $id");
    if($resultado){
        $produtos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }else{
        $produtos = null;
    }
}else{
    header('Location: pedido_listar.php');
}

// Obtem a lista de usuarios
$resultado = mysqli_query($conexao, "SELECT * FROM usuarios_tb");
if($resultado){
    $usuarios = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
}else{
    $usuarios = [];
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pedidos</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <style>
        html,
        body {
            background-color: #dadada;
            height: 100%;
        }

        #principal, #conteudo {
            background-color: white;
        }

        #principal{
            height: 100%;
        }

        .pag {
            pointer-events: none;
            user-select: none;
        }
    </style>
</head>

<body>

    <div id="principal" class="container">
        <div class="row">
            <div class="col-12 p-0">
                <?php require_once 'header.php' ?>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">

                <div class="row" id="conteudo">
                    <div class="col-8 offset-2">
                        <h1>Alterar pedido</h1>
                        <hr>
                        <?php if(isset($_SESSION['msg'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php print $_SESSION['msg'] ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php unset($_SESSION['msg']); ?>
                        <?php endif;?>

                        <?php if(isset($_SESSION['erro'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php print $_SESSION['erro'] ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php unset($_SESSION['erro']); ?>
                        <?php endif;?>

                        <!-- Formulario -->
                        <form onsubmit="return enviar()" method="post">
                            <!-- Campo id -->
                            <input type="hidden" name="id" value="<?= $id ?>">

                            <!-- Número pedido -->
                            <div class="form-group">
                                <label for="campoNumeroPedido">Número do pedido</label>
                                <input class="form-control" disabled type="text" id="campoNumeroPedido" value="<?php print str_pad($id,5,'0',STR_PAD_LEFT) ?>">
                            </div>

                            <!-- Usuário -->
                            <div class="form-group">
                                <label for="campoUsername">Usuário</label>
                                <select class="form-control" name="usuario" id="campoUsuario">
                                    <?php foreach($usuarios as $usuario): ?>
                                        <?php $usuario = (object) $usuario; ?>
                                        <option <?php if($pedido->cod_usuario == $usuario->codigo_usuario) print 'selected' ?> value="<?php print $usuario->codigo_usuario ?>"><?php print $usuario->nome_completo ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <!-- Data pedido / Data fechamento -->
                            <div class="form-row">
                                <div class="col-6">
                                    <label for="campoDataPedido">Data do pedido</label>
                                    <input class="form-control" type="date" name="data_pedido" id="campoDataPedido" value="<?php print date('Y-m-d',strtotime($pedido->data_pedido)) ?>">
                                </div>
                                <div class="col-6">
                                    <label for="campoDataFechamento">Data do fechamento</label>
                                    <input disabled class="form-control" type="date" name="data_fechamento" id="campoDataFechamento" value="<?php if($pedido->data_fechamento) print date('Y-m-d',strtotime($pedido->data_fechamento)) ?>">
                                </div>
                            </div>

                            <!-- Status pedido -->
                            <div class="form-group mt-3">
                                <label for="campoStatus">Situação</label>
                                <select <?php if($pedido->status_pedido == 'pago') print 'disabled' ?> class="form-control" name="status" id="campoStatus">
                                    <option <?php if($pedido->status_pedido == 'aguardando') print 'selected' ?> value="aguardando">Aguardando</option>
                                    <option <?php if($pedido->status_pedido == 'em preparacao') print 'selected' ?> value="em preparacao">Em preparação</option>
                                    <option <?php if($pedido->status_pedido == 'entrega') print 'selected' ?> value="entrega">Saiu para entrega</option>
                                    <option <?php if($pedido->status_pedido == 'pago') print 'selected' ?> value="pago">Pago</option>
                                </select>
                            </div>
                            <h3>Produtos</h3>
                            <div class="table">
                                <table class="table">
                                    <thead>
                                        <th>Cód. Produto</th>
                                        <th>Produto</th>
                                        <th>Valor Unit.</th>
                                        <th>Qtd.</th>
                                        <th>Total</th>
                                    </thead>
                                    <tbody>
                                        <?php $total = 0 ?>
                                        <?php foreach($produtos as $produto): ?>
                                        <?php $produto = (object) $produto ?>
                                        <tr>
                                            <td><?php print $produto->codigo_produto ?></td>
                                            <td><?php print $produto->nome_prod ?></td>
                                            <td>R$ <?php print str_replace('.', ',', $produto->valor_prod) ?></td>
                                            <td>x<?php print $produto->qtd_produto ?></td>
                                            <td>R$ <?php print number_format($t = $produto->valor_prod * $produto->qtd_produto, 2,',','.') ?></td>
                                            <?php $total += $t ?>
                                        </tr>
                                        <?php endforeach ?>
                                        <tr>
                                            <td colspan="4" class="text-right">Taxa de entrega</td>
                                            <td>R$ <?php print number_format(6, 2,',','.') ?></td>
                                            <?php $total += 6 ?>
                                        </tr>
                                        <tfoot>
                                            <th colspan="4" class="text-right">Total</th>
                                            <td>R$ <?php print number_format($total, 2,',','.') ?></td>
                                        </tfoot>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Enviar / Cancelar -->
                            <div class="form-row">
                                <div class="col-6">
                                    <button class="btn btn-block btn-primary" type="submit" value="Salvar"><i class="fa fa-floppy-o"></i> Salvar</button>
                                </div>
                                <div class="col-6">
                                    <a href="pedido_listar.php" class="btn btn-block btn-secondary"><i class="fa fa-arrow-left"></i> Voltar</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function enviar() {
            return confirm('Tem certeza que deseja alterar este pdido?');
        }
    </script>
</body>
</html>
