<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
require_once './_inc/functions.php';
require_once './_inc/header.php';
require_once './_inc/nav.php';

?>
<?php

$error = getSessionFlashMessage('error');

// Afficher les messages d'erreur s'il y en a
if ($error) {
    echo '<div class="alert alert-danger">' . $error . '</div>';
}
?>
<?php
$games = get_all_games();
?>

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

<?php
require_once './_inc/footer.php';
?>
