<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
require_once './_inc/functions.php';

// Supprimer la clé 'user' de la session
unset($_SESSION['user']);

// Redirection vers la page d'accueil
header('Location: index.php');
exit();
?>
<?php

$error = getSessionFlashMessage('error');

// Afficher les messages d'erreur s'il y en a
if ($error) {
    echo '<div class="alert alert-danger">' . $error . '</div>';
}
?>