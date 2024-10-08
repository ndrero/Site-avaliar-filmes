<?php 
require_once __DIR__ . "/../conexao.php";
require_once __DIR__ . "/../funcoes.php";

verificarSessao();

if (!verificarLogin()) {
    $_SESSION['error'] = 'Você precisa estar logado';
    header('Location: login.php');
    exit();
}

$filme = selecionarFilme();
editarFilme();
fazerLogout();


?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar Filme</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>

    <!-- Nav -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="/../index.php">Avaliar filmes</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <?php require_once "../comuns/navbar.php"; ?>
        </div>
      </div>
    </nav>

    <?php include "../comuns/exibirErro.php"; ?>
    <?php include "../comuns/exibirSucesso.php"; ?>
    
    <!-- Avaliar filme -->

    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
      <div class="card" style="width: 500px;">
        <div class="card-header">
          <h3 class="mt-2">Editar filme</h3>
        </div>
        <div class="card-body">

          <form action="editarFilme.php?id=<?php echo $filme['id_filmes']; ?>" method="post">
            <div class="mb-3">
              <label for="nome" class="form-label">Filme</label>
              <input name="nome" type="text" class="form-control" id="nome" value="<?php echo htmlspecialchars($filme['titulo']); ?>" required>
            </div>
            <div class="mb-3">
              <label for="nota" class="form-label">Nota</label>
              <input type="number" class="form-control" id="nota" name="nota" step="0.1" min="0" max="5" value="<?php echo htmlspecialchars($filme['nota']); ?>" required>
            </div>
            <button class="btn btn-primary" type="submit" href="listarFilmes.php">Atualizar</button>
          </form>

        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
