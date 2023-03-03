<?php
    echo '<pre>'; var_dump($_GET); echo '</pre>';

    //décomposition
    [
        'id' => $id,
        'message' => $message,
    ] = $_GET;

    //inclusions
    require_once '_inc/header.php';
    require_once '_inc/nav.php';
?>

    <h1>Products</h1>

    <p>
        Message : <?= $message ?>
        <?php //echo $message ?>
    </p>

<?php
    //inclusions
    require_once '_inc/footer.php';
?>