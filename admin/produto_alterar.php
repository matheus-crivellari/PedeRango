<?php
// Inclui a conexao
require_once '../conexao/conecta.php';

// Restrição de acesso
require_once 'entregador.php';

// Area do site
$area = 'produto';

// Se estiver definido o $_POST['id'], entao o usuario enviou o form de alterar
// altera o produto no banco
if(isset($_POST['id'])){
    $id              = $_POST['id']             ?? '';
    $nome_prod       = $_POST['nome_prod']      ?? '';
    $resumo_prod     = $_POST['resumo_prod']    ?? '';
    $valor_prod      = $_POST['valor_prod']     ?? '';
    $descricao_prod  = $_POST['descricao_prod'] ?? '';
    $imagem_prod     = $_POST['imagem_prod']    ?? '';

    $imagem_nova     = $_FILES['imagem_nova'] ?? null;

    // var_dump($imagem_nova); die;

    // Se existir imagem
    if($imagem_nova){
        // Se o arquivo antigo existe
        if(file_exists('../upload/' . $imagem_prod)){
            unlink('../upload/' . $imagem_prod); // Deleta o arquivo antigo do disco
        }

        if($imagem_nova['name']){ // Se existir nome da imagem
            $tipo = explode('/',$imagem_nova['type'])[1]; // Obtem o tipo do arquivo
            $imagem_prod = md5(time()) . ".$tipo"; // Cria um novo nome para evitar sobreescrever arquvios com nomes iguais
            $novo = '../upload/' . $imagem_prod; // Caminho completo
            move_uploaded_file($imagem_nova["tmp_name"], $novo); // Move o arquivo carregado para o lugar desejado
        }
    }

    $sql = "UPDATE produtos_tb SET nome_prod='$nome_prod', resumo_prod='$resumo_prod', valor_prod='$valor_prod', descricao_prod='$descricao_prod', imagem_prod='$imagem_prod' WHERE codigo_produto=$id";

    $resultado = mysqli_query($conexao, $sql);

    if($resultado){
        $_SESSION['msg'] = 'Produto alterado com sucesso.';
    }else{
        $_SESSION['erro'] = 'Houve um erro ao alterar o registro.';
    }
}

// Se estiver definido o $_GET['id'], obtem os dados do produto para alterar
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $resultado = mysqli_query($conexao, "SELECT * FROM produtos_tb WHERE codigo_produto=$id");

    if($resultado){
        $produto = mysqli_fetch_assoc($resultado);
    }

}else{
    header('Location: produto_listar.php');
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
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">

                <div class="row" id="conteudo">
                    <div class="col-8 offset-2">
                        <h1>Alterar produto</h1>
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
                            <input type="hidden" name="id" value="<?php print $_GET['id']?>">
                            <!-- Campo nome produto -->
                            <div class="form-group">
                                <label for="campoNomeProd">Produto</label>
                                <input value="<?php print $produto['nome_prod'] ?>" class="form-control" type="text" name="nome_prod" id="campoNomeProd" placeholder="Digite um nome para o produto">
                                <small>Dê um nome para o seu produto.</small>
                            </div>

                            <!-- Campo resumo produto -->
                            <div class="form-group">
                                <label for="campoResumoProd">Resumo</label>
                                <input value="<?php print $produto['resumo_prod'] ?>" class="form-control" type="text" name="resumo_prod" id="campoResumoProd" placeholder="Digite o resumo do produto">
                                <small>Breve descrição para o seu produto.</small>
                            </div>

                            <!-- Campo valor -->
                            <div class="form-group">
                                <label for="campoValor">Valor</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">R$</div>
                                    </div>
                                    <input value="<?php print $produto['valor_prod'] ?>" class="form-control" name="valor_prod" id="campoValor" type="number" min="0.01" step="0.01" max="2500" placeholder="4.00" />
                                </div>
                            </div>

                            <!-- Campo descricao produto -->
                            <div class="form-group">
                                <label for="campoDescricaoProd">Descrição</label>
                                <textarea class="form-control" name="descricao_prod" id="campoDescricaoProd" rows="3" placeholder="Digite a descrição do produto"><?php print $produto['descricao_prod'] ?></textarea>
                                <small>Descrição completa para o seu produto.</small>
                            </div>

                            <!-- Imagem produto -->
                            <div class="form-group">
                                <label for="campoImagem">Imagem:</label>
                                <input class="form-control disabled" value="<?php print $produto['imagem_prod'] ?>" type="text" id="campoImagem" disabled>
                                <input type="hidden" value="<?php print $produto['imagem_prod'] ?>" name="imagem_prod"><!-- necessario pois input disabled nao é enviado -->
                            </div>

                            <!-- Trocar imagem produto -->
                            <div class="form-group">
                                <label for="novaImagem">Trocar imagem:</label>
                                <input type="file" name="imagem_nova" id="novaImagem">
                                <br>
                                <small>Selecione uma imagem para substituir a imagem existente (.png ou .jpg de 256x256 px).</small>
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