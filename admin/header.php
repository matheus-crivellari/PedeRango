<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php">PedeRango</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item <?php if($area == 'produto') print 'active' ?>">
        <a class="nav-link" href="produto_listar.php">Produtos</a>
      </li>
      <li class="nav-item <?php if($area == 'pedido') print 'active' ?>">
        <a class="nav-link" href="pedido_listar.php">Pedidos</a>
      </li>
      <li class="nav-item <?php if($area == 'usuario') print 'active' ?>">
        <a class="nav-link" href="usuario_listar.php">Usuários</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php"><i class="fa fa-sign-out"></i> Sair</a>
      </li>
    </ul>
    <?php if(isset($_SESSION['nome_completo'])): ?>
      <span class="navbar-text">
        Bem vindo, <strong><?php print $_SESSION['nome_completo'] ?></strong>
      </span>
    <?php endif;?>
  </div>
</nav>