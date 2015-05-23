<?php
$get = Core\Input::get();
$post = Core\Input::post();
?>
<!DOCTYPE html>
<html lang="en">
    <?php
    require_once __DIR__ . '/components/head.php';
    require_once __DIR__ . '/components/header.php';
    ?>
    <body>
        <div class="container">
	    <?php
	    $page = 'details';
	    $get = Core\Input::get();
	    $referrerPage = isset($get['referrer']) ? $get['referrer'] : 'home';
            $modalTarget = (isset($_SESSION["user"]) && $_SESSION["user"] > 0) ? "contactPosterModal" : "loginModal";
            $basketModalTarget = (isset($_SESSION["user"]) && $_SESSION["user"] > 0) ? "" : "loginModal";
        
	    if (isset($passedToView['pet'])) {
                $pet = $passedToView['pet'];
                if (isset($pet->images) && $pet->images !== null) {
                    foreach ($pet->images as $image) {
                        if ($image->getFileSize() > 150000) {
                            $thumbnails = $image->getThumbnails();
                            $imgSrc = '/~' . USER . '/index.php/PetBasket/media?media=' . urlencode($thumbnails->sm->fileName);
                            } else {
                                $imgSrc = '/~' . USER . '/index.php/PetBasket/media?media=' . urlencode($image->getFileName());
                                }
                                $name = $pet->getName();
                                $weight = $pet->getWeight();
                                $species = $pet->getSpecies();
                                $breed = ($pet->getBreed() === 'DEFAULT') ? '-' : $pet->getBreed();
                                $age = $pet->getAge();
                                $sex = $pet->getSex();
                                $desc = $pet->getDescription();
                                $specialNeeds = $pet->getSpecialNeeds();
                                
                                $breed = (isset($breed) && $breed != '') ? $breed : 'Unspecified breed';
                                $desc = (isset($desc) && $desc != '') ? $desc : 'No details were provided';
                                $specialNeeds = (isset($specialNeeds) && $specialNeeds != '') ? $specialNeeds : 'No special accommodations were provided';
                                $modalTarget = (isset($_SESSION["user"]) && $_SESSION["user"] > 0) ? "contactPosterModal" : "loginModal";
                                $basketModalTarget = (isset($_SESSION["user"]) && $_SESSION["user"] > 0) ? "" : "loginModal";
                                $addToBasketData = isset($_SESSION['user']) ? '{"userId":"' . $_SESSION['user'] . '", "petId":"' . $petId . '"}' : '{"userId":undefined, "petId":"' . $petId . '"}';
                    
                                echo <<< details
            <div class="row">
                <div class="col-md-6 col-md-offset-1">
                    <div class="row">
                        <h2 >$name</h2>
                    </div>
                    <div class="row">
                        <ul class="dog-details list-inline"">
                            <li>Species: $species</li>
                            <li>Breed: $breed</li>
                            <li>Weight: $weight</li>
                            <li>Age: $age</li>
                            <li>Sex: $sex</li>
                        </ul>
                    </div>
                    <div class="row imageContainer">
                        <img class="detailsImage center-block" src="$imgSrc"/>
                    </div>
                </div>
details;
                            }
                        }
                    } else {
                        if(isset($error['msg'])) {
                            echo $error['msg'];
                            exit;
                        }
                    }
	    ?>
                <div class="col-md-5">
                    <div class="row">
                        <form action="/~<?php echo USER; ?>/index.php/PetBasket/browse" method="get">
                            <?php
                            //echo "DETAILS>>>>>>";
                            //var_dump($get);
                            $filterSpecies = (isset($get['species'])) ? $get['species'] : '';
                            $filterBreed = (isset($get['breed'])) ? $get['breed'] : '';
                            $filterSex = (isset($get['sex'])) ? $get['sex'] : '';
                            $filterSize = (isset($get['size'])) ? $get['size'] : '';
                            $filterAge = (isset($get['age'])) ? $get['age'] : '';
                            $pagejump = (isset($get['pagejump'])) ? $get['pagejump'] : '';
                            if($pagejump === '' && isset($get['id']))
                                $pagejump = $get['id'];
                                
                            ?>
                            <input type="hidden" name="species" value="<?php echo $filterSpecies; ?>">
                            <input type="hidden" name="breed" value="<?php echo $filterBreed; ?>">
                            <input type="hidden" name="sex" value="<?php echo $filterSex; ?>">
                            <input type="hidden" name="size" value="<?php echo $filterSize; ?>">
                            <input type="hidden" name="age" value="<?php echo $filterAge; ?>">
                            <input type="hidden" name="pagejump" value="<?php echo $pagejump; ?>">
                            <input type="hidden" name="context" value="browse">
                            <input class="btn btn-lrg btn-primary" style="float:right; margin: 50px" type="submit" value="Back To Search">
                        </form>
                    </div>
		    <?php
                    if (isset($passedToView['pet'])) {
                        echo <<< details2
                    <div class="row detail-box">
                        <h4>Description: </h4>
                        <p>$desc</p>
                        <h4>Special Needs: </h4>
                        <p>$specialNeeds</p>
                        <p>
                            <ul class="tags">
                                <li><a href="#">$species</a></li>
                                <li><a href="#">$breed</a></li>
                                <li><a href="#">$weight lbs</a></li>
                                <li><a href="#">$age Yrs</a></li>
                                <li><a href="#">$sex</a></li>
                            </ul>
                        </p>
                    </div>
details2;
                    }
            ?>
                    </br></br>
                    <div class="row">
                        <div class="col-sm-6">
                            <?php 
                            $msgData = '';
                            if(isset($_SESSION['user']) && isset($passedToView['pet'])){
                                $msgData = $_SESSION["user"] . '#' . $pet->getId();
                            }
                            ?>
                            <button type="button" class="btn btn-lrg btn-primary" data-toggle="modal" data-target="#<?php echo $modalTarget; ?>" data-user="<?php echo $msgData; ?>">Contact the Owner</button>
                        </div><?php echo <<<img
                        <div class="col-md-4">
				<button id="addToBasketButton_$petId" class="btn btn-lrg btn-primary fr addToBasketButton" type="button" data-toggle="modal" data-target="#$basketModalTarget" data-addToBasket='$addToBasketData'>Add to basket</button>
			</div>
img;
                        ?>
                        <!--<div class="col-sm-6">
                            <?php
                            if (isset($passedToView['pet'])) {
                                $pet = $passedToView['pet'];
                                $addToBasketData = isset($_SESSION['user']) 
                                    ? '{"userId":"' . $_SESSION['user'] . '", "petId":"' . $pet->getId() . '"}' 
                                    : '{"userId":undefined, "petId":"' . $pet->getId() . '"}';
                            } else {
                                $addToBasketData = '';
                            }
                            ?>
                            <button type="button" class="btn btn-lrg btn-primary addToBasketButton" data-toggle="modal" data-target="#<?php echo $basketModalTarget; ?>" data-addToBasket='<?php echo $addToBasketData; ?>'>Add to basket</button>
                        </div>-->
                    </div>
                </div>
            </div>
       <!-- </div>-->
	<?php require_once(VIEWS_PATH . "/components/footer.php"); ?>
    </body>
</html>