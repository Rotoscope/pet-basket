<?php

/**
 * Basket class - the PHP class representation of the PetBasket feature
 */
class Basket {

    public $userId;
    public $pets;

    /**
     * Construct a Basket instance
     * @param string $userId  id of user this basket belongs to
     * @param array $pets     an array of Pet objects   
     */
    public function __construct($userId, $pets) {
        $this->setUserId($userId);
        $this->setPets($pets);
    }

    /**
     * Create a Basket instance given a user's id
     * @param mixed $userId
     * @return \Basket
     */
    public function constructByUserId($userId) {
        $basketRows = Model\Basket::selectBasketByUserId($userId);
        $pets = array();
        if (is_array($basketRows)) {
            foreach ($basketRows as $i => $row) {
                $parts = explode(':', $row['pet_id']);
                if (isset($parts[1])) {
                    $pet = Pet::constructById($parts[1]);
                    $pet->loadImages();
                    $pets[] = $pet;
                }
            }
        }
        return new Basket($userId, $pets);
    }

    /**
     * Adds a Pet to this PetBasket
     * @param type $petId
     * @return type
     */
    public function addPet($petId) {
        return Model\Basket::insert($this->getUserId(), $petId);
    }

    /**
     * Removes a Pet from this PetBasket
     * @param type $petId
     * @return type
     */
    public function removePet($petId) {
        return Model\Basket::remove($this->getUserId(), $petId);
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($var) {
        $this->userId = $var;
    }

    public function getPets() {
        return $this->pets;
    }

    /**
     * Creates a JSON representation of the list of Pets in this Basket
     * @return string    JSON array of Pet JSON objects
     */
    public function getPetsAsJsonString() {
        $strings = array();
        $pets = $this->getPets();
        if (is_array($pets)) {
            foreach ($pets as $pet) {
                $pet = $pet->__toString();
                $strings[] = $pet;
            }
        }
        return '[' . implode(',', $strings) . ']';
    }

    public function setPets($var) {
        $this->pets = $var;
    }

    /**
     * Create a JSON representation of a Basket instance
     * @return string    JSON formatted object
     */
    public function __toString() {
        $userId = '"user":' . $this->getUserId();
        $pets = '"pets":' . $this->getPetsAsJsonString();
        $items = array();
        $items[] = $userId;
        $items[] = $pets;
        return "{" . implode(',', $items) . "}";
    }

}
