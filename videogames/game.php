<?php
require_once './_inc/functions.php';
require_once './_inc/header.php';
require_once './_inc/nav.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
?>
<?php

$error = getSessionFlashMessage('error');

// Afficher les messages d'erreur s'il y en a
if ($error) {
    echo '<div class="alert alert-danger">' . $error . '</div>';
}
?>
<?php
if (!isset($_GET['id'])) {
  header("Location: index.php");
  exit();
}

$id = $_GET['id'];
$game = get_game_by_id($id);

if (!$game) {
  echo '<h2>Le jeu vidéo que vous recherchez n\'existe pas</h2>';
  exit();
}
?>

<div class="game-details">
  <h2><?= $game['title'] ?></h2>
  <img src="<?= $game['poster'] ?>" alt="<?= $game['title'] ?>" width="400" height="600">
  <p>Description: <?= $game['description'] ?></p>
  <p>Date de sortie: <?= (new DateTime($game['release_date']))->format('d/m/Y') ?></p>
  <p>Prix: <?= $game['price'] ?> €</p>
</div>

<?php
require_once './_inc/footer.php';
?>
