<?php
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="en">
    <?php require_once __DIR__ . '/head.php'; ?>
    <body>
        <?php require_once __DIR__ . '/navigation.php'; ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12 starter-template">
                    <div class="form-group">
                        <label style="float:left;" for="imageName">Image name</label>
                        <input type="text" id="imageName" class="form-control" name="imageName" form="uploadForm">
                    </div>
                </div>
            </div>
        </div><!-- /.container -->
        <div class="container">
            <div class="row">
                <div class="col-md-12 starter-template">
                    <div class="form-group">
                        <label style="float:left" for="imageDescription">Image Description</label>
                        <textarea class="form-control" rows="5" id="imageDescription" name="imageDescription" form="uploadForm"></textarea>
                    </div>
                </div>
            </div>
        </div><!-- /.container -->
        <div class="container">
            <div class="row">
                <form id="uploadForm" action="upload.php" method="post" enctype="multipart/form-data">
                    <div class="col-md-6">
                        <span class="submitLabel">Select image to upload:</span>
                        <input type="file" name="fileToUpload" id="fileToUpload">
                    </div>
                    <div class="col-md-6">
                        <input class="btn btn-default btn-md uploadButton" type="submit" name="submit" value="Upload Image">
                    </div>
                </form>
            </div>
        </div><!-- /.container -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    </body>
</html>

