<!-- Start form -->
<form action="<?php echo '/~' . USER . '/index.php/PetBasket/browse'; ?>">
    <input type="hidden" name="context" value="browse">

    <!-- Start fileter Header -->
    <div class="row filterRow">
        <span id="filterLabel">Filter</span>
    </div><!-- /.filterRow -->

    <!-- Start fileter Content -->
    <!-- End of fileter Header -->
    <div class="row filterRow">
        <div class="col-md-4">
            Species
        </div>
        <div class="col-md-8">
            <select id="speciesSelector" class="form-control" name="species">
                <option></option>
                <option value="Dog" <?php echo (isset($get['species']) && $get['species'] === 'Dog') ? 'selected' : ''; ?>>Dog</option>
                <option value="Cat" <?php echo (isset($get['species']) && $get['species'] === 'Cat') ? 'selected' : ''; ?>>Cat</option>
                <option value="Other" <?php echo (isset($get['species']) && $get['species'] === 'Other') ? 'selected' : ''; ?>>Other</option>
            </select>
        </div>                            
    </div><!-- /.filterRow -->
    <div class="row filterRow">
        <div class="col-md-4">
            Breed
        </div>
        <div class="col-md-8">
            <select id="breedSelector" class="form-control" name="breed">
                <option></option>
            </select>
        </div>                            
    </div>
    <div class="row filterRow">
        <div class="col-md-4">
            Gender
        </div>
        <div class="col-md-8">
            <div class="row">
                <input class="sexCheckBox" type="checkbox" name="sex" value="male" <?php echo (isset($get['sex']) && $get['sex'] === 'male' ) ? 'checked' : ''; ?>/> male
            </div>
            <div class="row">
                <input class="sexCheckBox" type="checkbox" name="sex" value="female" <?php echo (isset($get['sex']) && $get['sex'] === 'female' ) ? 'checked' : ''; ?>/> female
            </div>
        </div>
    </div><!-- /.filterRow -->
    <div class="row filterRow">
        <div class="col-md-4">
            Size
        </div>
        <div class="col-md-8">
            <div class="row">
                <input class="sizeCheckBox" type="checkbox" name="size" value="xs" <?php echo (isset($get['size']) && $get['size'] === 'xs' ) ? 'true' : ''; ?>/> x-small 
            </div>
            <div class="row">
                <input class="sizeCheckBox" type="checkbox" name="size" value="sm" <?php echo (isset($get['size']) && $get['size'] === 'sm' ) ? 'true' : ''; ?>/> small
            </div>
            <div class="row">
                <input class="sizeCheckBox" type="checkbox" name="size" value="med" <?php echo (isset($get['size']) && $get['size'] === 'med' ) ? 'true' : ''; ?>/> medium
            </div>
            <div class="row">
                <input class="sizeCheckBox" type="checkbox" name="size" value="lrg" <?php echo (isset($get['size']) && $get['size'] === 'lrg' ) ? 'true' : ''; ?>/> large
            </div>
        </div>
    </div><!-- /.filterRow -->
    <div class="row filterRow">
        <div class="col-md-4">
            Age
        </div>
        <div class="col-md-8">
            <select id="ageSelector" class="form-control" name="age" <?php echo (isset($get['age'])) ? 'selected' : ''; ?>>
                <option></option>
            </select>
        </div>                            
    </div><!-- /.filterRow -->
    <div class="row filterRow">
        <div class="col-md-5">
            <button id="resetFilter" class="btn btn-sm filterButton" type="button">Reset</button>
        </div>
        <div class="col-md-2">
        </div>                            
        <div class="col-md-5">
            <button class="btn btn-sm" type="submit">Submit</button>
        </div>                            
    </div><!-- /.filterRow -->
    <!-- End of fileter Content -->

</form><!-- End of form -->

