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
        echo '<div class="alert alert-danger" role="alert">Erro ao acessar o banco de dados: ' . $e->getMessage() . '</div>';
      }
    } else {
      echo '<div class="alert alert-warning" role="alert">Preencha todos os campos</div>';
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
        header('Location: listarFilmes.php');
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


#Logar na conta

function logarConta($pdo){
  if(verificarPOST()){
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';
    
    if(!empty($usuario) && !empty($senha)){
      try {
        $stmt = $pdo->prepare('SELECT id, senha, nome FROM usuarios WHERE usuario = :usuario');
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        $usuarioData = $stmt->fetch();
  
        if($usuarioData){
          if(password_verify($senha, $usuarioData['senha'])){
            $_SESSION['id_usuario'] = $usuarioData['id'];
            header('Location: index.php');
            exit();
          } else {
            echo '<div class="alert alert-warning" role="alert">Senha incorreta</div>';
          }
        } else {
          echo '<div class="alert alert-warning" role="alert">Usuário não encontrado</div>';
        }
      } catch (PDOException $e){
        echo '<div class="alert alert-danger" role="alert">Erro ao acessar o banco de dados: ' . $e->getMessage() . '</div>';
      }
    } else {
      echo '<div class="alert alert-warning" role="alert">Preencha todos os campos</div>';
    }
  }
}


#Registrar conta

function criarConta(){
  if(verificarPOST()){
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if(!empty($senha) && !empty($usuario)){

      try {
        $hashDaSenha = password_hash($senha, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare('INSERT INTO usuarios (usuario,senha) VALUES (:usuario, :senha)');
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':senha', $hashDaSenha);
        if($stmt->execute()){
          echo '<div class="alert alert-sucess" role="alert"> Conta criada com sucesso </div>';
          header('Location: login.php');
        } else {
          echo '<div class="alert alert-warning" role="alert"> Não foi possível cadastrar a conta. Tente novamente. </div>';
        }
      } catch (PDOException $e){
        echo '<div class="alert alert-danger" role="alert">Erro ao acessar o banco de dados: ' . $e->getMessage() . '</div>';
      }

    } else {
      echo '<div class="alert alert-warning" role="alert">Preencha todos os campos</div>';
    }
  }
}


#Verificar sessão

function verificarSessao(){
  if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }
}

#Verificar login

function verificarLogin(){
  if(verificarSessao()){
    if(isset($_SESSION['id_usuario'])){
      return true;
    } else {
      return false;
    }
  }
}




