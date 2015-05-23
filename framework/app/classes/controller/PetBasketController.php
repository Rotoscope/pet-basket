<?php

/**
 * PetBasket application controller class
 */
class PetBasketController extends Core\Controller {

    /**
     * Default response
     * @param type $passedToView  set of variables passed to view pages
     * @return type string        response page
     * @throws Exception
     */
    public static function index($passedToView = array()) {
        //var_dump($passedToView);
        ob_start();
        require VIEWS_PATH . '/home.php';
        return ob_get_clean();
    }

    // alias of index
    public static function home() {
        return self::index();
    }

    public static function privacy() {
        ob_start();
        require VIEWS_PATH . '/privacy.php';
        return ob_get_clean();
    }

    public static function terms() {
        ob_start();
        require VIEWS_PATH . '/termsFooter.php';
        return ob_get_clean();
    }

    /**
     * Check the login status of a user and checks if user exist
     * @param type post  set of variables passed to view pages
     * @return type json        
     */
    public static function checkLogin() {
        //var_dump($_SESSION);
        $post = Core\Input::post();

        if (isset($_SESSION['user'])) {
            return json_encode(array('status' => 0, 'errorCode' => 3));
        }

        $user = self::getUser($post["username"]);
        $password = $post["password"];

        if (!isset($user)) {
            return json_encode(array('status' => 0, 'errorCode' => 1));
        }

        if (!(isset($password) && $user->getPassword() === crypt($password, $user->getPassword()))) {
            return json_encode(array('status' => 0, 'errorCode' => 2));
        }

        return json_encode(array('status' => 1));
    }

    /**
     * Respond with the login view
     * @param type $passedToView  set of variables passed to the view
     * @return type  
     */
    public static function login($passedToView = array()) {
        //var_dump($passedToView);
        $post = Core\Input::post();
        $get = Core\Input::get();

        $referrer = isset($post["referrer"]) ? $post["referrer"] : null;
        $referrer = isset($get["referrer"]) ? $get["referrer"] : $referrer;
        //var_dump($referrer);
        $referrer = ($referrer === null && isset($passedToView['referrer'])) ? $passedToView['referrer'] : $referrer;

        if ($referrer === null) {
            throw new Exception("Referrer page not set in login controller action");
        }

        $user = self::getUser($post["username"]);
        
        if(isset($user)){
            $user->setLastLogin(time());
            $res = $user->update();
            if ($res !== false) {
                $_SESSION['user'] = $user->getId();
                $_SESSION['username'] = $user->getUsername();
            } else {
                // error is checked at checkLogin
            }
            // error is checked at checkLogin
        }
        //exit;
        //header('Location: http://sfsuswe.com/~' . USER . '/index.php/PetBasket/' . $referrer);
        ob_start();
        require VIEWS_PATH . '/' . $referrer . '.php';
        return ob_get_clean();
    }

    /**
     * Gets the user object
     * @param type $username string that is either the email or the username
     * @return type  user object or null
     */
    public static function getUser($username) {
        if (isset($username)) {
            //check if it is a valid email format else it is a username
            if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
                $res = Model\User::getUserByUsername($username);
            } else {
                $res = Model\User::getUserByEmail($username);
            }
            $row = isset($res[0]) ? $res[0] : $res;
            $user = User::constructByRow($row);
            return $user;
        }
        return null;
    }

    /**
     * Check the signup data of a user and checks if data exist in DB already
     * @param type post  set of variables passed to view pages
     * @return type json        
     */
    public static function checkSignupData() {
        $post = Core\Input::post();

        $username = $post["username"];
        $email = $post["email"];

        //invalid username
        if (!(isset($username) && preg_match("/^[a-zA-Z0-9]*$/", $username))) {
            return json_encode(array('status' => 0, 'errorCode' => 1));
        }

        $res = Model\User::getUserByUsername($username);
        $row = isset($res[0]) ? $res[0] : $res;
        $user = User::constructByRow($row);

        //username exists in db
        if (isset($user)) {
            return json_encode(array('status' => 0, 'errorCode' => 2));
        }

        //invalid email - preg match pattern doesn't work properly; don't know why
        //&& preg_match("/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$/", $email)
        if (!(isset($email))) {
            return json_encode(array('status' => 0, 'errorCode' => 3));
        }

        $res = Model\User::getUserByEmail($email);
        $row = isset($res[0]) ? $res[0] : $res;
        $user = User::constructByRow($row);

        //email exist in db
        if (isset($user)) {
            return json_encode(array('status' => 0, 'errorCode' => 4));
        }

        return json_encode(array('status' => 1));
    }

    /**
     * Process a new user registration
     * @param type $passedToView  set of variables passed to the view
     * @return type  string       response page
     */
    public static function signup($passedToView = array()) {
        $post = Core\Input::post();
        $get = Core\Input::get();
        $passedToView["post"] = $post;
        $passedToView["errorIn"] = false;
        $passedToView["errorMsg"] = false;
        $username = $post["username"];
        $email = $post["email"];
        $password1 = $post["password1"];
        $password2 = $post["password2"];
        if (isset($password1) && $password1 === $password2) {
            $password = crypt($password1);
            $isAdmin = 0;
            $user = new User($username, $password, $email, time(), time(), $isAdmin, time());
            $res = $user->save();

            if ($res !== false) {
                $_SESSION['user'] = $user->getId();
                $_SESSION['username'] = $user->getUsername();
            } else {
                throw new Exception("Error creating user: " . Core\Db::getErrorMessage());
            }

        } else {
            $passedToView["errorIn"] = "signupPassword";
            $passedToView["errorMsg"] = "Passwords don't match";
        }

        $referrer = isset($post["referrer"]) ? $post["referrer"] : null;
        $referrer = isset($get["referrer"]) ? $get["referrer"] : $referrer;
        if ($referrer === null) {
            throw new Exception("Referrer page not set in signup controller action");
        }
        header('Location: http://sfsuswe.com/~' . USER . '/index.php/PetBasket/' . $referrer);
    }

    /**
     * Process the upload of an image
     * @return type  string       response page
     */
    public static function upload() {
        $error = array('status' => 0, 'msg' => '');
        $post = Core\Input::post();
        //var_dump($post);
        //exit;
        $files = Core\Input::files();
        $imageType = $files["fileToUpload"]['type'];
        $fileName = $files["fileToUpload"]['name'];
        $imageSize = $files["fileToUpload"]['size'];
        $target_dir = GROUP_UPLOAD_PATH . '/';
        $target_file = $target_dir . $fileName;  // the full path we want the image uploaded to
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION); // extension and path info
        if (isset($post["submit"]) && $error['status'] === 0 && !empty($files["fileToUpload"]["tmp_name"])) {
            $check = getimagesize($files["fileToUpload"]["tmp_name"]);  // image dimensions and other data
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
                    if ($files["fileToUpload"]["size"] > 10000000) { // 10mb max
                        $error['status'] = 1;
                        $error['msg'] = "Sorry, the file is too large.";
                    } else {
                        // Allow certain file formats
                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                            $error['status'] = 1;
                            $error['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        } else {
                            if (move_uploaded_file($files["fileToUpload"]["tmp_name"], $target_file)) { // move uploaded file from temporary directory to target path
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
                                imagecopyresampled(
                                        $image_sm, $image, 0, 0, 0, 0, $width_sm, $height_sm, $width_orig, $height_orig
                                );
                                $size = '_' . round($width_sm) . 'x' . round($height_sm);
                                $target_file_sm_name = $name . $size . '.' . $imageFileType;
                                $target_file_sm = $target_dir . $target_file_sm_name;

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
                                $thumbnails = array(
                                    'med' => array(
                                        'dimensions' => '',
                                        'fileName' => '',
                                    ),
                                    'sm' => array(
                                        'dimensions' => '',
                                        'fileName' => '',
                                    ),
                                );
                                $thumbnails['med']['dimensions'] = ($bytesWrittenMed > 0) ? $width_med . 'x' . $height_med : '';
                                $thumbnails['sm']['dimensions'] = ($bytesWrittenSm > 0) ? $width_sm . 'x' . $height_sm : '';
                                $thumbnails['med']['fileName'] = ($bytesWrittenMed > 0) ? $target_file_med_name : '';
                                $thumbnails['sm']['fileName'] = ($bytesWrittenSm > 0) ? $target_file_sm_name : '';
                                $thumbnailsJSON = json_encode($thumbnails);
                                //var_dump($json);
                                //exit;
                                $petName = isset($post['petName']) ? trim($post['petName']) : '';
                                $description = isset($post['petDescription']) ? trim($post['petDescription']) : '';
                                $petSpecialNeeds = isset($post['petSpecialNeeds']) ? trim($post['petSpecialNeeds']) : '';
                                $weight = (isset($post['weight']) && $post['weight'] !== '') ? trim($post['weight']) : 'DEFAULT';
                                $species = isset($post['species']) ? $post['species'] : '';
                                $breed = isset($post['breed']) ? $post['breed'] : 'DEFAULT';
                                $age = (isset($post['age']) && $post['age'] !== '') ? trim($post['age']) : "DEFAULT";
                                $sex = (isset($post['sex']) && $post['sex'] !== '') ? $post['sex'] : 'none';
                                if (!isset($_SESSION['user']))
                                    throw new Exception("User must be logged in to post a pet for adoption");
                                $userId = $_SESSION['user'];
                                $adoptionId = '';
                                $created = time();
                                $updated = time();
                                $visibility = 'y';
                                $approved = 0;
                                $pet = new Pet(
                                    $petName, $description, $petSpecialNeeds, $weight, $species, $breed, $age, $sex, $userId, $adoptionId, $created, $updated, $visibility, $approved
                                );
                                $petTableRowId = $pet->save();

                                //exit;
                                if ($petTableRowId === false) {  // log errors
                                    $msg = Core\Db::getErrorMessage();
                                    //error_log("\n" . date('Y-m-d H:i:s', time()) . ": " . $msg, 3, LOG_PATH . '/mysql_error_log');
                                    throw new Exception($msg);
                                }

                                // Create Image object, which creates a record in the DB of its class members
                                $petId = 'pet:' . $petTableRowId;
                                $newImage = new Image(
                                        '', // artifact
                                        '', $fileName, $imageType, $imageSize, $width_orig, $height_orig, $thumbnailsJSON, $petId
                                );

                                $imageTableRowId = $newImage->save();

                                if ($imageTableRowId === false) {  // log errors
                                    $msg = Core\Db::getErrorMessage();
                                    //error_log("\n" . date('Y-m-d H:i:s', time()) . ": " . $msg, 3, LOG_PATH . '/mysql_error_log');
                                    throw new Exception($msg);
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
        if ($error['status'] === 1) {
            return self::index(array('error' => $error['msg']));
        }
        return self::myPets();
    }

    /**
     * Process filter requests and repsond with browse view
     * @return type string        response page
     * @throws Exception
     */
    public static function browse($get = array()) {
        /*
         * Review:  more comments needed. 
         * multi line array definitions would be better
         */

        $error = array('status' => 0, 'msg' => '');   //Review: Not used anywhere
        if (empty($get))
            $get = Core\Input::get();

        // Build the "WHERE" portion of a SQL statement
        $where = array();
        if (isset($get['breed']) && $get['breed'] !== '' && $get['breed'] !== 'All' && $get['breed'] !== 'Other') {
            $where['breed'] = array("type" => "string", "val" => $get["breed"]);   //Review:  More readable if arrays span more than one line
        }
        if (isset($get['sex']) && $get['sex'] !== '') {
            $where['sex'] = array("type" => "string", "val" => $get["sex"]);
        }
        if (isset($get['age']) && $get['age'] !== '') {
            $json = json_decode($get['age']);
            $where['age'] = array("type" => "interval", "max" => $json->max, "min" => $json->min);
        }
        if (isset($get['species']) && $get['species'] !== '' && $get['species'] !== 'All') {
            $where['species'] = array("type" => "string", "val" => $get['species']);
        }
        if (isset($get['size']) && $get['size'] !== '') {
            $weightMax = 0;
            $weightMin = 0;
            switch ($get['size']) {
                case 'xs':
                    $weightMax = 5.0;     //Review: should be constants
                    $weightMin = 0;
                    break;
                case 'sm':
                    $weightMax = 25.0;
                    $weightMin = 5.0;
                    break;
                case 'med':
                    $weightMax = 50.0;
                    $weightMin = 25.0;
                    break;
                case 'lrg':
                    $weightMax = 10000.0;
                    $weightMin = 50.0;
                    break;
                default:
                    $weightMax = 200;
                    $weightMin = 0;
            }
            $where['weight'] = array('type' => 'interval', 'max' => $weightMax, 'min' => $weightMin);
        }

        $whereSQL = array();
        foreach ($where as $key => $val) {
            switch ($val["type"]) {
                case 'interval':
                    $whereSQL[] = " `$key` BETWEEN " . $val["min"] . " AND " . $val["max"] . " ";
                    break;
                case 'string':
                    $whereSQL[] = " `$key` = '" . $val["val"] . "' ";
                    break;
                case 'number':
                    $whereSQL[] = " `$key` = " . $val["val"] . " ";
                    break;
                default:
                    throw new Exception("Type not recognized");
            }
        }
        
        //var_dump($whereSQL);
        
        $whereString = (count($whereSQL) > 0) ? ' WHERE ' . implode(' AND ', $whereSQL) : '';

        $petRows = Model\Pet::getPetByWhere($whereString);
        $pets = array();
        if (is_array($petRows)) {
            foreach ($petRows as $row) {
                $pet = Pet::constructByRow($row);
                $pet->loadImages();
                $pets[] = $pet;
            }
        }

        //Review: comments would be helpful here
        $passedToView['pets'] = $pets;
        if (isset($get['return-php-array']) && $get['return-php-array'] === true) {
            return $pets;
        } else if (isset($get['return-json-array']) && $get['return-json-array'] === true) {
            return json_encode($pets);
        } else {
            ob_start();
            require VIEWS_PATH . '/home.php';
            return ob_get_clean();
        }
    }

    /**
     * Load and send media data response
     * @return type string        response page
     * @throws Exception
     */
    public static function media() {
        $get = Core\Input::get();
        $fileName = GROUP_UPLOAD_PATH . '/' . $get['media'];
        $target = urldecode($fileName);
        $contents = @file_get_contents($target);
        $size = strlen($contents);
        $type = '';
        switch (exif_imagetype($target)) {
            case IMAGETYPE_GIF:
                $type = 'image/gif';
                break;
            case IMAGETYPE_JPEG:
                $type = 'image/jpg';
                break;
            case IMAGETYPE_PNG:
                $type = 'image/png';
                break;
        }
        ob_start();
        if ($type !== '')
            header('Content-Type:' . $type);
        header('Content-Length: ' . $size);
        echo $contents;
        $contents = ob_get_clean();
        return $contents;
    }

    /**
     * Respond with post view
     * @return type string        response page
     * @throws Exception
     */
    public static function post() {
        ob_start();
        require VIEWS_PATH . '/post.php';
        return ob_get_clean();
    }

    /**
     * Generate dedicated and detailed pet view
     * @return type string        response page
     * @throws Exception
     */
    public static function details() {
        $get = Core\Input::get();
        if ($get === null) {
            $msg = "No pet id selected to give details";
            $error['msg'] = $msg;
            //return self::index(array('error' => $error['msg']));
        }

        if (isset($get['id']) && $get['id'] !== '') {
            $petId = $get['id'];
            $pet = Pet::constructById($petId);
            $pet->loadImages();
            $passedToView['pet'] = $pet;
        } else {
            $msg = "<h2>ERROR</h2>No pet id provided for details display";
            $error['msg'] = $msg;
        }

        ob_start();
        require VIEWS_PATH . '/details.php';
        return ob_get_clean();
    }

    /**
     * Respond with notification view
     * @return type string        response page
     * @throws Exception
     */
    /* the folowing function defines the comparable
     * function fed into the usort function. It first 
     * comapres thread ID then compares time stamp
     * note we want decreasing order of thread ID's since 
     * the larger teh thread ID the newer the messages are      
     */
    function cmpMessage($a, $b) {
        $val = $b->getThreadId() - $a->getThreadId();
        if ($val == 0) {
            return $b->getCreated() - $a->getCreated();
        } else
            return $val;
    }

    public static function notification() {
	$userId = $_SESSION["user"];
	$error = array('status' => 0, 'msg' => '');
        
	$messageRows1 = Model\Message::getMessagesByRecipientId($userId);
        $messageRows2 =  Model\Message::getMessagesBySenderId($userId);
        if ($messageRows2 == NULL){
            $messageRows2 = array();
        }
        
        //append the messages that where also sent by the current user.
	//if($messageRows != NULL){
            $messageRows = array_merge($messageRows1,$messageRows2);
        //}
        
	$messages = array();
	if (is_array($messageRows)) {
            
	    //append the messages that where also sent by the current user.
	    //$messageRows = array_merge($messageRows, Model\Message::getMessagesBySenderId($userId));
	    foreach ($messageRows as $row) {
		$message = Message::constructByRow($row);
		$messages[] = $message;
	    }
	}
        

        /* The messages are being sorted so that the threads can
	 * be created. They are sorted first by thread Id then by
	 * timestamp Once sorted as they are iterated over we know we have
	 * come accross a diffrent thread id when the current thread ID differs
	 * from the previous thread ID.
	 */
	usort($messages, array("PetBasketController", 'cmpMessage'));
        
	$threadedMessages = array(); //This array will hold threadedMessage objects

	$format = "-----------------------------------------------------------------------------\n"
		. "%s\t %s: \n %s\n"
		. "-----------------------------------------------------------------------------\n";

        $pastThreadId = null;
        $pastSenderId = 0;
	$pastSenderName = 0;
	$threadedMessage = 0;
	$count = 0;
        //echo $messages[0]->getSenderId();
        //echo $userId;
	for ($i = 0; $i < count($messages); $i++) {
	   
	    $message = $messages[$i];            
            
	    $date = date("m/d/Y", $message->getCreated());
	    $senderId = $message->getSenderId();
            if($senderId == 0) continue;
            $recipientId = $message->getRecipientId();
	    $actualMessage = $message->getMessage();
	    $sender = User::constructById($senderId);
	    $senderName = $sender->getUsername();
            
            
	    if ($count == 0 && $senderId != $userId) {
                $pastThreadId = $message->getThreadId();
		$pastSenderId = $senderId;
                $pastRecipientId = $recipientId;
		$pastSenderName = $senderName;
		$threadedMessage = sprintf($format, $senderName, $date, $actualMessage);
		$visibility = $message->getRecipientVisibility();
		$count++;
	    } else if ($count != 0) {
                // if we are not at the start message we check that the current
		// mesage bolongs to the same thread. If it does we append it
		// appropriately.
		
                $currThreadId = $message->getThreadId();
                
		if ($currThreadId == $pastThreadId) {
		    $tempMessage = sprintf($format, $senderName, $date, $actualMessage);
		    $threadedMessage = sprintf("%s\n%s", $threadedMessage, $tempMessage);

                    //Checking for the special case where we have arrived to the last message
		    if ($i == (count($messages) - 1) && $visibility == 1) {
			$threadedMessages[] = new ThreadedMessage(
                                $pastSenderId,
                                $pastRecipientId,
                                $pastThreadId, 
                                $pastSenderName, 
                                $threadedMessage
                                );
			$threadedMessage = '';
		    }
                    
                    //if we have arrived to a new thread we have to check wether the 
                    //the thread we ahve ben working with is even visible to this user.
                    //if ti is not vissible that means that at some point in the past 
                    //he/she has remoed it.
                    //We also must decrement the index since this new thread is might be the start
                    //of a new threaded message
                } elseif ($visibility == 1) {
                    $threadedMessages[] = new ThreadedMessage($senderId, $recipientId, $pastThreadId, $pastSenderName, $threadedMessage);
                    $threadedMessage = '';
                    $i--;
                    $count = 0;
                    //if this thread is not visible to the user then we siply start over.
                } else {
                    $i--;
                    $count = 0;
                }
            }
        }
        $passedToView['threadedMessages'] = $threadedMessages;
        ob_start();
        require VIEWS_PATH . '/notification.php';
        return ob_get_clean();
    }

    /**
     * Adds the remove functionality to the notification page.
     * Messages are retrived according to their thread ID.
     * Once retieved their visibility field is set to 'n'
     * and threadID to -1
     * @return type string        response page
     * @throws Exception
     */
    public static function removeThread() {
	$userId = $_SESSION["user"];
	$get = Core\Input::get();
	$threadId = NULL;
	if (isset($get['threadId'])) {
	    $threadId = $get['threadId'];
	}
        
        $messageRows = Model\Message::getMessagesByThreadId($threadId);
	if (is_array($messageRows)) {
	    foreach ($messageRows as $row) {
		$message = Message::constructByRow($row);
		//var_dump($message);
		//var_dump($userId);
		//var_dump($message->getSenderId());
		//exit;
		if ($message->getSenderId() == $userId) {
		    $message->setSenderVisibility(0);
		} else {
		    $message->setRecipientVisibility(0);
		}
		$message->update();
	    }
	}
        header('Location: http://sfsuswe.com/~' . USER . '/index.php/PetBasket/notification');
    }

    /**
     * Adds the reply functionality to the notification page.
     * @return type string        response page
     * @throws Exception
     */
    public static function replyThread() {
	$post = Core\Input::post();
	if (isset($post['senderId']) && isset($post['recipientId']) && isset($post['threadId']) && isset($post['reply'])) {
	    //echo "*replyThread*";
	    $messageObj = new Message(
		    $post['senderId'], 
                    $post['recipientId'], 
                    $post['threadId'], 
                    $post['reply'], 
                    time(), //created
		    time(), //updated
		    1, //sender_visibility
		    1);     //recipient_visibility
	    $messageObj->save();
	} else {
	    throw Exception("Error in POST to replyThread");
	}
        header('Location: http://sfsuswe.com/~' . USER . '/index.php/PetBasket/notification');
    }

    /**
     * Generate a view where a user can modify a pet they have posted for adoption
     * @return type string        response page
     * @throws Exception
     */
    public static function modifyPet() {
        $get = Core\Input::get();

        if ($get === null) {
            $msg = "No pet id selected to give details";
            $error['msg'] = $msg;
        }

        if (isset($get['id']) && $get['id'] !== '') {
            $petId = $get['id'];
            $pet = Pet::constructById($petId);
            $pet->loadImages();

            $passedToView['pet'] = $pet;
        }
        
        ob_start();
        require VIEWS_PATH . '/modifyPet.php';
        return ob_get_clean();
    }

    /**
     * Generate a view where a user can modify a pet they have posted for adoption
     * @return type string        response page
     * @throws Exception
     */
    public static function updatePet() {
        $post = Core\Input::post();

        if ($post === null) {
            $msg = "Erorr in aquiring pet ID";
            $error['msg'] = $msg;
        }

        if (isset($post['id']) && $post['id'] !== '') {
            $pet = Pet::constructById($post['id']);
            isset($post['species']) ? $pet->setSpecies($post['species']) : 0;
            isset($post['breed']) ? $pet->setBreed($post['breed']) : 0;
            isset($post['age']) ? $pet->setAge($post['age']) : 0;
            isset($post['weight']) ? $pet->setWeight($post['weight']) : 0;
            isset($post['sex']) ? $pet->setSex($post['sex']) : 0;
            isset($post['description']) ? $pet->setDescription($post['description']) : 0;
            isset($post['specialNeeds']) ? $pet->setSpecialNeeds($post['specialNeeds']) : 0;

            Model\Pet::updatePet($pet);
        }
        
        return PetBasketController::myPets();
    }

    /**
     * Generate contactUpdate view for a user to update her contact information
     * @return type string        response page
     * @throws Exception
     */
    public static function contactUpdate() {
        //filler function for now
        if (isset($_POST['id'])) {
            $userId = $_POST['id'];
        }

        ob_start();
        require VIEWS_PATH . '/contactUpdate.php';
        return ob_get_clean();
    }

    /**
     * Generate contactPoster view for a user to contact the poster of a pet
     * @return type string        response page
     * @throws Exception
     */
    public static function contactPoster() {
        //filler function for now
        ob_start();
        require VIEWS_PATH . '/contactPoster.php';
        return ob_get_clean();
    }

    /**
     * Generate myPets view
     * @return type string        response page
     * @throws Exception
     */
    public static function myPets($passedToView = array()) {
        $get = Core\Input::get();
        $userId = $_SESSION['user'];
        $petRows = Model\Pet::getPetByUserId($userId);
        $pets = array();
        if (is_array($petRows)) {
            foreach ($petRows as $row) {
                $pet = Pet::constructByRow($row);
                $pet->loadImages();
                $pets[] = $pet;
            }
        }
        $passedToView['pets'] = $pets;
        ob_start();
        require VIEWS_PATH . '/myPets.php';
        return ob_get_clean();
    }

    /**
     * Generate the Pet Basket of a user
     * @param type $userId        generate this user's basket
     * @param type $returnType    'json' for json formatted object, else php Basket object
     * @return mixed              Basket instance or json version of Basket instance
     */
    public static function myPetBasket($userId, $returnType) {
        $basket = Basket::constructByUserId($userId);
        if ($returnType === 'json') {
            return json_encode($basket->__toString());
        }
        return $basket;
    }

    /**
     * Add a pet to a user's PetBasket
     * @return boolean  true on successful insertion or false otherwise
     */
    public static function addToBasket() {
        $post = Core\Input::post();
        if (isset($post['userId']) && isset($post['petId'])) {
            $basket = new Basket($post['userId'], array());
            $res = $basket->addPet($post['petId']);
            $pet = Pet::constructById($post['petId']);
            $pet->loadImages();
            if ($res) {
                return json_encode(array('userId' => $post['userId'], 'pet' => $pet->__toString()));
            }
        }
        return false;
    }

    /**
     * Remove a pet from a user's basket
     * @return boolean  true on successful insertion or false otherwise
     */
    public static function removeFromBasket() {
        $post = Core\Input::post();
        if (isset($post['userId']) && isset($post['petId'])) {
            $basket = new Basket($post['userId'], array());
            $res = $basket->removePet($post['petId']);
            if ($res) {
                return json_encode($post);
            }
        }
        return false;
    }

    /**
     * Remove Pet From my Pets
     * @return to myPets ciew
     */
    public static function removeFromMyPets() {
        $post = Core\Input::post();
        if (isset($post['id'])) {
            $pet = Pet::constructById($post['id']);
            $pet->setApproved(3);
            $pet->setVisibility('n');
            Model\Pet::updatePet($pet);
        }
        return PetBasketController::myPets();
    }

    public static function admin() {
        $error = array('status' => 0, 'msg' => '');
        $get = Core\Input::get();
        //adminAll Rows
        //$petRowsAll = Model\Pet::getPetByApproved(1);
        $petRowsAll = Model\Pet::getAllPets();
        $petsAll = array();
        if (is_array($petRowsAll)) {
            foreach ($petRowsAll as $row) {
                $pet = Pet::constructByRow($row);
                $pet->loadImages();
                $petsAll[] = $pet;
            }
        }
        $passedToView['allPets'] = $petsAll;

        $petRowsNew = Model\Pet::getPetByApproved(0);
        $petsNew = array();
        if (is_array($petRowsNew)) {
            foreach ($petRowsNew as $row) {
                $pet = Pet::constructByRow($row);
                $pet->loadImages();
                $petsNew[] = $pet;
            }
        }
        $passedToView['newPets'] = $petsNew;

        ob_start();
        require VIEWS_PATH . '/admin.php';
        return ob_get_clean();
    }

    /**
     * Approve a pet posting
     * @return type string        response page
     * @throws Exception
     */
    public static function adminApprove() {
        $get = Core\Input::get();
        if (isset($get['petId'])) {
            $petId = $get['petId'];
            $pet = Pet::constructById($petId);
            $pet->setApproved(1);
            $pet->setVisibility('y');
            Model\Pet::updatePet($pet);
        }
        //return self::adminNew();
//        ob_start();
//        $url = 'http://sfsuswe.com/~nthanlee/index.php/PetBasket/admin';
//        while (ob_get_status()) {
//            ob_end_clean();
//        }
//        header("Location: $url");
    }

    public static function adminRemove() {
        $get = Core\Input::get();
        if (isset($get['petId'])) {
            $petId = $get['petId'];
            $pet = Pet::constructById($petId);
            //$pet->setApproved(1);
            $pet->setVisibility('n');
            Model\Pet::updatePet($pet);
        }
        //return self::adminNew();
//        ob_start();
//        $url = 'http://sfsuswe.com/~nthanlee/index.php/PetBasket/admin';
//        while (ob_get_status()) {
//            ob_end_clean();
//        }
//        header("Location: $url");
    }

    /**
     * Decline a pet posting
     * @return type string        response page
     * @throws Exception
     */
    public static function adminDecline() {
//        if (isset($_POST['id'])) {
        $get = Core\Input::get();
        if (isset($get['petId'])) {
            //$petId = $_POST['id'];
            $petId = $get['petId'];
            $pet = Pet::constructById($petId);
            $pet->setApproved(2);
            $pet->setVisibility('n');
            Model\Pet::updatePet($pet);
        }
//        ob_start();
//        $url = 'http://sfsuswe.com/~nthanlee/index.php/PetBasket/admin';
//        while (ob_get_status()) {
//            ob_end_clean();
//        }
//        header("Location: $url");
    }

    /**
     * Respond with aboutUs view
     * @return type string        response page
     * @throws Exception
     */
    public static function aboutUs() {
        ob_start();
        require VIEWS_PATH . '/aboutUs.php';
        return ob_get_clean();
    }

    /**
     * Generate petBasket view
     * @return string     response page
     */
    public static function petbasket() {
        ob_start();
        require VIEWS_PATH . '/petbasket.php';
        return ob_get_clean();
    }

    /**
     * Processes a user password update
     * @param array $passedToView
     */
    public static function updatePassword($passedToView = array()) {
        $post = Core\Input::post();
        $passedToView["post"] = $post;
        $user = User::constructById($_SESSION["user"]);
        //check if password is set      
        if (isset($post["password"])) {
            //check if password is valid
            if ($user->getPassword() === crypt($post["password"], $user->getPassword())) {
                //if new password matches
                if (isset($post["newPassword"]) && $post["newPassword"] === $post["confirmPassword"]) {
                    $password = crypt($post["newPassword"]);
                    $user->setPassword($password);
                    Model\User::updateUser($user);
                } else {
                    //new password does not match
                }
            } else {
                //password does not match
            }
        }
        ob_start();
        $url = 'http://sfsuswe.com/~nthanlee/index.php/PetBasket/contactUpdate';
        while (ob_get_status()) {
            ob_end_clean();
        }
        header("Location: $url");
    }

    /**
     * Fetch the userId and username of the poster of a pet and return a JSON formatted string with this data
     * @return string   in JSON format
     */
    public static function getPosterInfo() {
        $get = Core\Input::get();
        if (isset($get['petId'])) {
            $pet = Pet::constructById($get['petId']);
            $userId = $pet->getUserId();
            $user = User::constructById($userId);
            $userName = $user->getUsername();
            return json_encode(array('userId' => $userId, 'userName' => $userName));
        }
        return '{}';
    }

    /**
     * Creates a new message in the db
     * @return 1 is message created successfully, 0 otherwise
     */
    public static function sendMessage() {
        $post = Core\Input::post();
        if (isset($post['senderId']) && isset($post['recipientId']) && isset($post['petId']) && isset($post['message'])) {
            $messageObj = new Message($post['senderId'], $post['recipientId'], 'new', $post['message'], time(), time(), 1, 1);
            $res = Model\Message::createMesage($messageObj);
            return $res;
        }
    }

    // update a user's contact email 
    public static function updateEmail(){
        $error = array('status' => 0, 'msg' => '');
        $post = Core\Input::post();
        if(isset($post['email']) && isset($_SESSION["user"])){
            $user = User::constructById($_SESSION["user"]);
            if($user !== null){
                $user->getEmail();
                $user->update();
            } else {
                $error['status'] = 1;
                $error['msg'] = "User not found: " . $_SESSION["user"];
            }
        } else {
            $error['status'] = 1;
            $error['msg'] = "User not logged in";
        }
        ob_start();
        require VIEWS_PATH . '/contactUpdate.php';
        return ob_get_clean();        
    }

    public static function _404($passedToView = array()) {
        ob_start();
        require VIEWS_PATH . '/404.php';
        return ob_get_clean();
    }
}
