<?php
require_once '../conexao/conecta.php';

if(isset($_SESSION['username'])){
    header('Location: produto_listar.php');
}

if(isset($_POST['username'])){
    // Obter as variaveis do FORM de login
    $usuarioLogin = $_POST['username']  ?? '';
    $usuairoSenha = $_POST['senha']     ?? '';

    // Tratar os valores do form para proteger contra SQL Injection
    $usuarioLogin = mysqli_real_escape_string($conexao, $usuarioLogin);
    $usuairoSenha = mysqli_real_escape_string($conexao, $usuairoSenha);

    // Valida se os valores de usuario e senha foram passados
    if($usuarioLogin && $usuairoSenha){

        // Query no banco pra encontrar o usuario com esta combinação de login e senha
        $resultado = mysqli_query($conexao, "SELECT * FROM usuarios_tb WHERE username='$usuarioLogin' AND senha='$usuairoSenha'");

        if($resultado){ // Se a consulta deu certo

            // Converter o resultado em dados para serem usados
            // Fetch assoc retorna null se não vier nenhuma linha do banco
            $usuario = mysqli_fetch_assoc($resultado);

            // Se tem usuario
            if($usuario){

                // Explicar que a sessao, serve para o servidor identificar
                // um navegador que está conectado a ele e tambem para armazenar dados

                // Armazenar os dados do usuario na sessao
                $_SESSION['codigo_usuario'] = $usuario['codigo_usuario'];
                $_SESSION['username']       = $usuario['username'];
                $_SESSION['nome_completo']  = $usuario['nome_completo'];
                $_SESSION['tipo']           = $usuario['tipo'];

                // Redirecionar usuario para a index do admin
                header('Location: produto_listar.php');

            }else{
                $_SESSION['erro'] = 'Usuário ou senha incorreto.';
            }

        }else{ // Se a consulta deu erro
            $_SESSION['erro'] = 'Houve um erro durante o login.';
        }

    }else{ // Senao, cria uma variavel erro na sessao e redireciona pra en  trar.php
        $_SESSION['erro'] = 'Por favor informe um usuário e senha!';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PedeRango</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        img.logo{
            margin: auto;
            width: auto;
            height: auto;
            max-width: 100%;
            max-height: 100%;
        }
    </style>
    <link href="style/signin.css" rel="stylesheet">
</head>

<body class="text-center">

    <form class="form-signin" method="post">

        <!-- Formulario de login -->
        <img class="mb-4 logo" src="../img/pederango_logo1.png" alt="PedeRango logo" title="PedeRango logo">
        <h1 class="h3 mb-3 font-weight-normal">Por favor, entre</h1>

        <!-- Alerta de mensagens -->
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

        <!-- Campo username -->
        <label for="campoUsername" class="sr-only">Username</label>
        <input type="text" name="username" id="campoUsername" class="form-control" placeholder="Username" required autofocus>

        <!-- Campo senha -->
        <label for="campoSenha" class="sr-only">Senha</label>
        <div class="input-group mb-2">
            <input type="password" class="form-control" name="senha" id="campoSenha" placeholder="Senha">
            <div onmousedown="clicou()" onmouseup="soltou()" class="input-group-prepend">
                <div class="input-group-text"><i id="olho" class="fa fa-eye"></i></div>
            </div>
        </div>

        <!-- Botão entrar -->
        <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>

        <!-- Copyright -->
        <p class="mt-5 mb-3 text-muted">© <?php print date('Y') ?></p>
    </form>
    <script>
        var senhaCp = document.getElementById('campoSenha');
        var olho = $('#olho');
        function clicou() {
            senhaCp.type = 'text';
            olho.addClass('fa-eye-slash');
        }

        function soltou() {
            senhaCp.type = 'password';
            olho.removeClass('fa-eye-slash');
        }
    </script>

</body>

</html>