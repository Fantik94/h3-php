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

// Afficher les messages d'erreur s'il y en a
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
  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor felis non velit blandit, eu aliquam purus lobortis. Duis sit amet ex risus. Fusce finibus blandit nibh, ac bibendum nulla gravida a. In scelerisque enim vitae lorem aliquet, eu bibendum sapien eleifend. Ut venenatis sapien vel mauris malesuada aliquet. Integer iaculis auctor orci, vel efficitur ipsum fringilla id.</p>

  


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
