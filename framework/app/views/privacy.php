<?php
$get = Core\Input::get();
$post = Core\Input::post()
?>
<!DOCTYPE html>
<html lang="en">
    <?php 
    require_once __DIR__ . '/components/head.php'; 
    require_once __DIR__ . '/components/header.php'
    ?>
    <body>
       
        <div class="mainContent">
            <h1><strong>Privacy</strong></h1>
            <br>
            <p>Last Updated: May 14th, 2015.<br>
            Your privacy is safe at PetBasket!  We do not share your information with anyone nor do we gather any information besides what we ask for. <br>
            </p>
            <h2>What kind of information do we use?</h2>
            <blockquote>
                <p>Cookies: We do not employ the use of cookies to store any information on your system.<br>
                Browsing Information: Any information used to search and browse is only stored temporarily on our servers for your current session.<br>
                </p>
            </blockquote>
            
            <h2>Password</h2>
            <blockquote>
                <p>Your password will always be free for you to change if you wish. Just navigate to the Contact Update page located in the user drop down menu.
                </p>
            </blockquote>
            <h2>Have Fun!</h2>
            <blockquote>
                <p>Our goal is to provide you with a safe, secure and fun experience on our website. We take it as our utmost priority to keep you and your information safe and secure so that you do not have to worry. 
                </p>
            </blockquote>
        </div>
        <?php require_once __DIR__ . '/components/footer.php'; ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <?php require_once(VIEWS_PATH . "/components/commonsJsForOther.php"); ?>
    </body>
</html>