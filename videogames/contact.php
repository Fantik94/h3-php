<?php
    require_once '_inc/functions.php';

    var_dump( dbConnection() );

    //gestion du formulaire
    processContactForm();

    //inclusions
    require_once '_inc/header.php';
    require_once '_inc/nav.php';
?>

    <h1>Contact</h1>

    <?php

    if(getErrors() !== null){
        $html = '<ul>';
        foreach(getErrors() as $error){
            $html .="<li>$error</li>";
        }
        $html .= '</ul>';

        echo $html;
    }
        
    ?>

    <form method="post">
        <p>
            <label>Email :</label>
            <input type="email" name="email" value="<?= getValues()['email'] ?? null ?>">
        </p>
        <p>
            <label>Subject :</label>
            <input type="text" name="subject" value="<?= getValues()['subject'] ?? null ?>">
        </p>
        <p>
            <label>Message :</label><br>
            <textarea name="message"><?= getValues()['message'] ?? null ?></textarea>
        </p>
        <p>
            <input type="submit" name="submit">
        </p>
    </form>

<?php
    //inclusions
    require_once '_inc/footer.php';
?>