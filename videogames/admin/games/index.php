<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  include('../../_inc/header.php');
  include('../_inc/nav.php');
  require_once '../../_inc/functions.php';
  checkAuthentication();
  $games = get_all_games();

?>
<div class="container">
<?php
  $message = getSessionFlashMessage('notice');
  if ($message !== null) {
    echo "<div class='notice'><h1 class='text-danger'>$message</h1></div>";
  }
  ?>
<table class="table table-striped">
  <thead>
    <tr>
      <th>Image</th>
      <th>Titre</th>
      <th>Prix</th>
      <th>Date de sortie</th>
      <th>Editeur</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($games as $game) { ?>
      <tr>
        <td><img src="<?php echo $game['poster']; ?>" alt="<?php echo $game['title']; ?>"></td>
        <td><?php echo $game['title']; ?></td>
        <td><?php echo $game['price']; ?> €</td>
        <td><?php echo date('d/m/Y', strtotime($game['release_date'])); ?></td>
        <td><?php echo $game['editor_id']; ?></td>
        <td>
          <a href="form.php?id=<?php echo $game['id']; ?>" class="text-decoration-none text-white"><button class="btn btn-warning">Modifier</button></a>
          <a href="delete.php?id=<?php echo $game['id']; ?>" class="text-decoration-none text-white"><button class="btn btn-danger">Supprimer</button></a>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>
<a href="form.php" class="text-decoration-none text-white"><button class="btn btn-success">Ajouter</button></a>
</div>



<?php
include('../../_inc/footer.php');
?>