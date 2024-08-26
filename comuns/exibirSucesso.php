<?php

if(isset($_SESSION['success']) && !empty($_SESSION['success'])){
  echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
  unset($_SESSION['success']);
}

