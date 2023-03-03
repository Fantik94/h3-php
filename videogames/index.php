<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  include('./_inc/header.php');
  include('./_inc/nav.php');
  require_once './_inc/functions.php';

  $games = get_random_games(3);
?>
<?php

$error = getSessionFlashMessage('error');

if ($error) {
    echo '<div class="alert alert-danger">' . $error . '</div>';
}
?>

<!-- Contenu de la page -->
<div class="container">
<?php
  $message = getSessionFlashMessage('notice');
  if ($message !== null) {
    echo "<div class='notice'><h1 class='text-danger'>$message</h1></div>";
  }
  ?>

<h1>Bienvenue sur notre site web !</h1>

<div class="game-list">
    <?php foreach ($games as $game): ?>
      <div class="game">
        <h2><?= $game['title'] ?></h2>
        <img src="<?= $game['poster'] ?>" alt="<?= $game['title'] ?>" width="300" height="400">
        <p>Prix: <?= $game['price'] ?> €</p>
        <a href="game.php?id=<?= $game['id'] ?>">Consulter</a>
      </div>
    <?php endforeach ?>
</div>
</div>
<?php
  include('./_inc/footer.php');
?>
