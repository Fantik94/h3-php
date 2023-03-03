<?php

    require_once '_inc/functions.php';

    require_once '_inc/header.php';
    require_once '_inc/nav.php';

?>

<h1>Register</h1>

<form>
    <p>
        <label>Email :</label>
        <input type="email" name="email">
    </p>
    <p>
        <label>Password :</label>
        <input type="password" name="password">
    </p>
    <p>
        <input type="submit">
    </p>
</form>

<script src="/js/register.js"></script>

<?php

require_once '_inc/footer.php';

?>