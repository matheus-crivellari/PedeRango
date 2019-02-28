<?php
// Inclui a conexao
require_once '../conexao/conecta.php';

// Incializa a sessao
if(!isset($_SESSION)) session_start();

$resultado = mysqli_query($conexao, 'SELECT * FROM usuarios_tb');
if($resultado){
    $total          = mysqli_num_rows($resultado);
    $limit          = 5;
    $pagina_total   = ceil($total / $limit);
    $pagina_atual   = isset($_GET['pag']) ? $_GET['pag'] : 1;
    $offset         = $limit * ($pagina_atual - 1);

    $resultado = mysqli_query($conexao, "SELECT * FROM usuarios_tb LIMIT $offset, $limit");
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
    <title>Usuários</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <style>
        html, body {
            background-color: #dadada;
            height: 100%;
        }

        #principal{
            background-color: white;
            height: 100%;
        }

        .pag{
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
                        <h4 class="alert-heading">Administração de usuários</h4>
                        <hr>
                        <p class="mb-0">Aqui você pode administrar seus usuários.</p>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <?php if(isset($_SESSION['msg'])): ?>
                    <div class="alert alert-success" role="alert"><?= $_SESSION['msg'] ?></div>
                    <?php unset($_SESSION['msg']); ?>
                <?php endif;?>

                <a class="btn btn-primary" href="usuario_inserir.php" role="button">Adicionar usuário</a>

                <div class="table-responsive mt-3">
                    <table class="table">
                        <thead>
                            <th>#</th>
                            <th>Username</th>
                            <th>Nome completo</th>
                            <th>Tipo</th>
                            <th colspan="2">&nbsp;</th>
                        </thead>
                        <tbody>
                            <?php foreach($usuarios as $usuario): ?>
                            <?php $usuario = (object) $usuario; ?>
                            <tr>
                                    <td><?= $usuario->codigo_usuario ?></td>
                                    <td><?= $usuario->username ?></td>
                                    <td><?= $usuario->nome_completo ?></td>
                                    <td>
                                        <?php
                                            switch ($usuario->tipo) {
                                                case 'adm':
                                                    echo 'Administrador';
                                                    break;

                                                case 'com':
                                                    echo 'Comum';
                                                    break;

                                                case 'ent':
                                                    echo 'Entregador';
                                                    break;

                                                default:
                                                    echo 'Comum';
                                                    break;
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="usuarios_alterar.php?id=<?= $usuario->codigo_usuario ?>" class="btn btn-primary">Editar</a>
                                        <a href="usuarios_excluir.php?id=<?= $usuario->codigo_usuario ?>" class="btn btn-danger">Excluir</a>
                                    </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="row justify-content-center">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php if($pagina_atual > 1): ?>
                                <li class="page-item"><a class="page-link" href="?pag=<?= $pagina_atual - 1?>">Anterior</a></li>
                            <?php endif;?>

                            <?php if($pagina_total > 1): ?>
                                <li class="page-item"><a class="pag page-link text-muted"><?= str_pad($pagina_atual, 3, '0', STR_PAD_LEFT) . '/' . str_pad($pagina_total, 3, '0', STR_PAD_LEFT) ?></a></li>
                            <?php endif;?>

                            <?php if($pagina_atual < $pagina_total): ?>
                                <li class="page-item"><a class="page-link" href="?pag=<?= $pagina_atual + 1?>">Próximo</a></li>
                            <?php endif;?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</body>

</html>