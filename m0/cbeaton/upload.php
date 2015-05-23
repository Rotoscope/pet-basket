<?php
require_once __DIR__ . '/config.php';
$error = array(
    'status' => 0,
    'msg' => '',
);

$mysqli = new mysqli("sfsuswe.com", "cbeaton", "stussy", "student_cbeaton");
if ($mysqli->connect_errno) {
    echo "MySQL connection failure: " . $mysqli->connect_error;
}

// Filter external data sent to this page over HTTP POST
$post = filter_input_array(INPUT_POST);

$imageName = $post["imageName"];

// Always escape user supplied data before using it in a sql query   " '; DROP ALL TABLES; "
$cleanImageName = mysqli_escape_string($mysqli, $imageName);
$sql = <<<q
        SELECT `name` FROM image WHERE `name`='$cleanImageName';
q;
$res = $mysqli->query($sql);
$rows = $res->fetch_assoc();
if (!empty($rows)) {  // Database already has an image with this title recorded
    $msg = "An image by that name already exists, please choose another";
    $error['status'] = 1;
    $error['msg'] = $msg;
}

$imageType = $_FILES["fileToUpload"]['type'];
$fileName = $_FILES["fileToUpload"]['name'];
$imageSize = $_FILES["fileToUpload"]['size'];
$target_dir = __DIR__ . '/' . UPLOAD_DIR;
$target_file = $target_dir . $fileName;     // the full path we want the image uploaded to
$description = ($post === false || $post === null) ? '' : $post["imageDescription"];   // user supplied in form
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION); // extension and path info

$bytesWrittenLrg = -1;
$bytesWrittenMed = -1;
$bytesWrittenSm = -1;
$target_file_lrg_name = '';
$target_file_med_name = '';
$target_file_sm_name = '';

if (isset($post["submit"]) && $error['status'] === 0) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);  // image dimensions and other data
    if ($check !== false) { // File is an image
        if (file_exists($target_file)) { // File with at target path already exists, try to create a new unique target path 
            $name = explode('.', $fileName);
            if ($name !== false) {
                $fileName = $name[0] . '_' . time() . '.' . $imageFileType;
                $target_file = $target_dir . $fileName;
            } else {
                $fileName = microtime() . '.' . $imageFileType;
                $target_file = $target_dir . $fileName;
            }
        }
        if (!file_exists($target_file)) { // File does not exist on target path, yet
            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 10000000) { // 10mb max
                $error['status'] = 1;
                $error['msg'] = "Sorry, your file is too large.";
            } else {
                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    $error['status'] = 1;
                    $error['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                } else {
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) { // move uploaded file from temporary directory to target path
                        // Get new dimensions
                        list($width_orig, $height_orig) = getimagesize($target_file);

                        $width_lrg = $width_orig;
                        $height_lrg = $height_orig;
                        $target_file_lrg_name = $fileName;
                        $target_file_lrg = $target_dir . $target_file_lrg_name;

                        // Resample uploaded image
                        switch ($imageFileType) {
                            case 'jpeg':
                                $image = imagecreatefromjpeg($target_file);
                                break;
                            case 'jpg':
                                $image = imagecreatefromjpeg($target_file);
                                break;
                            case 'png':
                                $image = imagecreatefrompng($target_file);
                                break;
                            case 'gif':
                                $image = imagecreatefromgif($target_file);
                                break;
                            default:
                                die("Image not supported");
                        }
                        $name = explode('.', $fileName);
                        $width_med = $width_orig * .75;
                        $height_med = $height_orig * .75;
                        /*
                          $rgba = imagecolorat($image, 0, 0);
                          $alpha = ($rgba & 0x7F000000) >> 24;
                         */
                        $image_med = imagecreatetruecolor($width_med, $height_med);  // create a black background         
                        if ($imageFileType === 'png') {
                            imagesavealpha($image_med, true);
                            $trans_colour = imagecolorallocatealpha($image_med, 0, 0, 0, 127);
                            imagefill($image_med, 0, 0, $trans_colour);
                        }
                        imagecopyresampled($image_med, $image, 0, 0, 0, 0, $width_med, $height_med, $width_orig, $height_orig);  // overlay resampled image
                        $size = '_' . round($width_med) . 'x' . round($height_med);
                        $name = isset($name[0]) ? $name[0] : microtime();
                        $target_file_med_name = $name . $size . '.' . $imageFileType;
                        $target_file_med = $target_dir . $target_file_med_name;

                        $width_sm = $width_orig * .5;
                        $height_sm = $height_orig * .5;
                        $image_sm = imagecreatetruecolor($width_sm, $height_sm);
                        if ($imageFileType === 'png') {
                            imagesavealpha($image_sm, true);
                            $trans_colour = imagecolorallocatealpha($image_sm, 0, 0, 0, 127);
                            imagefill($image_sm, 0, 0, $trans_colour);
                        }
                        imagecopyresampled($image_sm, $image, 0, 0, 0, 0, $width_sm, $height_sm, $width_orig, $height_orig);
                        $size = '_' . round($width_sm) . 'x' . round($height_sm);
                        $target_file_sm_name = $name . $size . '.' . $imageFileType;
                        $target_file_sm = $target_dir . $target_file_sm_name;

                        /*
                          echo "<br/><br/>";
                          var_dump(file_exists($target_file_lrg));
                          echo "<br/><br/>";
                          var_dump(file_exists($target_file_med));
                          echo "<br/><br/>";
                          var_dump(file_exists($target_file_sm));

                          ob_start();
                          imagejpeg($image_lrg);
                          $lrg = ob_get_contents();
                          ob_end_clean();
                         */

                        // Capture image data
                        ob_start();
                        switch ($imageFileType) {
                            case 'jpeg':
                                imagejpeg($image_med);
                                break;
                            case 'jpg':
                                imagejpeg($image_med);
                                break;
                            case 'png':
                                imagepng($image_med);
                                break;
                            case 'gif':
                                imagejpeg($image_med);
                                break;
                            default:
                                die("Image not supported");
                        }

                        $med = ob_get_contents();
                        ob_end_clean();

                        ob_start();
                        switch ($imageFileType) {
                            case 'jpeg':
                                imagejpeg($image_sm);
                                break;
                            case 'jpg':
                                imagejpeg($image_sm);
                                break;
                            case 'png':
                                imagepng($image_sm);
                                break;
                            case 'gif':
                                imagejpeg($image_sm);
                                break;
                            default:
                                die("Image not supported");
                        }
                        $sm = ob_get_contents();
                        ob_end_clean();

                        // Write image data to local files
                        //$bytesWrittenLrg = file_put_contents($target_file_lrg, $lrg);
                        $bytesWrittenMed = file_put_contents($target_file_med, $med);
                        $bytesWrittenSm = file_put_contents($target_file_sm, $sm);

                        // JSON structure to store thumbnail data
                        $thumbnailsCreated = array(
                            'med' => array(
                                'dimensions' => '',
                                'fileName' => '',
                            ),
                            'sm' => array(
                                'dimensions' => '',
                                'fileName' => '',
                            ),
                        );
                        $thumbnailsCreated['med']['dimensions'] = ($bytesWrittenMed > 0) ? $width_med . 'x' . $height_med : '';
                        $thumbnailsCreated['sm']['dimensions'] = ($bytesWrittenSm > 0) ? $width_sm . 'x' . $height_sm : '';
                        $thumbnailsCreated['med']['fileName'] = ($bytesWrittenMed > 0) ? $target_file_med_name : '';
                        $thumbnailsCreated['sm']['fileName'] = ($bytesWrittenSm > 0) ? $target_file_sm_name : '';

                        // Escape user supplied and external data prior to using in SQL
                        $cleanImageName = mysqli_escape_string($mysqli, $imageName);
                        $cleanFileName = mysqli_escape_string($mysqli, $fileName);
                        $cleanImageType = mysqli_escape_string($mysqli, $imageType);
                        $cleanDescription = mysqli_escape_string($mysqli, $description);
                        $json = json_encode($thumbnailsCreated);
                        $thumbnailsCreatedJson = ($json === false) ? '' : mysqli_escape_string($mysqli, $json);
                        $now = time();
                        $imageSize = is_numeric($imageSize) ? $imageSize : 0;
                        // Create a record of the uploaded file name, description, thumbnails, etc
                        $sql = <<<q
                                INSERT INTO `image`
                                    (`id`, `name`, `file_name`, `type`, `size`, `width`, `height`, `description`, `thumbnails`, `created`, `updated`) 
                                VALUES (DEFAULT, '$cleanImageName', '$cleanFileName', '$cleanImageType', $imageSize, $width_orig, $height_orig, '$cleanDescription', '$thumbnailsCreatedJson', $now, $now);
q;
                        $res = $mysqli->query($sql);
                        if ($res === false) {  // log errors
                            $msg = mysqli_error($mysqli);
                            error_log("\n" . date('Y-m-d H:i:s', time()) . ": " . $msg, 3, __DIR__ . '/../logs/mysql_error.log');
                        }

                        imagedestroy($image);  // free up resources
                    } else {
                        $error['status'] = 1;
                        $error['msg'] = "Sorry, there was an error uploading your file.";
                    }
                }
            }
        } else {
            $msg = "The file $fileName already exists. ";
            $error['status'] = 1;
            $error['msg'] = $msg;
        }
    } else {
        $msg = "Failed to calculate image metadata";
        $error['status'] = 1;
        $error['msg'] = $msg;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <?php require_once __DIR__ . '/head.php'; ?>
    <body>
        <?php require_once __DIR__ . '/navigation.php'; ?>
        <div class="container">
            <div class="row starter-template">
                <?php
                $originalImageSrc = '';
                $originalDimensions = '';
                $medImageSrc = '';
                $medImageSize = '';
                $smImageSrc = '';
                $smImageSize = '';
                $imageName = '';
                $description = '';

                if ($error['status']) {
                    ?>
                    <div class="col-md-12">
                        <h4><?php echo $error['msg']; ?></h4>  
                    </div>
                </div>
            </div>
            <?php
        } else {
            if (isset($cleanImageName)) {
                // Query the database for metadata about uploaded images with a specific name
                $sql = <<<q
                    SELECT * FROM image WHERE name='$cleanImageName' ORDER BY updated DESC LIMIT 1;
q;
                $res = $mysqli->query($sql);
                $rows = $res->fetch_assoc();

                // Set data used in img src attribute, image name, and description
                $originalImageFileName = $rows["file_name"];
                $originalImageSrc = UPLOAD_DIR . $originalImageFileName;
                $originalDimensions = $rows["width"] . 'x' . $rows["height"];
                $thumbnails = json_decode($rows["thumbnails"]);
                $imageName = $rows["name"];
                $description = $rows["description"];

                // Thumbnail src attributes and dimensions, dimensions used for alt attribute
                if ($thumbnails !== null) {
                    $medImageFileName = $thumbnails->med->fileName;
                    $medImageSrc = UPLOAD_DIR . $medImageFileName;
                    $medImageDimensions = $thumbnails->med->dimensions;
                    $smImageFileName = $thumbnails->sm->fileName;
                    $smImageSrc = UPLOAD_DIR . $smImageFileName;
                    $smImageDimensions = $thumbnails->sm->dimensions;
                }
            } else {
                $msg = "Missing image metadata for $imageName";
                error_log("\n" . date('Y-m-d H:i:s', time()) . ": " . $msg, 3, __DIR__ . '/../logs/mysql_error.log');
            }
            ?>
            <div class="container">
                <div class="row starter-template">
                    <div class="col-md-12">
                        <h2 class="description"><?php echo $imageName; ?></h2>
                    </div>
                </div>
            </div>        
            <div class="container">
                <div class="row starter-template">
                    <div class="col-md-12">
                        <p class="description"><?php echo $description; ?></p>
                    </div>
                </div>
            </div>        
            <div class="container">
                <div class="row starter-template">
                    <div class="col-md-12">
                        <p class="description"><?php echo $originalImageFileName; ?></p>
                        <img src="<?php echo $originalImageSrc; ?>" alt="<?php echo $originalDimensions; ?>">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row starter-template">
                    <div class="col-md-12">   
                        <p class="description"><?php echo $medImageFileName; ?></p>
                        <img src="<?php echo $medImageSrc; ?>" alt="<?php echo $medImageDimensions; ?>">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row starter-template">
                    <div class="col-md-12">   
                        <p class="description"><?php echo $smImageFileName; ?></p>
                        <img src="<?php echo $smImageSrc; ?>" alt="<?php echo $smImageDimensions; ?>">
                    </div>
                <?php } ?>
            </div>
        </div><!-- /.container -->
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <!--
        <script src="../../dist/js/bootstrap.min.js"></script>
        -->
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <!--
        <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
        -->
    </body>
</html>
