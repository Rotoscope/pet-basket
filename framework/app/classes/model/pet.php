<?php

namespace Model;

class Pet {

    public static function createPet($petObj) {
        $name = \Core\Db::escape($petObj->getName());
        $description = \Core\Db::escape($petObj->getDescription());
        $specialNeeds = \Core\Db::escape($petObj->getSpecialNeeds());
        $weight = \Core\Db::escape($petObj->getWeight());
        $species = \Core\Db::escape($petObj->getSpecies());
        $breed = \Core\Db::escape($petObj->getBreed());
        $age = $petObj->getAge();
        $sex = \Core\Db::escape($petObj->getSex());
        $userId = \Core\Db::escape($petObj->getUserId());
        $adoptionId = \Core\Db::escape($petObj->getAdoptionId());
        $created = $petObj->getCreated();
        $updated = $petObj->getUpdated();
        $visibility = $petObj->getVisibility();
        $approved = $petObj->getApproved();
        $sql = <<< q
INSERT INTO `pet`(
`id`, 
`name`,
`description`,
`special_needs`,
`weight`, 
`species`,
`breed`,
`age`,
`sex`,                
`user_id`,
`adoption_id`,
`created`,
`updated`,
`visibility`,
`approved` 
) 
VALUES (
DEFAULT,
'$name',
'$description',
'$specialNeeds',
$weight,
'$species',
'$breed',
$age,
'$sex',
'$userId',
'$adoptionId',
$created,
$updated,
'$visibility',
$approved
);
q;
        //var_dump($sql);
        //exit;
        $res = \Core\Db::execute($sql);
        return ($res === false) ? false : \Core\Db::insertId();
    }

    public static function getPetById($petId) {
        return \Core\Db::execute("SELECT * FROM pet WHERE `id`=$petId;");
    }

    public static function getPetByName($petName) {
        $cleanPetName = \Core\Db::escape($petName);
        $sql = "SELECT * FROM pet WHERE `name`='$cleanPetName';";
        $res = \Core\Db::execute($sql);
        return $res;
    }

    public static function getPetByUserId($userId) {
        $sql = "SELECT * FROM pet WHERE `user_id`='$userId';";
        $res = \Core\Db::execute($sql);
        return $res;
    }

    /*
     * Select pet rows with configurable WHERE
     * @var $whereOptions  an array of WHERE statement query constraints  
     * ex.  array(" sex='male' ", " breed="mutt");  
     */

    public static function getPetByWhere($whereString) {

        $sql = "SELECT * FROM `pet` " . $whereString . ";";
        $res = \Core\Db::execute($sql);
        //var_dump($sql);
        //exit;
        return $res;
    }

    public static function updatePet($petObj) {
        $id = \Core\Db::escape($petObj->getId());
        $name = \Core\Db::escape($petObj->getName());
        $description = \Core\Db::escape($petObj->getDescription());
        $specialNeeds = \Core\Db::escape($petObj->getSpecialNeeds());
        $weight = \Core\Db::escape($petObj->getWeight());
        $species = \Core\Db::escape($petObj->getSpecies());
        $breed = \Core\Db::escape($petObj->getBreed());
        $age = \Core\Db::escape($petObj->getAge());
        $sex = \Core\Db::escape($petObj->getSex());
        $userId = \Core\Db::escape($petObj->getUserId());
        $adoptionId = \Core\Db::escape($petObj->getAdoptionId());
        $created = $petObj->getCreated();
        $updated = time();
        $visibility = $petObj->getVisibility();
        $approved = $petObj->getApproved();
        $sql = <<< q
UPDATE `pet` SET
`name` = '$name',
`description` = '$description',
`special_needs` = '$specialNeeds',
`weight` = $weight, 
`species` = '$species',
`breed` = '$breed',
`age` = $age,
`sex` = '$sex',                
`user_id` = '$userId',
`adoption_id` = '$adoptionId',
`created` = $created,
`updated` = $updated,
`visibility` = '$visibility',
`approved` = $approved
WHERE `id` = $id;
q;
        //var_dump($sql);
        //exit;
        $res = \Core\Db::execute($sql);
        return ($res === false) ? false : true;
    }

    public static function destroyPet($petId) {
        
    }

    //test
    public static function getAllPets() {
        $sql = "SELECT * from pet";
        $res = \Core\Db::execute($sql);

//        var_dump($res);
//        exit;

        return $res;
    }

    public static function getPetByApproved($petApprove) {
        //$cleanPetName = \Core\Db::escape($petName);
        $sql = "SELECT * FROM pet WHERE `approved`='$petApprove';";
        $res = \Core\Db::execute($sql);
        return $res;
    }

}
