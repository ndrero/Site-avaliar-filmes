<?php 

$conteudoLista = file_get_contents("./lista.json");

$arrayLista = json_decode($conteudoLista, true);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $nomeFilme = ucfirst($_POST['nome']) ?? '';
  $notaFilme = $_POST['nota'] ?? '';

  if (!empty($nomeFilme) && !empty($notaFilme)){
    $arrayLista[] = [
      'nome' => $nomeFilme,
      'nota' => $notaFilme
    ];
  }
}

if (isset($_GET['acao']) && $_GET['acao'] == 'excluir'){
  if($_GET['filme'] != 0){
    foreach ($arrayLista as $chave => $item){
      if($item['nome'] == $_GET['filme']){
        unset($arrayLista[$chave]);
        break;
      }
    }
  }
}


$conteudoLista = json_encode($arrayLista);

file_put_contents("./lista.json", $conteudoLista);


?>





<!DOCTYPE html>
<html lang="pt-br">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  
  <body>

    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
      <div class="card" style="width: 500px;">
        <div class="card-header">
          <h3 class="mt-2">Avaliar filme</h3>
        </div>
        <div class="card-body">

          <form action="index.php" method="post">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Filme</label>
              <input name="nome" type="text" class="form-control" id="exampleFormControlInput1" placeholder="">
            </div>
            <div class="mb-3">
              <label for="numberInput" class="form-label">Nota</label>
              <input type="number" class="form-control" id="numberInput" name="nota" step="0.1" min="0" max="5">
            </div>
            <button class="btn btn-primary" type="submit">Enviar</button>
          </form>

          <br>

          <h5>Filmes registrados</h5>

          <?php if (count($arrayLista) == 0): ?>
            <div class="container mt-3">
              <div class="alert alert-warning" role="alert">
                  <strong>Aviso!</strong> Você ainda não possui filmes registrados.
              </div>
            </div>

          <?php else: ?>
            <ul class="list-group">
              <?php foreach ($arrayLista as $item): ?>
                  <li class="list-group-item fs-5"> <?php echo $item['nome'] . ' - ' . $item['nota']; ?> 
                    <a class="btn btn-danger btn-sm" href="?acao=excluir&filme=<?php echo $item['nome'] ?>" role="button">Excluir</a>
                  </li>
              <?php endforeach ?>
            </ul>

          <?php endif ?>
          
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>

<?php


?>
