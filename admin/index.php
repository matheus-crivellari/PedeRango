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
    <form class="form-signin">
        <img class="mb-4 logo" src="../img/pederango_logo1.png" alt="PedeRango logo" title="PedeRango logo">
        <h1 class="h3 mb-3 font-weight-normal">Por favor, entre</h1>

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