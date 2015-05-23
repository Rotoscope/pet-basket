<?php

class Image {

    private $id;
    public $name;
    public $description;
    private $fileName;
    private $fileType;
    private $fileSize;
    private $width;
    private $height;
    private $thumbnails;
    private $petId;
    private $created;
    private $updated;

    /**
     * Construct and Image object
     * @param string $name          deprecated -> moved into Pet class
     * @param string $description   deprecated -> moved into Pet class
     * @param string $fileName      name of the original file
     * @param string $fileType      type of the original file
     * @param int $fileSize         size of the original file in bytes
     * @param int $width            with of the original file  in pixels
     * @param int $height           height of the original file in pixels
     * @param string $thumbnails    json obj containing metadata for thumbnails created from original image
     * @param string $petId         the Pet this image belongs to           
     */
    public function __construct($name, $description, $fileName, $fileType, $fileSize, $width, $height, $thumbnails, $petId) {
        $this->setName($name);
        $this->setDescription($description);
        $this->setFileName($fileName);
        $this->setFileType($fileType);
        $this->setFileSize($fileSize);
        $this->setWidth($width);
        $this->setHeight($height);
        $this->setThumbnails($thumbnails);
        $this->setPetId($petId);
        $this->setCreated(time());
        $this->setUpdated(time());
    }

    /**
     * Create a new Image record in the database
     * @return int  row id of newly created image row 
     */
    public function save() {
        return Model\Image::createImage($this);
    }

    /**
     * Instantiate an Image from an image table id
     * @param int $imageId  id of image to create an Image instance from  
     * @return \Image
     */
    public static function constructById($imageId) {
        $row = Model\Image::getImageById($imageId);
        if (isset($row['id'])) {
            $image = self::constructByRow($row);
            $image->setId($row['id']);
            return $image;
        }
        return null;
    }

    /**
     * Instantiate an Image from and image table row
     * @param array $row   row from image table
     * @return \Image
     */
    public static function constructByRow($row) {
        if (isset($row['id'])) {
            $image = new Image(
                    $row['name'], $row['description'], $row['file_name'], $row['file_type'], $row['file_size'], $row['width'], $row['height'], $row['thumbnails'], $row['pet_id']
            );
            $image->setId($row['id']);
            return $image;
        }
        return null;
    }

    public function getId() {
        return $this->id;
    }

    protected function setId($var) {
        $this->id = $var;
    }

    public function getFileName() {
        return $this->fileName;
    }

    protected function setFileName($var) {
        $this->fileName = $var;
    }

    public function getFileType() {
        return $this->fileType;
    }

    protected function setFileType($var) {
        $this->fileType = $var;
    }

    public function getFileSize() {
        return $this->fileSize;
    }

    protected function setFileSize($var) {
        $this->fileSize = $var;
    }

    public function getWidth() {
        return $this->width;
    }

    private function setWidth($var) {
        $this->width = $var;
    }

    public function getHeight() {
        return $this->height;
    }

    private function setHeight($var) {
        $this->height = $var;
    }

    public function getThumbnails() {
        return $this->thumbnails;
    }

    private function setThumbnails($var) {
        $this->thumbnails = json_decode($var);
    }

    private function setPetId($var) {
        $this->petId = $var;
    }

    public function getPetId() {
        return $this->petId;
    }

    public function getCreated() {
        return $this->created;
    }

    private function setCreated($var) {
        $this->created = $var;
    }

    public function getUpdated() {
        return $this->updated;
    }

    private function setUpdated($var) {
        $this->updated = $var;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($var) {
        $this->name = $var;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($var) {
        $this->description = $var;
    }

    public function __toString() {
        $id = '"id":' . $this->getId();
        $name = '"name":"' . $this->getName() . '"';
        $description = '"description":"' . $this->getDescription() . '"';
        $fileName = '"fileName":"' . $this->getFileName() . '"';
        $fileType = '"fileType":"' . $this->getFileType() . '"';
        $fileSize = '"fileSize":' . $this->getFileSize();
        $width = '"width":' . $this->getWidth();
        $height = '"height":' . $this->getHeight();
//        var_dump($this->getThumbnails());
//        exit;
        $thumbnails = '"thumbnails":' . json_encode($this->getThumbnails());
        $petId = '"petId":"' . $this->getPetId() . '"';
        $created = '"created":' . $this->getCreated();
        $updated = '"updated":' . $this->getUpdated();
        $items = array();
        $items[] = $id;
        $items[] = $name;
        $items[] = $description;
        $items[] = $fileName;
        $items[] = $fileType;
        $items[] = $fileSize;
        $items[] = $width;
        $items[] = $height;
        $items[] = $thumbnails;
        $items[] = $petId;
        $items[] = $created;
        $items[] = $updated;
        return "{" . implode(',', $items) . "}";
    }

}
