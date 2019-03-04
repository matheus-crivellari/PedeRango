<?php
// Inclui a conexao
require_once '../conexao/conecta.php';

// Restrição de acesso
require_once 'entregador.php';

// Area do site
$area = 'pedido';

// Se existir filtro na URL
$filtro = $_GET['filtro'] ?? '';
// Monta uma clausula WHERE para filtrar por status
if($filtro){
    $filtro_sql = " AND pedidos_tb.status_pedido = '$filtro' ";
}else{
    $filtro_sql = '';
}

// Obtem contagem de linhas de peidos filtrados
$resultado = mysqli_query($conexao, "SELECT id_pedido FROM pedidos_tb WHERE 1=1 $filtro_sql ORDER BY data_pedido");
if($resultado){
    $total          = mysqli_num_rows($resultado);
    $limit          = 5;
    $pagina_total   = ceil($total / $limit);
    $pagina_atual   = isset($_GET['pag']) ? $_GET['pag'] : 1;
    $offset         = $limit * ($pagina_atual - 1);

    $resultado = mysqli_query($conexao, "SELECT usuarios_tb.nome_completo, pedidos_tb.* FROM pedidos_tb INNER JOIN usuarios_tb ON usuarios_tb.codigo_usuario = pedidos_tb.cod_usuario WHERE 1=1 $filtro_sql ORDER BY pedidos_tb.data_pedido LIMIT $offset, $limit");
    $pedidos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
}else{
    $pedidos = [];
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

                <div class="p-3">

                    <div class="alert alert-secondary" role="alert">
                        <h4 class="alert-heading">Administração de pedidos</h4>
                        <hr>
                        <p class="mb-0">Aqui você pode administrar seus pedidos.</p>
                    </div>
                </div>

            </div>
        </div>
        <div id="conteudo" class="row">
            <div class="col-12">
                <?php if(isset($_SESSION['msg'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php print $_SESSION['msg']; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php unset($_SESSION['msg']); ?>
                <?php endif;?>

                <?php if(isset($_SESSION['erro'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php print $_SESSION['erro']; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php unset($_SESSION['erro']); ?>
                <?php endif;?>

                <!-- <a class="btn btn-primary" href="usuario_inserir.php" role="button"><i class="fa fa-plus"></i> Novo pedido</a> -->
                <form class="form-inline">
                    <label for="campoFiltro">Filtro por situação:</label>&nbsp;&nbsp;
                    <select onchange="form.submit()" class="form-control" id="campoFiltro" name="filtro">
                        <option value="">Todos</option>
                        <option <?php if($filtro == 'aguardando') print 'selected' ?> value="aguardando">Aguardando</option>
                        <option <?php if($filtro == 'em preparacao') print 'selected' ?> value="em preparacao">Em preparação</option>
                        <option <?php if($filtro == 'entrega') print 'selected' ?> value="entrega">Saiu para entrega</option>
                        <option <?php if($filtro == 'pago') print 'selected' ?> value="pago">Pago</option>
                    </select>
                </form>

                <div class="table-responsive mt-3">
                    <table class="table">
                        <thead>
                            <th>Pedido #</th>
                            <th>Cliente</th>
                            <th>Realizado em</th>
                            <th>Fechado em</th>
                            <th>Situação</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            <?php foreach($pedidos as $pedido): ?>
                            <?php $pedido = (object) $pedido; ?>
                            <tr>
                                <form method="post" action="pedido_alterar_status.php">
                                    <input type="hidden" name="id" value="<?php print $pedido->id_pedido ?>">
                                    <td><?php print str_pad($pedido->id_pedido,5,'0',STR_PAD_LEFT) ?></td>
                                    <td><a href="usuario_alterar.php?id=<?php print $pedido->cod_usuario ?>"><?php print $pedido->nome_completo ?></a></td>
                                    <td><?php print date('d/m/Y',strtotime($pedido->data_pedido)) ?></td>
                                    <td class="text-muted"><?php print ($pedido->data_fechamento ?? 'Aberto') ?></td>
                                    <td>
                                        <select <?php if($pedido->status_pedido == 'pago') print 'disabled' ?> onchange="return alterar(form)" class="form-control" name="status" id="campoStatus">
                                            <option <?php if($pedido->status_pedido == 'aguardando') print 'selected' ?> value="aguardando">Aguardando</option>
                                            <option <?php if($pedido->status_pedido == 'em preparacao') print 'selected' ?> value="em preparacao">Em preparação</option>
                                            <option <?php if($pedido->status_pedido == 'entrega') print 'selected' ?> value="entrega">Saiu para entrega</option>
                                            <option <?php if($pedido->status_pedido == 'pago') print 'selected' ?> value="pago">Pago</option>
                                        </select>
                                    </td>
                                    <td>
                                        <a class="btn btn-block btn-primary" href="pedido_alterar.php?id=<?php print $pedido->id_pedido ?>"><i class="fa fa-eye"></i> Ver pedido</a>
                                    </td>
                                </form>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php if(count($pedidos) < 1): ?>
                        <div class="alert alert-secondary" role="alert">Não existem pedidos cadastrados.</div>
                    <?php endif; ?>
                </div>

                <div class="row justify-content-center">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php if($pagina_atual > 1): ?>
                            <li class="page-item"><a class="page-link" href="?filtro=<?php print $filtro ?>&pag=1">Primeira</a></li>
                            <li class="page-item"><a class="page-link" href="?filtro=<?php print $filtro ?>&pag=<?php print $pagina_atual - 1; ?>">Anterior</a></li>
                            <?php endif;?>

                            <?php if($pagina_total > 1): ?>
                            <li class="page-item"><a class="pag page-link text-muted"><?php print str_pad($pagina_atual, 3, '0', STR_PAD_LEFT) . '/' . str_pad($pagina_total, 3, '0', STR_PAD_LEFT);  ?></a>
                            </li>
                            <?php endif;?>

                            <?php if($pagina_atual < $pagina_total): ?>
                            <li class="page-item"><a class="page-link" href="?filtro=<?php print $filtro ?>&pag=<?php print $pagina_atual + 1; ?>">Próximo</a></li>
                            <li class="page-item"><a class="page-link" href="?filtro=<?php print $filtro ?>&pag=<?php print $pagina_total; ?>">Última</a></li>
                            <?php endif;?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <script>
        function alterar(formulario) {
            if (confirm('Tem certeza que deseja alterar a situação deste pedido?')) {
                formulario.submit();
                return true;
            } else {
                window.location.reload();
                return false;
            }
        }
    </script>
</body>

</html>