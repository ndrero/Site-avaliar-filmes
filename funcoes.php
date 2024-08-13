<?php

require_once __DIR__ . "/conexao.php";

# Verificar se é POST

function verificarPOST(){
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    return true;
  }
  return false;
}

# Adicionar filmes

function registrarFilme($pdo){
  if(verificarPOST()){
    $nomeFilme = ucfirst($_POST['nome']) ?? '';
    $notaFilme = $_POST['nota'] ?? '';
  
    if (!empty($nomeFilme) && !empty($notaFilme)){
      try {
        $stmt = $pdo->prepare('INSERT INTO filmes (titulo, nota) VALUES (:titulo, :nota)');
        $stmt->bindParam(':titulo', $nomeFilme);
        $stmt->bindParam(':nota', $notaFilme);
        $stmt->execute();
      } catch (PDOException $e) {
        echo '<div class="alert alert-warning" role="alert"> Não foi possível realizar a operação. Erro' . $e->getMessage() . '</div>';
      }
    }
  }
}

#Excluir filmes

function excluirFilme($pdo){
  if (isset($_GET['acao']) && $_GET['acao'] == 'excluir'){
    if(!empty($_GET['id'])){
      try {
        $idFilme = $_GET['id'];
        $stmt = $pdo->prepare('DELETE FROM filmes WHERE idfilmes = :id');
        $stmt->bindParam(':id', $idFilme);
        $stmt->execute();
        header('Location: index.php');
        exit();
      } catch (PDOException $e){
        echo '<div class="alert alert-warning" role="alert"> Não foi possível deletar o filme. Erro' . $e->getMessage() . '</div>';
      }
    }
  }
}

#Criar lista de filmes

  function listaDeFilmes($pdo){
    try {
      $stmt = $pdo->prepare('SELECT * FROM filmes');
      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e){
      echo '<div class="alert alert-warning" role="alert"> Não foi possível listar os filmes. Erro' . $e->getMessage() . '</div>';
    }
  }