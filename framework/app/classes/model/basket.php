<?php

namespace Model;

/**
 * Model Basket class 
 * Provided CRUD operations on the basket table for providing PetBasket functionality
 */
class Basket {

    /**
     * Create a basket
     * @param type $basketObj
     * @return type
     */
    public static function createBasket($basketObj) {
        $userId = \Core\Db::escape($basketObj->getUserId());
        $petId = \Core\Db::escape($basketObj->getPetId());
        $sql = <<< q
INSERT INTO `basket`(
`id`, 
`user_id`,
`pet_id`
) 
VALUES (
DEFAULT,
'$userId',
'$petId'
);
q;
        //echo "<br/><br/>" . $sql . "<br/><br/>";
        $res = \Core\Db::execute($sql);
        return ($res === false) ? false : \Core\Db::insertId();
    }

    /**
     * Update an item
     * @param type $basketObj
     * @return type
     */
    public static function updateBasket($basketObj) {
        $userId = \Core\Db::escape($basketObj->getUserId());
        $petId = \Core\Db::escape($basketObj->getPetId());
        $id = $basketObj->getId();
        $sql = <<< q
UPDATE `basket` SET
`user_id` = '$userId',
`pet_id` = '$petId'
WHERE `id` = $id;
q;
        //echo "<br/><br/>" . $sql . "<br/><br/>";
        $res = \Core\Db::execute($sql);
        return ($res === false) ? false : true;
    }

    /**
     * Select all items in a given user's basket
     * @param type $userId  
     * @return type
     */
    public static function selectBasketByUserId($userId) {
        $userId = \Core\Db::escape($userId);
        $sql = "SELECT * FROM `basket` WHERE `user_id`='user:$userId';";

        return \Core\Db::execute($sql);
    }

    /**
     * Add a pet to a user's PetBasket
     * @param mixed $userId
     * @param mixed $petId
     * @return type
     */
    public static function insert($userId, $petId) {
        $userId = \Core\Db::escape($userId);
        $petId = \Core\Db::escape($petId);
        $sql = "INSERT INTO `basket`(`id`, `user_id`, `pet_id`) VALUES (DEFAULT,'user:$userId','pet:$petId');";
        return \Core\Db::execute($sql);
    }

    /**
     * Remove a pet from a user's PetBasket
     * @param mixed $userId
     * @param mixed $petId
     * @return type
     */
    public static function remove($userId, $petId) {
        $userId = \Core\Db::escape($userId);
        $petId = \Core\Db::escape($petId);
        $sql = "DELETE FROM `basket` WHERE `user_id`='user:$userId' AND `pet_id`='pet:$petId';";
        return \Core\Db::execute($sql);
    }

}
