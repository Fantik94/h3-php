<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  include('../../_inc/header.php');
  include('../_inc/nav.php');
  require_once '../../_inc/functions.php';
  checkAuthentication();
  $editors = getAllEditors();
  $categories = getAllCategories();
  if(isset($_GET['id'])){
    $get_game = get_game_by_id($_GET['id']);
    // var_dump($get_game);
  }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $errors = validateData($data);
    if (empty($errors)) {
      // var_dump(!isset($_GET['id'])); exit;
        if(!isset($_GET['id'])){
        $game_id = insertGame($data);
        $_SESSION['notice'] = "Jeu vidéo ajouté";
        header('Location: index.php');
        exit;
        }
        else{
        $game_id=updateGame($data);
        $_SESSION['notice'] = "Jeu vidéo modifié";
        header('Location: index.php');
        exit;
        }
    }
  }
?>
<div class="container">
<form method="POST">
  <input type="hidden" name="id" value="">
  <div class="form-group mt-3">
    <label for="title">Titre :</label>
    <input type="text" name="title" id="title" class="form-control" value="<?= $get_game['title'] ?? null ?>" required>
  </div>
  <div class="form-group mt-3">
    <label for="description">Description :</label>
    <textarea name="description" id="description" class="form-control" required ><?= $get_game['description'] ?? null ?></textarea>
    </div>
  <div class="form-group mt-3">
    <label for="release_date">Date de sortie :</label>
    <input type="date" name="release_date" id="release_date" class="form-control" value="<?= $get_game['release_date'] ?? null ?>" required>
    </div>
    <div class="form-group mt-3">
    <label for="poster">Affiche :</label>
    <?php if (isset($game['poster'])): ?>
      <div class="mb-2">
        <img src="<?php echo $game['poster']; ?>" alt="<?php echo $game['title']; ?>" height="100">
      </div>
    <?php endif; ?>
    <input type="file" class="form-control-file" id="poster" name="poster" <?php if (!isset($game['id'])): ?>required<?php endif; ?>>
  </div>
  <div class="form-group mt-3">
    <label for="poster">URL de l'affiche :</label>
    <input type="text" name="poster" id="poster" class="form-control" value="<?= $get_game['poster'] ?? null ?>">
    </div>
  <div class="form-group mt-3">
    <label for="price">Prix :</label>
    <input type="text" name="price" id="price" class="form-control" value="<?= $get_game['price'] ?? null ?>" required>
  </div>
  <div class="form-group mt-3">
    <?php 
    echo '<label for="editor_id">Editeur :</label>';
    echo '<select name="editor_id" id="editor_id" value="<?= $get_game[\'editor_id\'] ?? null ?>">';
    foreach ($editors as $editor) {
        echo '<option value="' . $editor['id'] . '">' . $editor['name'] . '</option>';
    }
    echo '</select>';
    ?>
  </div>
  <div class="form-group mt-3">
  <?php foreach ($categories as $category): ?>
  <div>
  <input type="checkbox" id="category_<?php echo $category['id']; ?>" name="categories[]" value="<?php echo $category['id']; ?>" >
    <label for="category_<?php echo $category['id']; ?>"><?php echo $category['name']; ?></label>
  </div>
  <?php endforeach; ?>
  </div>
  <div class="d-flex justify-content-center">
    <input type="hidden" name="id" value="<?= $get_game['id'] ?? null ?>">
    <?php 
    if(isset($get_game['id'])){
      echo '<button type="submit" class="btn btn-warning mt-3 ">Modifier</button>';
    }
    else {
      echo '<button type="submit" class="btn btn-success mt-3 ">Ajouter</button>';
    }
    ?>
    
  </div>
</form>
</div>

<?php
include('../../_inc/footer.php');
?>
