<?php

namespace Model;

class Adoption {

    public static function createAdoption($adoptionObj) {
        $user_id_adopter = \Core\Db::escape($adoptionObj->getUserIdAdopter());
        $user_id_poster = \Core\Db::escape($adoptionObj->getUserIdPoster());
        $pet_id = \Core\Db::escape($adoptionObj->getPetId());
        $created = $adoptionObj->getCreated();
        $updated = $adoptionObj->getUpdated();
        $visibility = $adoptionObj->getVisibility();
        $sql = <<< q
INSERT INTO `adoption`(
`id`,
`user_id_adopter`, 
`user_id_poster`,
`pet_id`,
`created`,
`updated`,
`visibility`) 
VALUES (
DEFAULT,
'$user_id_adopter',
'$user_id_poster',
'$pet_id',
$created,
$updated,
'$visibility');
q;

        $res = \Core\Db::execute($sql);
        return ($res === false) ? false : \Core\Db::insertId();
    }

}
