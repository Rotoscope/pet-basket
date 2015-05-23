<?php
$get = Core\Input::get();
$post = Core\Input::post();
if(!isset($_SESSION["user"]))
    header("Location: http://sfsuswe.com/~" . USER . "/index.php/PetBasket/home");
$user = User::constructById($_SESSION["user"]);
?>
<!DOCTYPE html>
<html lang="en">
    <?php
    $page = "myPets";
    require_once __DIR__ . '/components/head.php';
    require_once __DIR__ . '/components/header.php';
    ?>
    <body>
    <div class="container">
        <div class="row contactTitleBox">
            <div class="col-md-4">
                <h4><strong>Manage Your Account</strong></h4>
            </div>
            <div class="col-md-8">
                <ul class="nav nav-tabs navbar-right">
                    <li role="presentation"><a href="/~<?php echo USER; ?>/index.php/PetBasket/contactUpdate">Update Info</a></li>
                    <li role="presentation" class="active"><a href="#">My Pets</a></li>
                    <li role="presentation"><a href="/~<?php echo USER; ?>/index.php/PetBasket/notification">Notification</a></li>
                    <?php if (isset($user) && $user->getIsAdmin()) { ?>
                        <li role="presentation"><a href="/~<?php echo USER; ?>/index.php/PetBasket/admin">Admin</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="mainContent">
            <div class="row">
                <h4 class="text-center">Find your previous posts here</h4>
                <p class="text-center">You can either edit your previous posts or add a new post in this page.</p>
                <br>
                <br>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-4">
                        <label class="aboutUsLabel" >Your Posts:</label>
                    </div>
                    <div class="col-md-7">
                        <!--NEW BUTTON -------------->
                        <form action="/~<?php echo USER; ?>/index.php/PetBasket/home" method="get">
                            <input type="hidden" name="context" value="post">
                            <button id="addNewPet" type="submit" class="btn btn-md btn-primary" style="float:right">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                New
                            </button>
                        </form> 
                    </div>
                </div>
            </div>

            <?php
            if (isset($passedToView['pets']) && is_array($passedToView['pets'])) {
                if (empty($passedToView['pets'])) {
                    echo <<< msg
            <div style="margin: auto;">You have no pets up for adoption</div>
msg;
                } else {
                    foreach ($passedToView['pets'] as $pet) {
                        if ($pet->getApproved() != 3 || $pet->getVisibility() != 'n') {
                            if (isset($pet->images) && $pet->images !== null) {
                                foreach ($pet->images as $image) {
                                    $thumbnails = $image->getThumbnails();
                                    $imgSrc = '/~' . USER . '/index.php/PetBasket/media?media=' . urlencode($thumbnails->med->fileName);
                                    $petName = $pet->getName();
                                    $petId = $pet->getId();
                                    $petAge = $pet->getAge();
                                    $desc = $pet->getDescription();
                                    $datePosted = $pet->getCreated();
                                    $datePosted = date("m/d/Y", $datePosted);
                                    $modifyLink = '/~' . USER . '/index.php/PetBasket/modifyPet';
                                    $removeLink = '/~' . USER . '/index.php/PetBasket/removeFromMyPets';
                                    $detailsLink = '/~' . USER . '/index.php/PetBasket/details';
                                    $status = "Pending";
                                    //var_dump((int)$pet->getApproved());
                                    //exit;
                                    if ($pet->getApproved() == "1") {
                                        $status = "Approved";
                                    }
                                    echo <<< img
            <div class="row contactTitleBox">
                <div class="row">
                    <div class="col-md-3">
                        <form id="petDetailsForm_$petId" action="$modifyLink" method="get">
                            <input type="hidden" name="id" value="$petId">
                            <input class="petImage" type="image" src="$imgSrc" alt="Submit">
                        </form>
                    </div>
                    <div class="col-md-8 col-md-offset-1" style:"float:right;">
                        </br>

                        <!--DATE NAME and AGE---------------->
                        <div class="row">
                            <label class="col-md-4" >Date Posted: </label>
                            <label class="col-md-4" style="float:left;">$datePosted</label>
                        </div>
                        <div class="row">
                            <label class="col-md-4" >Status: </label>
                            <label class="col-md-4" style="float:left;">$status</label>
                        </div>
                        <div class="row">
                            <label class="col-md-4" >Name: </label>
                            <label class="col-md-4" style="float:left;">$petName</label>
                        </div>                     
                        <div class="row">
                            <label class="col-md-4" >Age: </label>
                            <label class="col-md-4" style="float:left;">$petAge</label>
                        </div>
                    </div>
                    <!--REMOVE and EDIT BUTTONS---------------->
                    <div class="row"> 
                        <div class="col-md-3" style="float:right;">
                            </br>
                            </br>
                            <form id="postForm" action="$removeLink" method="POST" enctype="multipart/form-data">
                                <input type='hidden' name="id" value="$petId"/>
                                 <button type="submit" class="btn btn-default btn-md">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                    Remove
                                </button>
                            </form> 
                        </div>
                        <div class="col-md-3" style="float:right;">
                            </br>
                            </br>
                            <form method="get" action="$modifyLink">
                                <input type="hidden" name="id" value="$petId">
                                <button type="submit" class="btn btn-default btn-md">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                    Edit
                                </button>
                            </form>
                        </div>
                    </div><!-- /.row -->
                </div>
                
            </div>
img;
                            }
                        }
                    }
                }
            }
        }
        ?>
        </div><!-- /.mainContent -->
    <?php require_once(VIEWS_PATH . "/components/footer.php"); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <?php require_once(VIEWS_PATH . "/components/commonsJsForOther.php"); ?>
</div><!-- /.container -->
</body>
</html>

