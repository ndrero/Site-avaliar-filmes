<?php

require_once __DIR__ . "/../conexao.php";
require_once __DIR__ . "/../funcoes.php";

session_start();

if (isset($_SESSION['alerta_login'])) {
    echo '<div class="alert alert-warning" role="alert">'.$_SESSION['alerta_login'].'</div>';
    unset($_SESSION['login_warning']);
}


logarConta($pdo);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
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
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="/../paginas/criarConta.php">Criar conta</a>
        <a class="nav-link active" aria-current="page" href="/../paginas/login.php">Fazer login</a>
        <a class="nav-link" href="/../paginas/listarFilmes.php">Listar filmes</a>
        <a class="nav-link" href="/../paginas/registrarFilme.php">Registrar filme</a>
      </div>
    </div>
  </div>
  </nav>

  <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card" style="width: 500px;">
      <div class="card-header">
        <h3 class="mt-2">Login</h3>
      </div>
      <div class="card-body">
        <div class="login-container">

          <form action="/login" method="POST">
            <input type="text" name="usuario" placeholder="Nome de Usuário" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button class="btn btn-primary btn-sm" type="submit">Enviar</button>
          </form>
          <br>
          <p>Ainda não possui uma conta? <a href="criarConta.php">Crie sua conta</a></p>
        </div>
      </div>
    </div>
  </div>

  <script  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>


