<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
require_once './_inc/functions.php';
require_once './_inc/header.php';
require_once './_inc/nav.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Appeler la fonction processLoginForm pour traiter le formulaire
  $success = processLoginForm($_POST['email'], $_POST['password']);
  // Si le formulaire a été validé avec succès, rediriger vers la page d'accueil
  if ($user !== null) {
    header('Location: admin/index.php');
    exit;
  } else {
    // Si la connexion échoue, afficher un message d'erreur
    $error = "Identifiants incorrects";
  }
}
?>
<?php

$error = getSessionFlashMessage('error');

// Afficher les messages d'erreur s'il y en a
if ($error) {
    echo '<div class="alert alert-danger">' . $error . '</div>';
}
?>
<div class="container">
  <h1>Connexion à l'espace d'administration</h1>

  <?php
  $message = getSessionFlashMessage('notice');
  if ($message !== null) {
    echo "<div class='notice'>$message</div>";
  }
  ?>

  <form method="post" action="login.php">
    <div class="form-group">
      <label for="email">Adresse e-mail</label>
      <input type="email" name="email" class="form-control" id="email" placeholder="Entrez votre adresse e-mail">
    </div>
    <div class="form-group">
      <label for="password">Mot de passe</label>
      <input type="password" name="password" class="form-control" id="password" placeholder="Entrez votre mot de passe">
    </div>
    <button type="submit" class="btn btn-primary">Se connecter</button>
  </form>
</div>

<?php
require_once './_inc/footer.php';
?>
