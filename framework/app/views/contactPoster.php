<?php
$get = Core\Input::get();
$post = Core\Input::post()
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require_once __DIR__ . '/components/head.php'; ?>
    </head>
    <body>
        <?php
        $page = "contactPoster";
        require_once __DIR__ . '/components/header.php';
        ?>
        <div class="container">        
            <div class="row navOverrideContactPoster">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <?php require_once __DIR__ . '/components/navigation.php'; ?>
                </div>
                <div class="col-md-2"></div>
            </div>
            <!-- BACK TO SEARCH BUTTON -->
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
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
                        ?>
                        <input type="hidden" name="species" value="<?php echo $filterSpecies; ?>">
                        <input type="hidden" name="breed" value="<?php echo $filterBreed; ?>">
                        <input type="hidden" name="sex" value="<?php echo $filterSex; ?>">
                        <input type="hidden" name="size" value="<?php echo $filterSize; ?>">
                        <input type="hidden" name="age" value="<?php echo $filterAge; ?>">
                        <input type="hidden" name="pagejump" value="<?php echo $pagejump; ?>">
                        <input type="hidden" name="context" value="browse">
                        <input class="btn btn-default btn-md" style="float:left; margin: 10px" type="submit" value="Back To Search">
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 topPaddingTwoPercent">
                    <div class="row">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-8">
                            <h3>Contact the pet owner</h3>
                        </div>
                        <div class="col-md-2">
                        </div>
                    </div>
                    <div class="row topPaddingTwoPercent">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-3">
                            <input class="form-control" type="text" placeholder="Name">
                        </div>
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-3">
                            <input class="form-control" type="text" placeholder="Email">
                        </div>
                        <div class="col-md-2">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-8 topPaddingFourPercent">
                            <textarea class="form-control" placeholder="Message..."></textarea>
                        </div>
                        <div class="col-md-2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container -->
    <?php require_once(VIEWS_PATH . "/components/footer.php"); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script type="text/javascript">
    </script>
</body>
</html>

