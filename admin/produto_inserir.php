<?php
// Inclui a conexao
require_once '../conexao/conecta.php';

// Obtem os dados do form
$nome_prod       = $_POST['nome_prod']      ?? '';
$resumo_prod     = $_POST['resumo_prod']    ?? '';
$valor_prod      = $_POST['valor_prod']     ?? '';
$descricao_prod  = $_POST['descricao_prod'] ?? '';
$imagem_prod     = $_FILES['imagem_prod']   ?? null;

// Se existir imagem
if($imagem_prod){
    $tipo = explode('/',$imagem_prod['type'])[1]; // Obtem o tipo do arquivo
    $nome = md5(time()) . ".$tipo"; // Cria um novo nome para evitar sobreescrever arquvios com nomes iguais
    $novo = '../upload/' . $nome; // Caminho completo
    move_uploaded_file($imagem_prod["tmp_name"], $novo); // Move o arquivo carregado para o lugar desejado
}else{
    $nome = '';
}

// Valida as vars do form
if($nome_prod && $resumo_prod && $valor_prod){

    $sql = "INSERT INTO produtos_tb VALUES (0,'$nome_prod','$resumo_prod','$valor_prod','$descricao_prod','$nome')";

    $resultado = mysqli_query($conexao, $sql);

    if($resultado){
        $_SESSION['msg'] = 'Produto cadastrado com sucesso.';
        header('Location: produto_listar.php');
        exit; // Necessario pq nossa página contem conteudo html além do header
    }else{
        $_SESSION['erro'] = 'Houve um erro ao alterar o registro.';
    }
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
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">

                <div class="row">
                    <div class="col-8 offset-2">
                        <h1>Criar produto</h1>
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
                        <form method="post" enctype="multipart/form-data">
                            <!-- Campo nome produto -->
                            <div class="form-group">
                                <label for="campoNomeProd">Produto</label>
                                <input class="form-control" type="text" name="nome_prod" id="campoNomeProd" placeholder="Digite um nome para o produto">
                                <small>Dê um nome para o seu produto.</small>
                            </div>

                            <!-- Campo resumo produto -->
                            <div class="form-group">
                                <label for="campoResumoProd">Resumo</label>
                                <input class="form-control" type="text" name="resumo_prod" id="campoResumoProd" placeholder="Digite o resumo do produto">
                                <small>Breve descrição para o seu produto.</small>
                            </div>

                            <!-- Campo valor -->
                            <div class="form-group">
                                <label for="campoValor">Valor</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">R$</div>
                                    </div>
                                    <input class="form-control" name="valor_prod" id="campoValor" type="number" min="0.01" step="0.01" max="2500" placeholder="4.00" />
                                </div>
                            </div>

                            <!-- Campo descricao produto -->
                            <div class="form-group">
                                <label for="campoDescricaoProd">Descrição</label>
                                <textarea class="form-control" name="descricao_prod" id="campoDescricaoProd" rows="3" placeholder="Digite a descrição do produto"></textarea>
                                <small>Descrição completa para o seu produto.</small>
                            </div>

                            <!-- Imagem produto -->
                            <div class="form-group">
                                <label for="campoImagem">Imagem:</label>
                                <input type="file" name="imagem_prod" id="campoImagem">
                                <br>
                                <small>.png ou .jpg de 256x256 px</small>
                            </div>

                            <!-- Enviar / Cancelar -->
                            <div class="form-row">
                                <div class="col-6">
                                    <button class="btn btn-block btn-primary" type="submit" value="Salvar"><i class="fa fa-floppy-o"></i> Salvar</button>
                                </div>
                                <div class="col-6">
                                    <a href="produto_listar.php" class="btn btn-block btn-secondary"><i class="fa fa-arrow-left"></i> Voltar</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>