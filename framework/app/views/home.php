<?php
$get = Core\Input::get();
$post = Core\Input::post()
?>
<!DOCTYPE html>
<html lang="en">
    <?php
    $page = "home";
    require_once __DIR__ . '/components/head.php';
    require_once __DIR__ . '/components/header.php';
    ?>
    <body id="page_0">

        <!-- Start section-navigation -->
        <!-- nav tabs -->
        <div class="container">
            <div id="mynavbar" class="navbar-collapse collapse">
                <ul class="nav nav-tabs" role="tablist" id="myTab">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
                    <li role="presentation"><a href="#browse" aria-controls="browse" role="tab" data-toggle="tab">Find A Pet</a></li>
                    <li role="presentation"><a href="#post" aria-controls="post" role="tab" data-toggle="tab">Find A Home For Your Pet</a></li>
                    <li role="presentation"><a href="#about" aria-controls="about" role="tab" data-toggle="tab">About Us</a></li>
                </ul>
            </div>
            <!-- nav tab content -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="home">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3 item">
                                <a href="<?php echo '/~' . USER . '/index.php/PetBasket/browse?species=Dog&context=browse' ?>">
                                    <img class="homeImage" src="<?php echo 'http://sfsuswe.com/~' . USER . '/index.php/PetBasket/media?media=' . urlencode('homeDog.jpg') ?>" alt="Dogs">
                                    <div class="caption captionBox">
                                        <div class="desc">
                                            <h4>Dogs</h4>
                                            <p>Find a dog here</p> 
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-3 item">
                                <a href="<?php echo '/~' . USER . '/index.php/PetBasket/browse?species=Cat&context=browse' ?>">
                                    <img class="homeImage" src="<?php echo 'http://sfsuswe.com/~' . USER . '/index.php/PetBasket/media?media=' . urlencode('homeCat.jpg') ?>" alt="Cats">
                                    <div class="caption captionBox">
                                        <div class="desc">
                                            <h4>Cats</h4>
                                            <p>Find a cat here</p> 
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-3 item">
                                <a href="<?php echo '/~' . USER . '/index.php/PetBasket/browse?species=Other&context=browse' ?>">
                                    <img class="homeImage" src="<?php echo 'http://sfsuswe.com/~' . USER . '/index.php/PetBasket/media?media=' . urlencode('homeOther.jpg') ?>" alt="Others">
                                    <div class="caption captionBox">
                                        <div class="desc">
                                            <h4>Others</h4>
                                            <p>Find others here</p> 
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div><!-- /.row -->
                    </div><!-- /.container -->
                </div><!-- /.tabpanel -->

                <!-- BROWSE PAGE -->
                <?php require_once VIEWS_PATH . '/components/browse.php'; ?>

                <!-- FIND A HOME FOR YOUR PET SECTION-->
                <div role="tabpanel" class="tab-pane" id="post">
                    <div class="container">
                        <?php require_once VIEWS_PATH . '/post.php'; ?>
                    </div>
                </div>

                <!--ABOUT US ------------------------>
                <div role="tabpanel" class="tab-pane" id="about">
                    <div class="container">
                        <?php require_once VIEWS_PATH . '/aboutUs.php'; ?>  
                    </div>
                </div>
            </div>

            <!-- footer -->
            <?php require_once __DIR__ . '/components/footer.php'; ?>
            <!-- /.footer -->

            <script type="text/javascript">
                //throw "exit";
                $('.contactPosterModal').modal('toggle');

                /**
                 * Home page
                 */
                if (context !== null && context !== '') {
                    console.log($('#myTab a[href="#' + context + '"]'));
                    $('#myTab a[href="#' + context + '"]').tab('show'); // Select tab by name
                }

                /** 
                 *  Browse tab/page
                 */
                // submit the form when a pet image is clicked
                $('.petImage').click(function () {
                    console.log('submit pet detail form');
                    $(this).parent().submit();
                });

                // pass pet filter selections to js vars
                var selectedSpecies = '<?php echo isset($get['species']) ? $get['species'] : null; ?>';
                var selectedBreed = '<?php echo isset($get['breed']) ? $get['breed'] : null; ?>';

                // populate the breed dropdown if a species is selected
                if (selectedSpecies !== null) {
                    console.log("populate breed selector");
                    populateBreedSelector("breedSelector", selectedSpecies, selectedBreed);
                }

                populateAgeSelector('ageSelector', ages);

                // attach an onchange event handler to the species dropdown in search 
                $("#speciesSelector").change(function () {
                    //console.log($(this).val());
                    console.log("populate species selector");
                    populateBreedSelector("breedSelector", $(this).val(), null);
                });

                // attach an onchange event handler to the species dropdown in post
                $("#speciesForPost").change(function () {
                    //console.log($(this).val());
                    populateBreedSelector("breedsForPost", $(this).val(), null);
                });

                var numPerPage = 2;
                var page = 1;
                var pageLabel = 1;
                var lastPage = Math.floor(<?php echo $total; ?>);

                // Pet tile (Browse page) details expansion code
                $('.petTileExpansion').hide();
                $('.petTileExpansionButton').click(function () {
                    console.log("pet tile expansion");
                    $(this).parent().find('.petTileExpansion').toggle(400, 'linear', function () {
                        //console.log($(this).parent().find('.petTileExpansion').css('display'))
                        if ($(this).parent().find('.petTileExpansion').css('display') == 'none') {
                            $('.petTileExpansionButton').find('span').removeClass('glyphicon-menu-up').addClass('glyphicon-menu-down');
                        } else {
                            $('.petTileExpansionButton').find('span').removeClass('glyphicon-menu-down').addClass('glyphicon-menu-up');
                        }
                    });
                });
                
                $('#post').click(function(){
                    if (user === undefined || user === '') {                 
                        $("#loginModal").modal('toggle');
                    }
                });
                
                
                // resets all filter element states to defaults
                $('#resetFilter').click(function () {
                    console.log("reset filter click");
                    $("#speciesSelector").find('option:selected').attr('selected', false);
                    $("#breedSelector").find('option').remove();
                    $(".sexCheckBox").attr("checked", false);
                    $(".sizeCheckBox").attr("checked", false);
                    $("#ageSelector").find('option:selected').attr("selected", false);
                });
                
                // only on checkbox can be checked at a time
                $('.sexCheckBox').click(function(){
                    console.log("clicked");
                    console.log(this);
                    $('.sexCheckBox').each(function(i, element){
                        //console.log("each");
                        //console.log(element);
                        $(element).removeAttr("checked");
                        
                    });
                    $(this).prop("checked", true);
                });
   
                // only on checkbox can be checked at a time   
                $('.sizeCheckBox').click(function(){
                    console.log("clicked");
                    console.log(this);
                    $('.sizeCheckBox').each(function(i, element){
                        //console.log("each");
                        //console.log(element);
                        $(element).removeAttr("checked");
                        
                    });
                    $(this).prop("checked", true);
                });
               
            </script>
        </div>
    </body>
</html>

