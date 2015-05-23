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
    <?php
    $page = 'details';
    $referrerPage = isset($get['referrer']) ? $get['referrer'] : 'home';
    ?>
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
        <div class="row">
            <h4 class="text-center">Edit your post here</h4>
            <p class="text-center">You can edit your previous post in this page.</p>
            <br>
            <br>
        </div>
                <?php
                /* echo "GET:";
                  var_dump($get);
                  echo "POST:"; */
                //var_dump($post);
                if (isset($passedToView['pet'])) {
                    $pet = $passedToView['pet'];
                    if (isset($pet->images) && $pet->images !== null) {

                        foreach ($pet->images as $image) {
                            $thumbnails = $image->getThumbnails();
                            $imgSrc = '/~' . USER . '/index.php/PetBasket/media?media=' . urlencode($thumbnails->med->fileName);
                            $name = $pet->getName();
                            $specialNeeds = $pet->getSpecialNeeds();
                            $weight = $pet->getWeight();
                            $species = $pet->getSpecies();
                            $breed = $pet->getBreed();
                            $age = $pet->getAge();
                            $sex = $pet->getSex();
                            $desc = $pet->getDescription();
                            $id = $pet->getId();

                            $desc = (isset($desc) && $desc != '') ? $desc : 'No details were provided';
                            $specialNeeds = (isset($specialNeeds) && $specialNeeds != '') ? $specialNeeds : 'No special accommodations were provided';
                            $actionLink = "/~" . USER . "/index.php/PetBasket/updatePet";
                            echo <<< details
        <form id="postForm" method="post" action="$actionLink">
            <input type="hidden" name="id" value=$id>              
            <div class="row">
                <div class="col-md-6">
                    <img src="$imgSrc" class="detailsImage" width="150%" height="150%"/>
                </div>
                <div class="col-md-4">
                    <div class="row petName">$name</div>
                    </br>
                    <!--SPECIES--------------->
                    <div class="row detailsText">
                        <div class="col-md-2"><b>Species</b>:</div> 
                        <div class="col-md-3">
                            <select id="species" class="form-control" name="species">
                                <option></option>
                                <option value="Dog">Dog</option>
                                <option value="Cat">Cat</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    </br>
                    <!--BREED--------------->
                    <div class="row detailsText">
                        <div class="col-md-2"><b>Breed</b>:</div> 
                        <div class="col-md-3">
                            <select id="breed" class="form-control" name="breed">
                                <option value="default" disabled></option>
                            </select>
                        </div>
                    </div>
                    </br>
                                <!--SEX--------------->          
                    <div class="row detailsText">
                        <div class="col-md-2"><b>Sex</b>:</div> 
                        <div class="col-md-3">
                            <select id="sexSelector" class="form-control" name="sex">
                                <option></option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>
                    </br>

                    <!--WEIGHT--------------->
                    <div class="row detailsText">
                        <div class="col-md-2"><b>Weight</b>:</div> <div class="col-md-2"><input size="12" name="weight" value = $weight>
                        </div>
                    </div>
                    </br>
                    <!--AGE--------------->
                    <div class="row detailsText">
                        <div class="col-md-2"><b>Age</b>:</div> <div class="col-md-2"><input size="12" name="age" value=$age>
                        </div>
                    </div>
                    </br>
                </div>
                </br></br>

			    <!--PET DESCRIPTION---------------------------->
			    <div class="row">                       
                    <div class="col-md-7">
                        <div class="form-group">
                            <label class="fl detailsText" for="petDescription">Description</label>
                            <textarea class="form-control detailsText" rows="8" id="petDescription" name="description">$desc</textarea>
                        </div>
                    </div>
			    </div>
			    </br></br></br>
			    <!--PET SPECIAL NEEDS---------------------------->
			    <div class="row bottom-20">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label class="fl detailsText" for="petSpecialNeeds">Special Needs</label>
                            <textarea class="form-control detailsText" rows="8" id="petSpecialNeeds" name="specialNeeds">$specialNeeds</textarea>
                        </div>
                    </div>
			    </div> 
			</form>
        </div>
        </br></br></br></br>
details;
                        }
                    }
                }
                ?>
        <div class="row">
            <div class="col-md-3">
                <form action="/~<?php echo USER; ?>/index.php/PetBasket/myPets" method="get">
                    <input class="btn btn-lrg btn-primary" style="float: left; margin: 10px" type="submit" value="Back To Your Posts">
                </form>
            </div>

            <div class="detailsButtonRow">
                <input form ="postForm" class="btn btn-lrg btn-primary detailsButton" type="submit" value="Save Changes">
            </div>
        </div>
    </div>
    <?php
    require_once(VIEWS_PATH . "/components/footer.php");
    ?>
    <script type="text/javascript">

        // attach an onchange event handler to the species dropdown in modifyPet
        $("#species").change(function () {
            //console.log("$(this).val()");
            populateBreedSelector("breed", $(this).val(), null);
        });

    </script>
</div>
</body>
</html>