<?php
if(isset($get['logout']))
    unset($_SESSION["user"]);
if (isset($_SESSION["user"])) {
    $user = User::constructById($_SESSION["user"]);
}
?>
<nav class="navbar navbar-inverse navbar-fixed-top navbarOverride header">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand customNavBarBrand" href="/~<?php echo USER; ?>/index.php/PetBasket/home">SFSU Class Project - <?php echo SITE_TITLE ?></a>
        </div>
        <div class="loginGroup">
            <!--<div class="petBasketButtonContainer">-->
            <div class='petBasketBtn'>
                <button type="button" class="btn" data-toggle="modal" data-target="#petbasketModal">
                    <img class="petBasketImage" src="https://cdn4.iconfinder.com/data/icons/ios7-active-2/512/Basket.png" />
                </button>
            </div>
            <div class="hiddenMenu">                    
                <?php if (isset($_SESSION['user']) && $_SESSION['user'] != 0) { ?>   
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                            <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : '@' ?>
                            <span class="caret"></span>
                        </button>
                        <!--                        <div class="dropdown">
                                                    <a href="#" data-toggle="dropdown" class="dropdown-toggle font-size-160-p"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : '@' ?><b class="caret"></b></a>-->
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                            <li><a href="/~<?php echo USER; ?>/index.php/PetBasket/contactUpdate">Update Info</a></li>
                            <li><a href="/~<?php echo USER; ?>/index.php/PetBasket/myPets">My Pets</a></li>
                            <li><a href="/~<?php echo USER; ?>/index.php/PetBasket/notification">Notification</a></li>
                            <?php if (isset($user) && $user->getIsAdmin()) { ?>
                                <li><a href="/~<?php echo USER; ?>/index.php/PetBasket/admin">Admin</a></li>
                            <?php } ?>
                            <li class="divider"></li>
                            
                            <li><a href="
                                <?php 
                                echo '?logout=true&referrer=';
                                if($page == 'notification')
                                    $page = 'home';
                                echo isset($page) ? $page : 'home'; 
                                ?>
                            ">Log Out</a></li>
                        </ul>
                    </div>
                <?php } else { ?>
                    <button type="button" class="btn<?php echo isset($_SESSION["user"]) ? 'displayNone' : ''; ?>" data-toggle="modal" data-target="#loginModal">Login</button>
                <?php } ?>
            </div>
            </form>
        </div>
    </div>
</nav>
<?php
require_once VIEWS_PATH . '/components/petBasketModal.php';
require_once VIEWS_PATH . '/components/loginModal.php';
require_once VIEWS_PATH . '/components/contactPosterModal.php';
?>
