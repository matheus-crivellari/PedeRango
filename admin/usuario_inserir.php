<?php
// Inclui a conexao
require_once '../conexao/conecta.php';

// Obtem os dados do form
$nome           = $_POST['nome']          ?? '';
$nome_completo  = $_POST['nome_completo'] ?? '';
$endereco       = $_POST['endereco']      ?? '';
$estado         = $_POST['estado']        ?? '';
$cidade         = $_POST['cidade']        ?? '';
$senha          = $_POST['senha']         ?? '';
$tipo           = $_POST['tipo']          ?? '';

// Valida as vars do form
if($nome && $nome_completo && $endereco && $estado && $cidade && $senha && $tipo){
    $sql = "INSERT INTO usuarios_tb VALUES (0,'$nome','$nome_completo','$endereco',$estado,$cidade,'$senha','$tipo')";

    $resultado = mysqli_query($conexao, $sql);

    if($resultado){
        $_SESSION['msg'] = 'Usuário cadastrado com sucesso.';
        header('Location: usuario_listar.php');
        exit; // Necessario pq nossa página contem conteudo html além do header
    }else{
        $_SESSION['erro'] = 'Houve um erro ao alterar o registro.';
    }
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
                        <h1>Criar usuário</h1>
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
                            <!-- Campo username -->
                            <div class="form-group">
                                <label for="campoUsername">Username</label>
                                <input class="form-control" type="text" name="nome" id="campoUsername" placeholder="Digite um login para o usuário">
                                <small>O login do usuário deve ser único.</small>
                            </div>

                            <!-- Campo nome completo -->
                            <div class="form-group">
                                <label for="campoNomeCompleto">Nome completo</label>
                                <input class="form-control" type="text" name="nome_completo" id="campoNomeCompleto" placeholder="Digite o nome completo">
                            </div>

                            <!-- Campo endereço -->
                            <div class="form-group">
                                <label for="campoEndereco">Endereço</label>
                                <input class="form-control" type="text" name="endereco" id="campoEndereco" placeholder="Rua Nome da Rua, 999 - Bairro">
                            </div>

                            <!-- Estado / Cidade -->
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="campoEstado">Estado</label>
                                        <select onchange="mudaEstado()" class="form-control" name="estado" id="campoEstado">
                                            <?php foreach ($estados as $estado): ?>
                                                <option value="<?php print $estado['id']?>"><?php print $estado['uf']?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="campoCidade">Cidade</label>
                                        <select disabled class="form-control" name="cidade" id="campoCidade">
                                            <option value="1">Piracicaba</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Campo senha -->
                            <div class="form-group">
                                <label for="campoSenha">Senha</label>
                                <input class="form-control" type="text" name="senha" id="campoSenha" placeholder="Digite a senha do usuário">
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
    <script>
        function mudaEstado() {
            var cpEstado = $('#campoEstado');
            var cpCidade = $('#campoCidade');

            cpCidade.prop('disabled', true); // Desabilita o select de cidades
            cpCidade.html('<option value="0">Carregando...</option>'); // Limpa o select de cidades

            var idEstado = cpEstado.val();

            var dados = {
                estado_cod : idEstado
            };

            var url = 'http://localhost/pederango/webservice/get_cidades.php';

            $.getJSON({
                url: url,
                data : dados
            }).done(function (resposta) {
                if(resposta != 'erro'){ // Se nao houver erro continua
                    if(resposta.length){
                        cpCidade.html(''); // Esvazia o select de cidades

                        // Percorre o array de cidades obtido por ajax
                        // e coloca no select de cidades
                        resposta.map(function (cidade) {
                            cpCidade.append('<option value="' + cidade.id + '">' + cidade.nome + '</option>');
                        });

                        cpCidade.prop('disabled', false); // Habilita o select de cidades
                    }
                }else{ // se houver erro, interrompe e manda de volta para pagina anterior
                    alert('Houve um erro! Por favor tente novamnete mais tarde.');
                    window.history.back();
                }
            }).fail(function () { // se houver erro, interrompe e manda de volta para pagina anterior
                alert('Houve um erro! Por favor tente novamnete mais tarde.');
                window.history.back();
            });

        }

        // Chama a funcao pela primeira vez pra carregar as
        // cidades do primeiro estado selecionado
        mudaEstado();
    </script>
</body>

</html>