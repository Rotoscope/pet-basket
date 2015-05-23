<div class="container">
    <div class="row">
        <div class = "col-md-2"><h4>New Pets</h4></div>
        <div class="col-md-3">
            <h4>
                <em>
                    <?php
                    $totalNew = count($passedToView['newPets']);
                    echo $totalNew . " results";
                    ?>
                </em>
            </h4>
        </div>
    </div>
    <?php
    $user = USER;
    if (isset($passedToView['newPets']) && is_array($passedToView['newPets'])) {
        $page = 1;
        foreach ($passedToView['newPets'] as $pet) {
            if (isset($pet->images) && $pet->images !== null) {
                foreach ($pet->images as $image) {
                    $thumbnails = $image->getThumbnails();
                    $imgSrc = '/~' . USER . '/index.php/PetBasket/media?media=' . urlencode($thumbnails->sm->fileName);
                    $petId = $pet->getId();
                    $petName = $pet->getName();
                    $desc = $pet->getDescription();
                    $specialNeeds = $pet->getSpecialNeeds();
                    $weight = $pet->getWeight();
                    $species = $pet->getSpecies();
                    $breed = $pet->getBreed();
                    $age = $pet->getAge();
                    $sex = $pet->getSex();
                    $detailsLink = '/~' . USER . '/index.php/PetBasket/details';
                    $contactPosterLink = '/~' . USER . '/index.php/PetBasket/contactPoster?id=' . $petId;
                    $userId = (int) $pet->getUserId();
                    $petUser = User::constructById($userId);
                    $lastLogin = $petUser->getLastLogin();

                    //$id = $pet->getId();

                    $userName = $petUser->getUserName();
                    $email = $petUser->getEmail();

                    $visibility = $pet->getVisibility();
                    $approved = $pet->getApproved();

                    //convert approved status into a string
                    $approvedStatus;
                    if ($approved == '1') {
                        $approvedStatus = 'Approved';
                    } else if ($approved == '2') {
                        $approvedStatus = 'Declined';
                    } else {
                        $approvedStatus = 'Pending';
                    }

                    echo <<< img
                    
    <div id="$petId" class="panel panel-default petPanel">
	<div id="page_N_$page" class="panel-heading">
	    <div class="row">
		<div class="col-md-6">
		    <div class="petName">
			$petName
		    </div>
		</div>
		<div class="col-md-2">
		    Visibility: <span class="{$petId}_visibility">$visibility</span><br> 
		    Status: <span class="{$petId}_approved">$approvedStatus</span>
		</div> 
		<div class="col-md-2">
		    <button name="adminApprove" id="adminApprove" type="submit" class="btn btn-lrg btn-info fr adminApprove" data-user="0#$petId" data-toggle="modal" data-target="#contactPosterModal">Approve</button>
		</div>
		<div class="col-md-2">      
		    <button name="adminDecline" id="adminDecline" type="submit" class="btn btn-lrg btn-primary fr adminDecline" data-user="0#$petId" data-toggle="modal" data-target="#contactPosterModal">Decline</button>
		</div>
	    </div>
	</div>
	<div class="panel-body panelBodyCustom">
	    <div class="row">
		<div class="col-sm-5">
		    <div class="row">
			<div class="col-md-12">
			    <form action="$detailsLink" method="get">
				<input type="hidden" name="id" value="$petId">
				<input type="hidden" name="pagejump" value="$petId">
				<img src="$imgSrc" class="petImage"/>
			    </form>
			</div>
		    </div>
		</div>
		<div class="col-sm-7">
		    <div class="row petTileRow">
			<div class="col-md-4 petTileRowLabel">
			    Breed
			</div>
			<div class="col-md-8">
			    $breed
			</div>
		    </div>
		    <div class="row petTileRow">
			<div class="col-md-4 petTileRowLabel">
			    Age 
			</div>
			<div class="col-md-8">
			    $age                                             
			</div>
		    </div>
		    <div class="row petTileRow">
			<div class="col-md-4 petTileRowLabel">
			    Sex
			</div>
			<div class="col-md-8">
			    $sex
			</div>
		    </div>
		    <div class="row petTileRow">
			<div class="col-md-4 petTileRowLabel">
			    Weight
			</div>
			<div class="col-md-8">
			    $weight lbs
			</div>
		    </div>
		</div>              
	    </div>
	    <div class="row petTileExpansion">
		<div class="col-sm-5">
		    <div class="row">
			<div class="col-sm-12">
			    Description
			</div>
		    </div>
		    <div class="row">
			<div class="col-sm-12">
			    $desc
			</div>
		    </div>
		</div>
		<div class="col-sm-4">
		    <div class="row">
			<div class="col-sm-12">
			    Special Needs
			</div>
		    </div>
		    <div class="row">
			<div class="col-sm-12">
			    $specialNeeds
			</div>
		    </div>
		</div>
		<div class="col-sm-3">
		    <div class="row">
			<div class="col-md-12">
			    <a href="$detailsLink" class="btn btn-sm btn-default fl" role="button">See more details ...</a>
			</div>
		    </div>
		</div>
	    </div>
	    <div class="row petTileExpansionButton">                                     
		<center><span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span></center>   
	    </div>
	</div>
    </div> 
img;
                }
            }
            $page++;
        }
    }
    ?>
</div>
