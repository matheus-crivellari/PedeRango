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

                <div class="row">
                    <div class="col-8 offset-2">
                        <h1>Cadastro de usuário</h1>
                        <hr>
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
                            <div class="form-row">
                                <div class="col-6">
                                    <input type="submit" class="btn btn-block btn-primary " value="Salvar">
                                </div>
                                <div class="col-6">
                                    <input type="reset"  class="btn btn-block btn-secondary" value="Limpar">
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