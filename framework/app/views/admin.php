<?php
$get = Core\Input::get();
$post = Core\Input::post()
?>
<!DOCTYPE html>
<html lang="en">
    <?php require_once __DIR__ . '/components/head.php'; ?>
    <body id="page_0">
        <?php
        $page = "admin";
        require_once __DIR__ . '/components/header.php';
        //exit;
        //require_once __DIR__ . '/login.php';

        require_once __DIR__ . '/components/petBasketModal.php';
        require_once __DIR__ . '/components/pagingWidget.php'
        ?>
        <!-- Start section-navigation -->
        <!-- nav tabs -->
        <div class="container">
            <div id="mynavbar" class="navbar-collapse collapse">
                <ul class="nav nav-tabs" role="tablist" id="myTab">
                    <li id="adminAllTab" role="presentation" class="active"><a href="#adminAll" aria-controls="adminAll" role="tab" data-toggle="tab">All</a></li>
                    <li id="adminNewTab" role="presentation"><a href="#adminNew" aria-controls="adminNew" role="tab" data-toggle="tab">New</a></li>
                </ul>
            </div>
            <!-- nav tab content -->

            <!--ADMIN ALL CONTENT GOES HERE-->
            <div class="tab-content">
                <input type='hidden' id="totalPages"/> 

                <div role="tabpanel" class="tab-pane active" id="adminAll">
                    <?php require_once __DIR__ . '/adminAll.php' ?>
                </div><!-- /.tabpanel -->

                <div role="tabpanel" class="tab-pane" id="adminNew">
                    <?php require_once __DIR__ . '/adminNew.php' ?>
                </div>
            </div>
            <!-- Start section-footer -->
            <?php require_once __DIR__ . '/components/footer.php'; ?>
            <!-- End section-footer -->
            <script type="text/javascript">
                //default totalpages to adminAll value for paging widget
                $("#totalPages").val('<?php echo $totalAll; ?>');
                defaultPath = '#page_A_';

                $('#adminNewTab').click(function () {
                    //reset paging widget data
                    page = 1;
                    pageLabel = 1;
                    defaultPath = '#page_N_';
                    //
                    $('#pageNumber').html(pageLabel);
                    $("#totalPages").val('<?php echo $totalNew; ?>');
                    //alert($("#totalPages").val());
                });
                $('#adminAllTab').click(function () {
                    page = 1;
                    pageLabel = 1;
                    defaultPath = '#page_A_';
                    $('#pageNumber').html(pageLabel);
                    $("#totalPages").val('<?php echo $totalAll; ?>');
                });


                $(".adminDecline").click(function () {
                    var dataUser = $(this).attr("data-user");
                    var dataParts = dataUser.split('#');
                    var petId = dataParts[1];
                    var path = '/~' + SHELL_USERNAME + '/index.php/PetBasket/adminDecline?petId=' + petId;
                    //console.log(path);
                    $.ajax({
                        type: "GET",
                        url: path
                    });
                    $('.' + petId + "_visibility").each(function () {
                        $(this).html("n");
                    });
                    $('.' + petId + "_approved").each(function () {
                        $(this).html("Declined");
                    });
                });
                $(".adminRemove").click(function () {
                    var dataUser = $(this).attr("data-user");
                    var dataParts = dataUser.split('#');
                    var petId = dataParts[1];
                    var path = '/~' + SHELL_USERNAME + '/index.php/PetBasket/adminRemove?petId=' + petId;
                    //console.log(path);
                    $.ajax({
                        type: "GET",
                        url: path
                    });
                    $('.' + petId + "_visibility").each(function () {
                        $(this).html("n");
                    });
                    //$('#' + petId + "_approved").html("Declined");
                });

                $(".adminApprove").click(function () {
                    var dataUser = $(this).attr("data-user");
                    var dataParts = dataUser.split('#');
                    var petId = dataParts[1];
                    var path = '/~' + SHELL_USERNAME + '/index.php/PetBasket/adminApprove?petId=' + petId;
                    //console.log(path);
                    $.ajax({
                        type: "GET",
                        url: path
                    });
//                    $('.' + petId + "_visibility").html("y");
//                    $('.' + petId + "_approved").html("Approved");
                    $('.' + petId + "_visibility").each(function () {
                        $(this).html("y");
                    });
                    $('.' + petId + "_approved").each(function () {
                        $(this).html("Approved");
                    });
                });
                /**
                 * Home page
                 */

                // return to a particular tab/page after a full request
                var context = '<?php echo isset($get['context']) ? $get['context'] : null; ?>';
                console.log(context);
                if (context !== null && context !== '') {
                    console.log($('#myTab a[href="#' + context + '"]'));
                    $('#myTab a[href="#' + context + '"]').tab('show') // Select tab by name
                }

                /** 
                 *  Browse tab/page
                 */

                // submit the form when a pet image is clicked
                $('.petImage').click(function () {
                    $(this).parent().submit();
                });
                // pass pet filter selections to js vars
                var selectedSpecies = '<?php echo isset($get['species']) ? $get['species'] : null; ?>';
                var selectedBreed = '<?php echo isset($get['breed']) ? $get['breed'] : null; ?>';
                // populate the breed dropdown if a species is selected
                if (selectedSpecies !== null) {
                    populateBreedSelector("breedSelector", selectedSpecies, selectedBreed);
                }
                populateAgeSelector('ageSelector', ages);
                // attach an onchange event handler to the species dropdown in search 
                $("#speciesSelector").change(function () {
                    //console.log($(this).val());
                    populateBreedSelector("breedSelector", $(this).val(), null);
                });
                // attach an onchange event handler to the species dropdown in post
                $("#speciesForPost").change(function () {
                    //console.log($(this).val());
                    populateBreedSelector("breedsForPost", $(this).val(), null);
                });
                // resets all filter element states to defaults
                function resetFilter() {
                    $("#breedSelector").find('option:selected').attr("selected", false);
                    $(".sexCheckBox").find('input:checked').attr("checked", false);
                    $(".sizeCheckBox").find('input:checked').attr("checked", false);
                    $("#ageSelector").find('option:selected').attr("selected", false);
                }

                $('.petTileExpansion').hide();
                $('.petTileExpansionButton').click(function () {
                    $(this).parent().find('.petTileExpansion').toggle(400, 'linear', function () {
                        console.log($(this).parent().find('.petTileExpansion').css('display'));
                        if ($(this).parent().find('.petTileExpansion').css('display') == 'none') {
                            $('.petTileExpansionButton').find('span').removeClass('glyphicon-menu-up').addClass('glyphicon-menu-down');
                        } else {
                            $('.petTileExpansionButton').find('span').removeClass('glyphicon-menu-down').addClass('glyphicon-menu-up');
                        }
                    });
                });
            </script>
        </div>
        <!-- End of section-tabs -->
    </body>
</html>

