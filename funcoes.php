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

function registrarFilme(){
  global $pdo;
  if(verificarPOST()){
    $nomeFilme = ucfirst(trim($_POST['nome'] ?? ''));
    $notaFilme = trim($_POST['nota'] ?? '');
  
    if (!empty($nomeFilme) && !empty($notaFilme)){
      try {
        $stmt = $pdo->prepare('INSERT INTO filmes (titulo, nota) VALUES (:titulo, :nota)');
        $stmt->bindParam(':titulo', $nomeFilme);
        $stmt->bindParam(':nota', $notaFilme);
        $stmt->execute();
        $_SESSION['success'] = 'Filme registrado com sucesso'; 
      } catch (PDOException $e) {
        $_SESSION['error'] = 'Erro ao registrar no banco de dados';   
      }
    } else {
      $_SESSION['error'] = 'Preencha todos os campos!';
    }
  }
}

#Excluir filmes

function excluirFilme(){
  global $pdo;
  if (isset($_GET['acao']) && $_GET['acao'] == 'excluir'){
    if(!empty($_GET['id'])){
      try {
        $idFilme = $_GET['id'];
        $stmt = $pdo->prepare('DELETE FROM filmes WHERE id_filmes = :id');
        $stmt->bindParam(':id', $idFilme);
        $stmt->execute();
        $_SESSION['success'] = 'Filme excluído com sucesso'; 
        header('Location: listarFilmes.php');
        exit();
      } catch (PDOException $e){
        $_SESSION['error'] = 'Erro ao registrar no banco de dados';   
      }
    } 
  }
}

#Criar lista de filmes

  function listaDeFilmes(){
    global $pdo;
    try {
      $stmt = $pdo->prepare('SELECT * FROM filmes');
      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e){
      $_SESSION['error'] = 'Erro ao registrar no banco de dados';  
    }
  }


#Logar na conta

function logarConta(){
  global $pdo;
  verificarSessao();

  if(verificarPOST()){
    $usuario = trim($_POST['usuario'] ?? '');
    $senha = trim($_POST['senha'] ?? '');
    
    if(!empty($usuario) && !empty($senha)){
      try {
        $stmt = $pdo->prepare('SELECT id_usuario, senha, nome FROM usuarios WHERE usuario = :usuario');
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        $usuarioData = $stmt->fetch();
  
        if($usuarioData){
          if(password_verify($senha, $usuarioData['senha'])){
            $_SESSION['id_usuario'] = $usuarioData['id_usuario'];
            $_SESSION['nome_usuario'] = $usuarioData['nome'];
            $_SESSION['success'] = 'Conta logada com sucesso'; 
            header('Location: ../index.php');
          } else {
            $_SESSION['error'] = 'Senha incorreta';  
          }
        } else {
          $_SESSION['error'] = 'Usuário não encontrado';  
        }
      } catch (PDOException $e){
        $_SESSION['error'] = 'Erro ao registrar no banco de dados';  
      }
    } else {
      $_SESSION['error'] = 'Preencha todos os campos';  
    }
  }
}


#Registrar conta

function criarConta(){
  global $pdo;
  if(verificarPOST()){
    $usuario =  trim($_POST['usuario'] ?? '');
    $nome = trim($_POST['nome'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if(!empty($senha) && !empty($usuario)){

      try {
        $hashDaSenha = password_hash($senha, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare('INSERT INTO usuarios (usuario, nome, senha) VALUES (:usuario, :nome, :senha)');
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':senha', $hashDaSenha);
        if($stmt->execute()){
          $_SESSION['success'] = 'Conta criada com sucesso'; 
          header('Location: login.php');
        } else {
          $_SESSION['error'] = 'Não foi possível cadastrar sua conta. Tente novamente';  
        }
      } catch (PDOException $e){
        $_SESSION['error'] = 'Erro ao registrar no banco de dados';  
      }

    } else {
      $_SESSION['error'] = 'Preencha todos os campos';  
    }
  }
}


#Setar sessão

function verificarSessao(){
  if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }
  return true;
}

#Verificar login

function verificarLogin(){
  verificarSessao();

  if(isset($_SESSION['id_usuario'])){
    return true;
  } else {
    return false;
  }
}

#Selecionar filme

function selecionarFilme(){
  global $pdo;
  if(isset($_GET['id']) && is_numeric($_GET['id'])){
    try {
      $idFilme = $_GET['id'];
      $stmt = $pdo->prepare('SELECT * FROM filmes WHERE id_filmes = :id');
      $stmt->bindParam(':id', $idFilme);
      $stmt->execute();
      if ($filme = $stmt->fetch()) {
        return $filme;
      } else {
        $_SESSION['error'] = 'Filme não encontrado';  
        return null;
      }
    } catch(PDOException $e) {
      $_SESSION['error'] = 'Erro ao registrar no banco de dados';  
      return null;
    }
  }

  if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $_SESSION['error'] = 'ID inválido';  
  }
}

#Editar filme

function editarFilme(){
  global $pdo;
  $filme = selecionarFilme($pdo);
  if($filme){
    if(verificarPOST()){
      $nomeFilme = ucfirst(trim($_POST['nome'] ?? ''));
      $notaFilme = trim($_POST['nota'] ?? '');

      if (!empty($nomeFilme) && !empty($notaFilme)){
        try {
          $idFilme = $filme['id_filmes'];
          $stmt = $pdo->prepare('UPDATE filmes SET titulo = :titulo, nota = :nota WHERE id_filmes = :id');
          $stmt->bindParam(':titulo', $nomeFilme);
          $stmt->bindParam(':nota', $notaFilme);
          $stmt->bindParam(':id', $idFilme);
          $stmt->execute();
          $_SESSION['success'] = 'Filme editado com sucesso';
          header('Location: listarFilmes.php');
          exit();
        } catch (PDOException $e) {
          $_SESSION['error'] = 'Erro ao registrar no banco de dados';  
        }
      } else {
        $_SESSION['error'] = 'Preencha todos os campos';  
      }
    }
  }
}

#Deslogar da conta

function fazerLogout(){
  if (isset($_GET['acao']) && $_GET['acao'] == 'logout'){
    try {
      unset($_SESSION['id_usuario']);
      $_SESSION['success'] = 'Deslogou com sucesso'; 
      $redirectUrl = strtok($_SERVER['PHP_SELF'], '?');
      header('Location: ' . $redirectUrl);
    } catch (PDOException $e){
      $_SESSION['error'] = 'Erro ao deslogar';   
    }
  }
}