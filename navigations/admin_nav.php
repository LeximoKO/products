<?php 
  if(!defined("NAVIGATION"))
    header('Location: ../index.php');
?>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
  <a class="navbar-brand" href="index.php">Логотип</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="mainNavbar">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a href="index.php" class="nav-link">Главная</a>
      </li>
      <li class="nav-item dropdown">
        <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#">Товары</a>
        <div class="dropdown-menu">
          <?php
              require_once("nav-select-categories.php");
              selectNavCategories($user);
            ?>
        </div>
      </li>
      <li class="nav-item"><a href="#" class="nav-link">О нас</a></li>
      <li class="nav-item"><a href="#" class="nav-link">Контакты</a></li>
    </ul>
    <ul class="navbar-nav navbar-right">
      <li class="nav-item">
        <a href="logout.php?logout=true" class="nav-link"><i class="fas fa-sign-out-alt"></i> Выйти</a>
      </li>
    </ul>
  </div>
</nav>