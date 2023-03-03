<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

require_once 'functions.php';
?>
<nav class="navbar navbar-expand-lg bg-dark">
<div class="container d-flex justify-content-start m-0">
  <a href="/" class="navbar-brand"><img src="../img/logo.png" alt="Logo" class="logo"></a>
  <ul class="navbar-nav d-flex">
    <li  class="nav-item"><a href="/" class="nav-link text-light">Accueil</a></li>
    <li  class="nav-item"><a href="../contact.php" class="nav-link text-light">Contact</a></li>
    <li  class="nav-item"><a href="/games.php" class="nav-link text-light">Games</a></li>
    <?php
    // Tester si l'utilisateur est connecté
    $user = getSessionData('user');
    if ($user !== null) {
      // L'utilisateur est connecté
      echo '<li class="nav-item ">';
      echo '<a class="nav-link text-light" href="/admin/index.php">ADMIN INDEX</a>';
      echo '</li>';
      echo '<li class="nav-item ">';
      echo '<a class="nav-link text-light" href="logout.php">Logout</a>';
      echo '</li>';
    } else {
      // L'utilisateur n'est pas connecté
      echo '<li class="nav-item">';
      echo '<a class="nav-link text-light" href="login.php">Login</a>';
      echo '</li>';
    }
    ?>
  </ul>
</div>
</nav>
