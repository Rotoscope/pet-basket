<?php
$get = Core\Input::get();
$post = Core\Input::post()
?>
<!DOCTYPE html>
<html lang="en">
    <?php 
    require_once __DIR__ . '/components/head.php'; 
    require_once __DIR__ . '/components/header.php';
    ?>
    <body>
        <div class="mainContent">
            <h1><strong>Terms</strong></h1>
            <br>
            <blockquote>
                <p>You must be at least 18 years old to register.</p>
                <br>
                <p>PetBasket will store provided information in a secure manner.</p>
                <br>
                <p>PetBasket will not sell or use user information without their consent.</p>
                <br>
                <p>Using PetBasket does not give you ownership of any intellectual property rights of the content you access.</p>
            </blockquote>
        </div>
        <?php require_once __DIR__ . '/components/footer.php'; ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <?php require_once(VIEWS_PATH . "/components/commonsJsForOther.php"); ?>
    </body>
</html>
