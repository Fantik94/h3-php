<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
require_once './_inc/functions.php';

unset($_SESSION['user']);

header('Location: index.php');
exit();
?>
<?php

$error = getSessionFlashMessage('error');

if ($error) {
    echo '<div class="alert alert-danger">' . $error . '</div>';
}
?>