<div role="tabpanel" class="tab-pane" id="browse">

    <div class="container-responsive noSideMargins">
        <?php require_once VIEWS_PATH . '/components/pagingWidget.php'; ?>
        <div class="row">
            <div class="col-sm-3 m-l-1p">
                <?php require_once VIEWS_PATH . '/components/filter.php'; ?>
            </div>
            <div class="col-sm-8">
                <div class="row browseResultsHeader">
                    <?php
                    if (!isset($passedToView['pets'])) {
                        $passedToView['pets'] = PetBasketController::browse(array('return-php-array' => true));
                    } else if (isset($passedToView['pets']) && is_array($passedToView['pets'])) {
                        // Pets created in controller function that required this view
                    } else {
                        $passedToView['pets'] = array();
                    }
                    $total = 0;
                    if (isset($passedToView['pets']) && is_array($passedToView['pets'])) {
                        foreach ($passedToView['pets'] as $pet) {
                            $visibility = $pet->getVisibility();
                            $approved = $pet->getApproved();
                            if (strtoupper($visibility) !== 'Y' || $approved != 1)
                                continue;
                            $total++;
                        }
                    }
                    $species = (isset($get['species']) && $get['species'] !== '') ? $get['species'] : 'Featured Pets';
                    ?>
                    <div class="col-md-3">
                        <h4><?php echo $species; ?></h4>
                    </div>
                    <div class="col-md-3">
                        <h4><em><?php echo $total . " results"; ?></em></h4>
                    </div>
                    <input type='hidden' id="totalPages" value="<?php echo $total ?>"/> 
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <?php
                if (isset($passedToView['pets']) && is_array($passedToView['pets'])) {
                    $page = 1;
                    foreach ($passedToView['pets'] as $pet) {
                        if (isset($pet->images) && $pet->images !== null) {
                            foreach ($pet->images as $image) {
                                $thumbnails = $image->getThumbnails();
                                $imgSrc = '/~' . USER . '/index.php/PetBasket/media?media=' . urlencode($thumbnails->med->fileName);
                                $petId = $pet->getId();
                                $petName = $pet->getName();
                                $desc = $pet->getDescription();
                                $specialNeeds = $pet->getSpecialNeeds();
                                $weight = $pet->getWeight();
                                $species = $pet->getSpecies();
                                $breed = ($pet->getBreed() === 'DEFAULT') ? '-' : $pet->getBreed();
                                $age = $pet->getAge();
                                $sex = $pet->getSex();
                                $visibility = $pet->getVisibility();
                                $approved = $pet->getApproved();
                                if (strtoupper($visibility) !== 'Y' || $approved != 1)
                                    continue;

                                $detailsLink = '/~' . USER . '/index.php/PetBasket/details';
                                $contactPosterLink = '/~' . USER . '/index.php/PetBasket/contactPoster?id=' . $petId;

                                $filterSpecies = isset($get['species']) ? $get['species'] : '';
                                $filterBreed = isset($get['breed']) ? $get['breed'] : '';
                                $filterSex = isset($get['sex']) ? $get['sex'] : '';
                                $filterWeight = isset($get['weight']) ? $get['weight'] : '';
                                $filterAge = isset($get['age']) ? $get['age'] : '';

                                $addToBasketData = isset($_SESSION['user']) ? '{"userId":"' . $_SESSION['user'] . '", "petId":"' . $petId . '"}' : '{"userId":undefined, "petId":"' . $petId . '"}';
                                $msgData = '';

                                $dataTarget = '';
                                if (isset($_SESSION['user']) && isset($user)) {
                                    $userId = $user->getId();
                                    $msgData = "$userId#$petId";
                                    $dataTarget = 'contactPosterModal';
                                } else {
                                    $dataTarget = 'loginModal';
                                }
                                $modalTarget = (isset($_SESSION["user"]) && $_SESSION["user"] > 0) ? "contactPosterModal" : "loginModal";
                                $basketModalTarget = (isset($_SESSION["user"]) && $_SESSION["user"] > 0) ? "" : "loginModal";
                                
                                $font1 = "4";
                                $font2 = "4";
                                
                                echo <<< img
		<div id="$petId" class="panel panel-default petPanel">
		    <div id="page_$page" class="panel-heading">
			<div class="row">
			    <div class="col-md-6">
				<div class="petName">
				    $petName
				</div>
			    </div>
			    <div class="col-md-3">
				<button id="contactPosterButton" type="button" class="btn btn-lrg btn-info fr" data-toggle="modal" data-target="#$modalTarget" data-user="$msgData">Contact the owner</button>
			    </div>
			    <div class="col-md-3">
				<button id="addToBasketButton_$petId" class="btn btn-lrg btn-primary fr addToBasketButton" type="button" data-toggle="modal" data-target="#$basketModalTarget" data-addToBasket='$addToBasketData'>Add to basket</button>
			    </div>
			</div>
		    </div>
		    <div class="panel-body panelBodyCustom">
			<div class="row">
			    <div class="col-sm-5">
				<div class="row">
				    <div class="col-md-12">
					<form id="petDetailsForm_$petId" action="$detailsLink" method="get">
					    <input type="hidden" name="id" value="$petId">
					    <input type="hidden" name="species" value="$filterSpecies">
					    <input type="hidden" name="breed" value="$filterBreed">
					    <input type="hidden" name="sex" value="$filterSex">
					    <input type="hidden" name="size" value="$filterWeight">
					    <input type="hidden" name="age" value="$filterAge">
					    <input type="hidden" name="pagejump" value="$petId">
					    <img src="$imgSrc" class="petImage"/>
					</form>
				    </div>
				</div>
			    </div>
			    <div class="col-sm-7">
				<div class="row petTileRow">
				    <div class="col-md-4 petTileRowLabel">
                                        <font size=$font1>Breed</font>
				    </div>
				    <div class="col-md-8">
                                        <font size=$font1>$breed</font>
				    </div>
				</div>
				<div class="row petTileRow">
				    <div class="col-md-4 petTileRowLabel">
                                        <font size=$font1> Age </font>
				    </div>
				    <div class="col-md-8">
                                        <font size=$font1>$age</font>               
				    </div>
				</div>
				<div class="row petTileRow">
				    <div class="col-md-4 petTileRowLabel">
                                        <font size=$font1> Sex </font>
				    </div>
				    <div class="col-md-8">
                                        <font size=$font1>$sex</font>
				    </div>
				</div>
				<div class="row petTileRow">
				    <div class="col-md-4 petTileRowLabel">
                                        <font size=$font1> Weight </font>
				    </div>
				    <div class="col-md-8">
                                        <font size=$font1> $weight lbs </font>
				    </div>
				</div>
			   </div>              
			</div>
			<div class="row petTileExpansion">
			    <div class="col-sm-1"></div>
			    <div class="col-sm-8">
				<div class="row">
				    <label for="descriptionLabel_$petId" class="control-label"><font size=$font2>Description</font></label>
				</div>
				<div class="row">
				    <span id="description_$petId"><font size=$font2>$desc</font></span>
				</div>
				<div class="row top-20">
				    <label for="specialNeedsLabel_$petId" class="control-label"><font size=$font2>Special Needs</font></label>
				</div>
				<div class="row">
				    <span id="specialNeeds_$petId"><font size=$font2>$specialNeeds</font></span>
				</div>
			    </div>
			    <div class="col-sm-2">
				<div class="row">
				    <div class="col-md-12">
					<button form="petDetailsForm_$petId" class="btn btn-sm btn-default fl" type="submit">See more details ...</button>
				    </div>
				</div>
			    </div>
			    <div class="col-sm-1"></div>
			</div>
			<div class="row petTileExpansionButton">                                     
			    <center><span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span></center>   
			</div>
		    </div>
		</div>                               
img;
                                $page++;
                            }
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

