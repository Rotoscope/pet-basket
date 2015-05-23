<?php

//TODO
class Adoption {

    private $id;
    private $user_id_adopter;
    private $user_id_poster;
    private $pet_id;
    private $created;
    private $updated;
    public $visibility;

    /**
     * Create a Adoption object
     * @param string $user_id_adopter
     * @param string $user_id_poster      
     * @param string pet_id
     * @param string $visibility        enum  'y' or 'n'
     */
    public function __construct($user_id_adopter, $user_id_poster, $pet_id, $visibility) {
        $this->setUserIdAdopter($user_id_adopter);
        $this->setUserIdPoster($user_id_poster);
        $this->setPetId($pet_id);
        $this->setCreated(time());
        $this->setUpdated(time());
        $this->setVisibility($visibility);
    }

    public function save() {
        return Model\Adoption::createAdoption($this);
    }

    public function getUserIdAdopter() {
        return $this->user_id_adopter;
    }

    public function setUserIdAdopter($user_id_adopter) {
        $this->user_id_adopter = $user_id_adopter;
    }

    public function getUserIdPoster() {
        return $this->user_id_poster;
    }

    public function setUserIdPoster($user_id_poster) {
        $this->user_id_poster = $user_id_poster;
    }

    public function getPetId() {
        return $this->pet_id;
    }

    public function setPetId($pet_id) {
        $this->pet_id = $pet_id;
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

}
