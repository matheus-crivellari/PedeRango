<?php
// Inclui a conexao
require_once '../conexao/conecta.php';

// Se estiver definido o $_POST['id'], entao o usuario enviou o form de alterar
// altera o usuario no banco
if(isset($_POST['id'])){
    // Obtem os dados do form
    $id             = $_POST['id']            ?? 0;
    $nome           = $_POST['nome']          ?? '';
    $nome_completo  = $_POST['nome_completo'] ?? '';
    $endereco       = $_POST['endereco']      ?? '';
    $estado         = $_POST['estado']        ?? '';
    $cidade         = $_POST['cidade']        ?? '';
    $senha          = $_POST['senha']         ?? '';
    $tipo           = $_POST['tipo']          ?? '';

    $sql = "UPDATE usuarios_tb SET username='$nome',nome_completo='$nome_completo',endereco='$endereco',estado_cod=$estado,cidade_cod=$cidade,senha='$senha',tipo='$tipo' WHERE codigo_usuario=$id";

    $resultado = mysqli_query($conexao, $sql);

    if($resultado){
        $_SESSION['msg'] = 'Usuário alterado com sucesso.';
    }else{
        $_SESSION['erro'] = 'Houve um erro ao alterar o registro.';
    }
}

// Se estiver definido o $_GET['id'], obtem os dados do usuario para alterar
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $resultado = mysqli_query($conexao, "SELECT * FROM usuarios_tb WHERE codigo_usuario=$id");

    if($resultado){
        $usuario = mysqli_fetch_assoc($resultado);
    }

}else{
    header('Location: usuario_listar.php');
}

// Traz lista de estados
$resultado = mysqli_query($conexao, "SELECT * FROM tb_estado");
if($resultado){
    $estados = mysqli_fetch_all($resultado, MYSQLI_ASSOC); // Transforma o resultado do banco numa lista de estados
}else{
    $estados = []; // Cria uma lista vazia caso não haja estados cadastrados
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Usuários</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

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
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">

                <div class="row">
                    <div class="col-8 offset-2">
                        <h1>Alterar usuário</h1>
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
                        <form method="post">
                            <!-- Campo id -->
                            <input type="hidden" name="id" value="<?= $id ?>">

                            <!-- Campo username -->
                            <div class="form-group">
                                <label for="campoUsername">Username</label>
                                <input value="<?= $usuario['username'] ?>" class="form-control" type="text" name="nome" id="campoUsername" placeholder="Digite um login para o usuário">
                                <small>O login do usuário deve ser único.</small>
                            </div>

                            <!-- Campo nome completo -->
                            <div class="form-group">
                                <label for="campoNomeCompleto">Nome completo</label>
                                <input value="<?= $usuario['nome_completo'] ?>" class="form-control" type="text" name="nome_completo" id="campoNomeCompleto" placeholder="Digite o nome completo">
                            </div>

                            <!-- Campo endereço -->
                            <div class="form-group">
                                <label for="campoEndereco">Endereço</label>
                                <input value="<?= $usuario['endereco'] ?>" class="form-control" type="text" name="endereco" id="campoEndereco" placeholder="Rua Nome da Rua, 999 - Bairro">
                            </div>

                            <!-- Estado / Cidade -->
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="campoEstado">Estado</label>
                                        <select class="form-control" name="estado" id="campoEstado">
                                            <?php foreach ($estados as $estado): ?>
                                                <?php if($usuario['estado_cod'] == $estado['id']):?>
                                                    <option value="<?php print $estado['id']?>" selected><?php print $estado['uf']?></option>
                                                <?php else: ?>
                                                    <option value="<?php print $estado['id']?>"><?php print $estado['uf']?></option>
                                                <?php endif;?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="campoCidade">Cidade</label>
                                        <select class="form-control" name="cidade" id="campoCidade">
                                            <option value="1">Piracicaba</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Campo senha -->
                            <div class="form-group">
                                <label for="campoSenha">Senha</label>
                                <input value="<?= $usuario['senha'] ?>" class="form-control" type="text" name="senha" id="campoSenha" placeholder="Digite a senha do usuário">
                                <small>Até 8 dígitos.</small>
                            </div>

                            <!-- Campo tipo -->
                            <div class="form-group">
                                <label for="campoTipo">Tipo do usuário</label>
                                <select class="form-control" name="tipo" id="campoTipo">
                                    <option value="com">Comum</option>
                                    <option value="ent">Entregador</option>
                                    <option value="adm">Administrador</option>
                                </select>
                            </div>

                            <!-- Enviar / Cancelar -->
                            <div class="form-row">
                                <div class="col-6">
                                    <button class="btn btn-block btn-primary" type="submit" value="Salvar"><i class="fa fa-floppy-o"></i> Salvar</button>
                                </div>
                                <div class="col-6">
                                    <a href="usuario_listar.php" class="btn btn-block btn-secondary"><i class="fa fa-arrow-left"></i> Voltar</a>
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