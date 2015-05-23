
    <div class="row bottom-20">
        <br>
        <h3>Find a Home For Your Pet</h3>
        <label style="font-weight: bold">Note: * Fields Required </label>
        <br>
    </div>
    <div class="row bottom-20">   
        <div class="form-group">
            <div class="col-md-1">
                <!--  NAME---------------->
                <label class="fl" for="post">Name: *</label>
            </div>
            <div class="col-md-2">
                <input type="text" id="petName" class="form-control" name="petName" form="postForm">
            </div>
            <!-- AGE---------------->
            <div class="col-md-1">
                <label class="fl" for="post">Age:</label>
            </div>
            <div class="col-md-2" >
                <input type="text" id="age" class="form-control" name="age" form="postForm">
            </div>
            <!-- WEIGHT---------------->
            <div class="col-md-1">
                <label class="fl" for="post">Weight:</label>
            </div>
            <div class="col-md-2">
                <input type="text" id="weight" class="form-control" name="weight" form="postForm">
            </div>
        </div>
    </div>
    <!-- INPUT SPECIES AND BREED---------------->
    <div class="row bottom-20">   
        <div class="form-group">
            <!-- SPECIES---------------->

            <div class="col-md-1">
                <label for="post">Species: </label>
                <label style="float:right;" for="post">*</label>
            </div>
            <div class="col-md-2">
                <select id="speciesForPost" class="form-control" name="species" form="postForm">
                    <option value="Other">Other</option>
                    <option value="Dog">Dog</option>
                    <option value="Cat">Cat</option>
                </select>
            </div>

            <!-- BREED---------------->
            <div class="col-md-1">
                <label class="fl" for="post">Breed: *</label>
            </div>
            <div class="col-md-2">
                <select id="breedsForPost" class="form-control" name="breed" form="postForm">
                    <option value="default" disabled></option>
                </select>
            </div>
            <!-- SEX---------------->
            <div class="col-md-1">
                <label class="fl" for="post">Sex:</label>
            </div>
            <div class="col-md-2">
                <select id="sexSelector" class="form-control" name="sex" form="postForm">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
        </div>
    </div>
    </br></br></br>
    <!--PET DESCRIPTION---------------------------->
    <div class="row">                       
        <div class="col-md-7">
            <div class="form-group">
                <label class="fl" for="petDescription">Description</label>
                <textarea class="form-control" rows="8" id="petDescription" name="petDescription" form="postForm"></textarea>
            </div>
        </div>
    </div>
    </br></br></br>
    <!--PET SPECIAL NEEDS---------------------------->
    <div class="row bottom-20">
        <div class="col-md-7">
            <div class="form-group">
                <label class="fl" for="petSpecialNeeds">Special Needs</label>
                <textarea class="form-control" rows="8" id="petSpecialNeeds" name="petSpecialNeeds" form="postForm"></textarea>
            </div>
        </div>
    </div>               
    <!--UPLOAD BUTTON ECT-------------->
    </br></br></br>
    <div class="container row" style="padding-bottom: 50px">
        <div class="col-md-6">
            <div class="form-group">
                <form id="postForm" name="postForm" action="/~<?php echo USER; ?>/index.php/PetBasket/upload" method="post" enctype="multipart/form-data">
                    <span class="submitLabel" style = "font-size:120%">Select Image to upload:</span>
                    <input class="btn  mtop-20 btn-lg" type="file" name="fileToUpload" id="fileToUpload">
                </form>
            </div>
        </div>
        <div class="col-md-4 float-right" style="padding-left: 40px">
            <input id="petPostButton" class="btn btn-primary" style="width: 120px; height: 60px; font-size: 200%;" type="submit" name="submit" value="Post" form="postForm">
        </div>
    </div>

