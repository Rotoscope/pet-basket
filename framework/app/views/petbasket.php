<!DOCTYPE html>
<html lang="en">
    <?php require_once __DIR__ . '/components/head.php'; ?>
    <body>
        <?php
        $page = "petbasket";
        require_once __DIR__ . '/components/header.php';
        ?>
        <div id="wrapper">
            <div class="container" style="padding-bottom: 60px;">
                <div class="row">
                    <div class="center-block">
                        <?php
                        require_once __DIR__ . '/components/navigation.php';
                        ?>
                    </div>
                    <!-- Page Content -->
                    <div class="row" style="margin-left: 0px;">
                        Your Pet Basket:
                    </div>
                    <div class="row" style="margin: auto; border: 1px solid;">
                        <div class="col-md-4">
                            <img style="max-height: 200px; max-width: 200px;" src="http://www.cats.org.uk/uploads/images/pages/photo_latest14.jpg" class="petImage"/>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="petName">Pet Name</div>
                            </div>
                            <div class="row">
                                <div class="petDescription">Pet Description</div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <input class="petRemove" type="submit" name="removePet" value="Remove Pet" />
                            <input class="petAdopt" type="submit" name="adoptpet" value="Adopt Pet" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
