
<?php
$home = '/~' . USER . '/index.php/PetBasket/home?context=home';
$browse = '/~' . USER . '/index.php/PetBasket/home?context=browse';
$post = '/~' . USER . '/index.php/PetBasket/home?context=post';
$about = '/~' . USER . '/index.php/PetBasket/home?context=about';
?>
<div id="mynavbar" class="navbar-collapse collapse">
    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li role="presentation" class="active"><a href="<?php echo $home; ?>">Home</a></li>
        <li role="presentation"><a href="<?php echo $browse; ?>">Find A Pet</a></li>
        <li role="presentation"><a href="<?php echo $post; ?>">Find A Home For Your Pet</a></li>
        <li role="presentation"><a href="<?php echo $about; ?>">About Us</a></li>
        <li role="presentation" class="active"><a href="#other">Other</a></li>
    </ul>
</div>
