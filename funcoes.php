<?php


if($_GET['filme'] != 0){
  foreach ($arrayLista as $chave => $item){
    if($item['nome'] == $_GET['filme']){
      unset($arrayLista[$chave]);
      break;
    }
  }
}