<?php
define('UPLOAD_DIR', __DIR__ . '/img/');

function processContactForm($name, $email, $message)
{
  $errors = validateContactForm($name, $email, $message);

  if (empty($errors)) {
    // Envoyer le message de contact par e-mail ou le sauvegarder dans la base de données

    // Enregistrer un message flash dans la session pour informer l'utilisateur que le message a été envoyé avec succès
    $_SESSION['notice'] = "Vous serez contacté dans les plus brefs délais.";

    // Rediriger l'utilisateur vers la page d'accueil
    header('Location: index.php');
    exit();
  }

  return $errors;
}

function validateContactForm($name, $email, $message)
{
  $errors = [];

  // Vérifier le nom
  if (empty($name)) {
    $errors[] = "Le nom est obligatoire.";
  }

  // Vérifier l'adresse e-mail
  if (empty($email)) {
    $errors[] = "L'adresse e-mail est obligatoire.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "L'adresse e-mail n'est pas valide.";
  }

  // Vérifier le message
  if (empty($message)) {
    $errors[] = "Le message est obligatoire.";
  }

  return $errors;
}


function isEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function isLong($value) {
    return strlen($value) >= 10;
}

function connect_db() {
    $host = 'localhost'; // remplacer par votre hôte de base de données
    $username = 'root'; // remplacer par votre nom d'utilisateur
    $password = ''; // remplacer par votre mot de passe
    $database = 'videogames'; // remplacer par le nom de votre base de données
    
    $conn = new mysqli($host, $username, $password, $database);
    
    if ($conn->connect_error) {
      die("Connexion échouée: " . $conn->connect_error);
    }
    
    return $conn;
  }

  // fonction pour retourner n jeux vidéo sélectionnés aléatoirement
function get_random_games($n) {
    $conn = connect_db();
    $sql = "SELECT * FROM game ORDER BY RAND() LIMIT $n";
    $result = $conn->query($sql);
    $games = array();
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $games[] = $row;
      }
    }
    $conn->close();
    return $games;
  }
  
  // fonction pour retourner tous les jeux vidéo présents dans la table game
  function get_all_games() {
    $conn = connect_db();
    $sql = "SELECT * FROM game";
    $result = $conn->query($sql);
    $games = array();
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $games[] = $row;
      }
    }
    $conn->close();
    return $games;
  }
  
  // fonction pour retourner un jeu vidéo à l'aide de son identifiant
  function get_game_by_id($id) {
    $conn = connect_db();
    $sql = "SELECT game.*, GROUP_CONCAT(category.id SEPARATOR ',') AS category_ids FROM game 
    LEFT JOIN game_category ON game.id = game_category.game_id 
    LEFT JOIN category ON game_category.category_id = category.id 
    WHERE game.id = $id";
    $result = $conn->query($sql);
    $game = null;
    if ($result->num_rows > 0) {
      $game = $result->fetch_assoc();
    }
    $conn->close();
    return $game;
  }

  function validateLoginForm($email, $password) {
    $errors = array();
  
    if (empty($email)) {
      $errors[] = "L'adresse e-mail est obligatoire.";
    }
  
    if (empty($password)) {
      $errors[] = "Le mot de passe est obligatoire.";
    }
  
    return $errors;
  }

  function get_admin_by_email($email) {
    $conn = connect_db();
    $email = $conn->real_escape_string($email);
    $sql = "SELECT * FROM admin WHERE email='$email'";
    $result = $conn->query($sql);
    $admin = null;

    if ($result->num_rows > 0) {
      $admin = $result->fetch_assoc();
    }
    $conn->close();
    return $admin;
}

function verify_admin_credentials($email, $password) {
    $admin = get_admin_by_email($email);
    // exit(var_dump( password_verify($password, $admin['password'])  ));
    if (!$admin) {
      return false;
    }
    return password_verify($password, $admin['password']);
  }

  
  function getSessionFlashMessage($key)
  {
    if (array_key_exists($key, $_SESSION)) {
      $value = $_SESSION[$key];
      unset($_SESSION[$key]);
      return $value;
    }
    return null;
  }

  
  function processLoginForm($email, $password)
  {
    $errors = validateLoginForm($email, $password);
    if (empty($errors)) {
      // Vérifier si les identifiants de l'administrateur sont valides
      if (verify_admin_credentials($email, $password)) {
        // Stocker l'identifiant de l'administrateur dans la session
        $admin_id = get_admin_by_email($email);
        $_SESSION['user'] = $admin_id;
        // Rediriger l'utilisateur vers la page d'accueil
        header('Location: index.php');
        exit();
      } else {
        $errors[] = "Identifiants incorrects.";
      }
    } else {
      // Enregistrer un message flash dans la session pour informer l'utilisateur des erreurs
      $_SESSION['notice'] = "Identifiants incorrects.";
    }
    
    return $errors;
  }
  function getSessionData($key)
  {
    if (array_key_exists($key, $_SESSION)) {
      return $_SESSION[$key];
    } else {
      return null;
    }
  }

  function checkAuthentication() {
    if (!array_key_exists('user', $_SESSION)) {
      $_SESSION['notice'] = 'Accès refusé';
      header('Location: ../index.php');
      exit;
    }
  }
  
  function processGameForm($data)
{
    // Validation des données du formulaire
    $constraints = getGameFormConstraints();
    $errors = validateData($data, $constraints);
    var_dump($data['title'], $data['description'], $data['release_date']);
    // Si le formulaire n'est pas valide, stocker les erreurs dans la session et rediriger
    if (!empty($errors)) {
        $_SESSION['form_errors'] = $errors;
        $_SESSION['form_data'] = $data;
        return false;
    }

    // Récupération des données du formulaire
    $id = $data['id'];
    $title = $data['title'];
    $description = $data['description'];
    $release_date = $data['release_date'];
    $poster = $data['poster'];
    $price = $data['price'];
      
    // Vérification si c'est une création ou une modification
    if (empty($id)) {
        // Création d'un nouveau jeu vidéo
        insertGame($title, $description, $release_date, $poster, $price);
    } else {
        // Modification d'un jeu vidéo existant
        updateGame($id, $title, $description, $release_date, $poster, $price);
    }

    // Redirection vers la liste des jeux vidéo
    header('Location: index.php');
    exit;
}

/**
 * Retourne les contraintes de validation du formulaire des jeux vidéo
 *
 * @return array Les contraintes de validation
 */
function getGameFormConstraints()
{
    return [
        'id' => [], // Champ caché, pas besoin de validation
        'title' => [
            'required' => true,
            'min_length' => 3,
            'max_length' => 255,
        ],
        'description' => [
            'required' => true,
            'min_length' => 10,
        ],
        'release_date' => [
            'required' => true,
            'date_format' => 'Y-m-d',
        ],
        'poster' => [
            'required' => true,
            'url' => true,
            'max_length' => 255,
        ],
        'price' => [
            'required' => true,
            'numeric' => true,
            'isFloatInRange' => true,
        ],
    ];
}

function isFloatInRange($input, $min, $max)
{
    $options = [
        'options' => [
            'min_range' => $min,
            'max_range' => $max,
        ],
    ];

    return filter_var($input, FILTER_VALIDATE_FLOAT, $options) !== false;
}

function insertGame($data)
{
  $conn=connect_db();

  $title = $data['title'];
  $description = $data['description'];
  $releaseDate = $data['release_date'];
  $poster = $data['poster'];
  $price = $data['price'];
  $categoryIds = $data['categories'];
  $editorId = $data['editor_id'];

  // Disable autocommit to start a transaction
  $conn->autocommit(FALSE);

  try {
    $poster = uploadImage('poster', '../../img');
    // Insert the game record
    $stmt = $conn->prepare("INSERT INTO game (title, description, release_date, poster, price, editor_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssdi", $title, $description, $releaseDate, $poster, $price, $editorId);
    $stmt->execute();

    // Get the game ID generated by the auto-increment
    $gameId = $conn->insert_id;

    // Insert the game_category records
    $stmt = $conn->prepare("INSERT INTO game_category (game_id, category_id) VALUES (?, ?)");
    foreach ($categoryIds as $categoryId) {
      $stmt->bind_param("ii", $gameId, $categoryId);
      $stmt->execute();
    }

    // Commit the transaction
    $conn->commit();

    return true;

  } catch (Exception $e) {
    // Rollback the transaction on error
    $conn->rollback();
    throw $e;
  } finally {
    // Re-enable autocommit
    $conn->autocommit(TRUE);
  }
}


function validateData($data) {
  $errors = [];
  
  // Vérification du titre
  if (empty($data['title'])) {
    $errors[] = "Le champ titre est obligatoire.";
  } else if (strlen($data['title']) > 255) {
    $errors[] = "Le champ titre ne doit pas dépasser 255 caractères.";
  }
  
  // Vérification de la description
  if (empty($data['description'])) {
    $errors[] = "Le champ description est obligatoire.";
  }
  
  // Vérification de la date de sortie
  if (empty($data['release_date'])) {
    $errors[] = "Le champ date de sortie est obligatoire.";
  } else {
    $date = DateTime::createFromFormat('Y-m-d', $data['release_date']);
    if (!$date || $date->format('Y-m-d') !== $data['release_date']) {
      $errors[] = "Le champ date de sortie doit être au format AAAA-MM-JJ.";
    }
  }
  
  // Vérification de l'image
  if (empty($data['poster'])) {
    $errors[] = "Le champ image est obligatoire.";
  }
  
  // Vérification du prix
  if (empty($data['price'])) {
    $errors[] = "Le champ prix est obligatoire.";
  } else if (!isFloatInRange($data['price'], 0, 999.99)) {
    $errors[] = "Le champ prix doit être un nombre décimal compris entre 0 et 999.99.";
  }
  
  return $errors;
}

function updateGame($data)
{
  $conn = connect_db();

  $id = $data['id'];
  $title = $data['title'];
  $description = $data['description'];
  $releaseDate = $data['release_date'];
  $poster = $data['poster'];
  $price = $data['price'];
  $categoryIds = $data['categories'];
  $editorId = $data['editor_id'];
  $currentPoster = $data['current_poster'];
  // Disable autocommit to start a transaction
  $conn->autocommit(FALSE);

  try {
    // Delete all game_category records for the game
    $stmt = $conn->prepare("DELETE FROM game_category WHERE game_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Update the game record
    $stmt = $conn->prepare("UPDATE game SET title=?, description=?, release_date=?, poster=?, price=?, editor_id=? WHERE id=?");
    $stmt->bind_param("ssssdii", $title, $description, $releaseDate, $poster, $price, $editorId, $id);
    $stmt->execute();

    if ($poster && $poster !== $currentPoster) {
      deleteGameFile($currentPoster, UPLOAD_DIR);
    }

    // Insert the game_category records
    $stmt = $conn->prepare("INSERT INTO game_category (game_id, category_id) VALUES (?, ?)");
    foreach ($categoryIds as $categoryId) {
      $stmt->bind_param("ii", $id, $categoryId);
      $stmt->execute();
    }

    // Commit the transaction
    $conn->commit();

    return true;

  } catch (Exception $e) {
    // Rollback the transaction on error
    $conn->rollback();
    throw $e;
  } finally {
    // Re-enable autocommit
    $conn->autocommit(TRUE);
  }
}



function deleteGame($id)
{
  $conn = connect_db();

  // Disable autocommit to start a transaction
  $conn->autocommit(FALSE);

  try {

    
    // Delete the game_category records for the game being deleted
    $stmt = $conn->prepare("DELETE FROM game_category WHERE game_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Delete the game record
    $stmt = $conn->prepare("DELETE FROM game WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Commit the transaction
    $conn->commit();

    // Set a notice in the session
    $_SESSION['notice'] = "Jeu vidéo supprimé";

  } catch (Exception $e) {
    // Rollback the transaction on error
    $conn->rollback();
    throw $e;
  } finally {
    // Re-enable autocommit
    $conn->autocommit(TRUE);
  }

  
}


function getAllEditors() {
  $conn = connect_db();
  $sql = "SELECT * FROM editor";
  $result = $conn->query($sql);
  $editors = array();
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $editors[] = $row;
    }
  }
  $conn->close();
  return $editors;
}

function getAllCategories() {
  $conn = connect_db();
  $sql = "SELECT * FROM category";
  $result = $conn->query($sql);
  $categories = [];
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $categories[] = $row;
    }
  }
  $conn->close();
  return $categories;
}

function getValues($post, $keys)
{
    $values = [];
    foreach ($keys as $key) {
        if (isset($post[$key])) {
            $values[$key] = trim($post[$key]);
        }
    }
    return $values;
}

function processGameFile(array $file, string $destination, ?string $existingFilename = null): ?string
{
    if (empty($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
        return $existingFilename;
    }

    // Validate the uploaded file
    $filename = basename($file['name']);
    $fileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($fileType, $allowedTypes)) {
        throw new Exception('Invalid file type. Only JPG, PNG, and GIF files are allowed.');
    }
    if ($file['size'] > 5 * 1024 * 1024) {
        throw new Exception('File size exceeded. The maximum file size is 5 MB.');
    }

    // Generate a unique filename for the uploaded file
    $newFilename = uniqid('', true) . '.' . $fileType;
    $destination = rtrim($destination, '/') . '/';
    $fullPath = $destination . $newFilename;

    // Move the uploaded file to the destination directory
    if (!move_uploaded_file($file['tmp_name'], $fullPath)) {
        throw new Exception('Error uploading file.');
    }

    // Delete the existing file, if any
    if ($existingFilename && file_exists($destination . $existingFilename)) {
        unlink($destination . $existingFilename);
    }

    return $newFilename;
}

function deleteGameFile(?string $filename, string $destination): void
{
    if ($filename && file_exists($destination . $filename)) {
        unlink($destination . $filename);
    }
}

function uploadImage($fileFieldName, $destinationFolder) {
  $fileName = '';
  if (isset($_FILES[$fileFieldName]) && $_FILES[$fileFieldName]['error'] === UPLOAD_ERR_OK) {
    $fileName = uniqid() . '-' . $_FILES[$fileFieldName]['name'];
    $destinationPath = $destinationFolder . '/' . $fileName;
    if (move_uploaded_file($_FILES[$fileFieldName]['tmp_name'], $destinationPath)) {
      return $fileName;
    }
  }
  return $fileName;
}


?>
