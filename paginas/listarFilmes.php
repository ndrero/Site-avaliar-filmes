<?php 

require_once __DIR__ . "/../conexao.php";
require_once  __DIR__ . "/../funcoes.php";

verificarSessao();

if (!verificarLogin()) {
    $_SESSION['error'] = 'Você precisa estar logado';
    header('Location: login.php');
    exit();
}


excluirFilme();
$resultados = listaDeFilmes();
editarFilme();
fazerLogout();
$indice = 0;


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listagem de filmes</title>
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

  <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card" style="width: 500px;">

      <div class="card-body">

        <h3 class="mt-2">Listar filmes</h3>

        <?php if (empty($resultados)): ?>
          <div class="container mt-3">
            <div class="alert alert-warning" role="alert">
                <strong>Aviso!</strong> Você ainda não possui filmes registrados.
            </div>
          </div>

        <?php else: ?>

          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Filme</th>
                <th scope="col">Nota</th>
                <th scope="col">Excluir</th>
                <th scope="col">Editar</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($resultados as $item): ?>
              <tr>
                <th scope="row"> <?php echo $indice++; ?> </th>
                <td> <?php echo $item['titulo']; ?> </td>
                <td> <?php echo $item['nota']; ?> </td>
                <td><a class="btn btn-danger btn-sm" role="button" href="?acao=excluir&id=<?php echo $item['id_filmes'] ?>">Excluir</a></td>
                <td><a class="btn btn-primary btn-sm" role="button" href="editarFilme.php?id=<?php echo $item['id_filmes']; ?>">Editar</a></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>

        <?php endif ?>
        
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>