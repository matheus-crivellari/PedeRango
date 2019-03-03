<?php
// Inclui a conexao
require_once '../conexao/conecta.php';

$resultado = mysqli_query($conexao, 'SELECT * FROM produtos_tb');
if($resultado){
    $total          = mysqli_num_rows($resultado);
    $limit          = 4;
    $pagina_total   = ceil($total / $limit);
    $pagina_atual   = isset($_GET['pag']) ? $_GET['pag'] : 1;
    $offset         = $limit * ($pagina_atual - 1);

    $resultado = mysqli_query($conexao, "SELECT * FROM produtos_tb LIMIT $offset, $limit");
    $produtos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
}else{
    $produtos = [];
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Produtos</title>

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
                        <h4 class="alert-heading">Administração de produtos</h4>
                        <hr>
                        <p class="mb-0">Aqui você pode administrar seus produtos.</p>
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

                <a class="btn btn-primary" href="produto_inserir.php" role="button"><i class="fa fa-plus"></i> Novo produto</a>

                <div class="table-responsive mt-3">
                    <table class="table">
                        <thead>
                            <th>#</th>
                            <th>Imagem</th>
                            <th>Produto</th>
                            <th width="40%">Resumo</th>
                            <th>Valor</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            <?php foreach($produtos as $produto): ?>
                            <?php $produto = (object) $produto; ?>
                            <tr>
                                <td><?php print $produto->codigo_produto ?></td>
                                <td>
                                    <?php if($produto->imagem_prod): ?>
                                        <img width="96px" height="96px" src="../upload/<?php print $produto->imagem_prod ?>" alt="Imagem do produto">
                                    <?php else: ?>
                                        <img width="96px" height="96px" src="https://via.placeholder.com/256" alt="Imagem do produto">
                                    <?php endif; ?>
                                </td>
                                <td><?php print $produto->nome_prod ?></td>
                                <td><?php print $produto->resumo_prod ?></td>
                                <td>R$ <?php print str_replace('.', ',', $produto->valor_prod) ?></td>
                                <td>
                                    <a href="produto_alterar.php?id=<?php print $produto->codigo_produto ?>" class="btn btn-primary"><i class="fa fa-pencil"></i> Editar</a>
                                    <a onclick="return excluir('<?php print $produto->nome_prod ?>')" href="produto_excluir.php?id=<?php print $produto->codigo_produto ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Excluir</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php if(count($produtos) < 1): ?>
                        <div class="alert alert-secondary" role="alert">Você ainda não possui produtos cadastrados.</div>
                    <?php endif; ?>
                </div>

                <div class="row justify-content-center">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php if($pagina_atual > 1): ?>
                            <li class="page-item"><a class="page-link" href="?pag=1">Primeira</a></li>
                            <li class="page-item"><a class="page-link" href="?pag=<?php print $pagina_atual - 1; ?>">Anterior</a></li>
                            <?php endif;?>

                            <?php if($pagina_total > 1): ?>
                            <li class="page-item"><a class="pag page-link text-muted"><?php print str_pad($pagina_atual, 3, '0', STR_PAD_LEFT) . '/' . str_pad($pagina_total, 3, '0', STR_PAD_LEFT);  ?></a>
                            </li>
                            <?php endif;?>

                            <?php if($pagina_atual < $pagina_total): ?>
                            <li class="page-item"><a class="page-link" href="?pag=<?php print $pagina_atual + 1; ?>">Próximo</a></li>
                            <li class="page-item"><a class="page-link" href="?pag=<?php print $pagina_total; ?>">Última</a></li>
                            <?php endif;?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <script>
        function excluir(nome) {
            if (confirm('Tem certeza que deseja excluir "' + nome + '"?')) {
                return true;
            } else {
                return false;
            }
        }
    </script>
</body>

</html>