<?php

class Pet {

    private $id;
    private $userId;
    private $adoptionId;
    private $created;
    private $updated;
    public $name;
    public $description;
    public $specialNeeds;
    public $weight;
    public $species;
    public $breed;
    public $age;
    public $sex;
    public $visibility;
    public $images;
    public $approved;

    /**
     * Create a Pet object
     * @param string   $name             name of the this pet
     * @param string   $description      description of this pet     
     * @param string   $specialNeeds     description of special needs of this pet
     * @param int      $weight           weight of this pet
     * @param string   $species          the species of this pet
     * @param string   $breed            the breed of this pet
     * @param int      $age              the age of this pet
     * @param string   $sex              the sex of this pet
     * @param string   $userId           the id of the user who posted this pet in user:userRowId format 
     * @param string   $adoptionId       the id of the adoption record of this pet in adoption:adoptionRowId format
     * @param string   $visibility        enum  'y' or 'n'
     */
    public function __construct($name, $description, $specialNeeds, $weight, $species, $breed, $age, $sex, $userId, $adoptionId, $created, $updated, $visibility, $approved) {
        $this->setName($name);
        $this->setDescription($description);
        $this->setSpecialNeeds($specialNeeds);
        $this->setWeight($weight);
        $this->setSpecies($species);
        $this->setBreed($breed);
        $this->setAge($age);
        $this->setSex($sex);
        $this->setUserId($userId);
        $this->setAdoptionId($adoptionId);
        $this->setCreated($created);
        $this->setUpdated($updated);
        $this->setVisibility($visibility);
        $this->setApproved($approved);
    }

    /**
     * Create a new Pet record in the database
     * @return int  row id of newly created row 
     */
    public function save() {
        return Model\Pet::createPet($this);
    }

    /**
     * Update this Pet in the database
     * @return type mixed   false on failure, integer of newly created row otherwise
     */
    public function update() {
        return Model\Pet::updatePet($this);
    }

    /**
     * Instantiate a Pet from an image table id
     * @param int $petId  id of pet row to create a Pet instance from  
     * @return \Pet
     */
    public static function constructById($petId) {
        $row = Model\Pet::getPetById($petId);
        $row = isset($row[0]) ? $row[0] : $row;
        if (isset($row['id'])) {
            $pet = self::constructByRow($row);
            $pet->setId($row['id']);
            return $pet;
        }
        return null;
    }

    /**
     * Instantiate a Pet from a pet table row
     * @param array $row   a row of the Pet table
     * @return \Pet
     */
    public static function constructByRow($row) {
        if (isset($row['id'])) {
            $pet = new Pet(
                    $row['name'], $row['description'], $row['special_needs'], $row['weight'], $row['species'], $row['breed'], $row['age'], $row['sex'], $row['user_id'], $row['adoption_id'], $row['created'], $row['updated'], $row['visibility'], $row['approved']
            );
            $pet->setId($row['id']);
            return $pet;
        }
        return null;
    }

    /**
     * Create an array of Images associated with this Pet instance
     * @throws Exception
     */
    public function loadImages() {
        $petId = 'pet:' . $this->id;
        $res = Model\Image::getImagesByPetId($petId);
        if ($res === false) {  // log errors
            $msg = Core\Db::getErrorMessage();
            error_log("\n" . date('Y-m-d H:i:s', time()) . ": " . $msg, 3, LOG_PATH . '/mysql_error_log');
            throw new Exception($msg);
        }
        $this->images = array();
        foreach ($res as $imageRow) {
            $this->images[] = Image::constructByRow($imageRow);
        }
    }

    public function getImages() {
        return $this->images;
    }

    /**
     * Creates a JSON representation of the list of Images associated with this pet
     * @return string    JSON array of Image JSON objects
     */
    public function getImagesAsJsonString() {
        $strings = array();
        $images = $this->getImages();
        if (is_array($images)) {
            foreach ($images as $image) {
                $strings[] = $image->__toString();
            }
        }
        return '[' . implode(',', $strings) . ']';
    }

    public function setImages($images) {
        $this->images = $images;
    }

    public function getId() {
        return $this->id;
    }

    protected function setId($var) {
        $this->id = $var;
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

    public function getSpecialNeeds() {
        return $this->specialNeeds;
    }

    public function setSpecialNeeds($var) {
        $this->specialNeeds = $var;
    }

    public function getWeight() {
        return $this->weight;
    }

    public function setWeight($var) {
        $this->weight = $var;
    }

    public function getSpecies() {
        return $this->species;
    }

    public function setSpecies($var) {
        $this->species = $var;
    }

    public function getBreed() {
        return $this->breed;
    }

    public function setBreed($var) {
        $this->breed = $var;
    }

    public function getAge() {
        return $this->age;
    }

    public function setAge($var) {
        $this->age = $var;
    }

    public function getSex() {
        return $this->sex;
    }

    public function setSex($var) {
        $this->sex = $var;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($var) {
        $this->userId = $var;
    }

    public function getAdoptionId() {
        return $this->adoptionId;
    }

    public function setAdoptionId($var) {
        $this->adoptionId = $var;
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

    public function getVisibility() {
        return $this->visibility;
    }

    public function setVisibility($var) {
        $this->visibility = $var;
    }

    public function getApproved() {
        return $this->approved;
    }

    public function setApproved($var) {
        $this->approved = $var;
    }

    /**
     * Create a JSON representation of this Pet instance
     * @return string    JSON formatted object
     */
    public function __toString() {
        $id = '"id":' . $this->getId();
        $user_id = '"userId":"' . $this->getUserId() . '"';
        $adoption_id = '"adoptionId":"' . $this->getAdoptionId() . '"';
        $created = '"created":' . $this->getCreated();
        $updated = '"updated":' . $this->getUpdated();
        $name = '"name":' . json_encode(trim($this->getName())) . '';
        $description = '"description":' . json_encode(trim($this->getDescription())) . '';
        $specialNeeds = '"specialNeeds":' . json_encode(trim($this->getSpecialNeeds())) . '';
        $weight = '"weight":' . json_encode(trim($this->getWeight()));
        $species = '"species":"' . trim($this->getSpecies()) . '"';
        $breed = '"breed":"' . trim($this->getBreed()) . '"';
        $age = '"age":' . json_encode(trim($this->getAge()));
        $sex = '"sex":"' . trim($this->getSex()) . '"';
        $visibility = '"visibility":"' . $this->getVisibility() . '"';
        $images = '"images":' . $this->getImagesAsJsonString();
        $approved = '"approved":' . $this->getApproved();
        $items = array();
        $items[] = $id;
        $items[] = $user_id;
        $items[] = $adoption_id;
        $items[] = $created;
        $items[] = $updated;
        $items[] = $name;
        $items[] = $description;
        $items[] = $specialNeeds;
        $items[] = $weight;
        $items[] = $species;
        $items[] = $breed;
        $items[] = $age;
        $items[] = $sex;
        $items[] = $visibility;
        $items[] = $images;
        $items[] = $approved;
        return "{" . implode(',', $items) . "}";
    }

}
