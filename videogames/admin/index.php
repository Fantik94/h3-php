<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  include('../_inc/header.php');
  include('./_inc/nav.php');
  require_once '../_inc/functions.php';
  checkAuthentication();
?>

<a href="/admin/games/index.php">INDEX GAMES ADMIN</a>

<?php
include('../_inc/footer.php');
?>