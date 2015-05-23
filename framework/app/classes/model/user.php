<?php

namespace Model;

/**
 * User model class
 */
class User {

    /**
     * Create a new user in the database
     * @param type $userObj  an instance of the class User
     * @return type mixed    false if insert fails, integer of newly created row otherwise
     */
    public static function createUser($userObj) {
        $username = \Core\Db::escape($userObj->getUsername());
        $password = \Core\Db::escape($userObj->getPassword());
        $email = \Core\Db::escape($userObj->getEmail());
        $created = time();
        $updated = time();
        $isAdmin = $userObj->getIsAdmin();
        $lastLogin = \Core\Db::escape($userObj->getLastLogin());
        $sql = <<< q
INSERT INTO `user`(
`id`, 
`username`,
`password`,
`email`,
`created`, 
`updated`,
`is_admin`,
`last_login`) 
VALUES (
DEFAULT,
'$username',
'$password',
'$email',
$created,
$updated,
$isAdmin,
DEFAULT);
q;
        $res = \Core\Db::execute($sql);
        return ($res === false) ? false : \Core\Db::insertId(); // returns id of newly created row       
    }

    /**
     * Update the data of an existing user
     * @param type $userObj  an instance of the User class
     * @return type boolean  false if update fails, true otherwise
     */
    public static function updateUser($userObj) {
        $id = $userObj->getId();
        $username = \Core\Db::escape($userObj->getUsername());
        $password = \Core\Db::escape($userObj->getPassword());
        $email = \Core\Db::escape($userObj->getEmail());
        $created = $userObj->getCreated();
        $updated = time();
        $isAdmin = $userObj->getIsAdmin();
        $lastLogin = \Core\Db::escape($userObj->getLastLogin());
        $sql = <<< q
UPDATE `user` SET
`username` = '$username',
`password` = '$password',
`email` = '$email',
`created` = $created, 
`updated` = $updated,
`is_admin` = $isAdmin,
`last_login` = '$lastLogin'
WHERE `id` = $id;
q;
        $res = \Core\Db::execute($sql);
        return ($res === false) ? false : true;
    }

    /**
     * Select a row from the user table by row id
     * @param type $userId  integer of row to select from the user table
     * @return type  mixed  false on failure, array of results otherwise - see http://php.net/manual/en/mysqli.query.php
     * @throws Exception     
     */
    public static function getUserById($userId) {
        $userId = \Core\Db::escape($userId);
        return \Core\Db::execute("SELECT * FROM `user` WHERE `id`=$userId;");
    }

    /**
     * Select a row from the user table by email
     * @param type $userEmail   email to select on
     * @return type  mixed      false on failure, array of results otherwise - see http://php.net/manual/en/mysqli.query.php
     * @throws Exception     
     */
    public static function getUserByEmail($userEmail) {
        $userEmail = \Core\Db::escape($userEmail);
        return \Core\Db::execute("SELECT * FROM `user` WHERE `email`='$userEmail';");
    }

    /**
     * Select a row from the user table by username
     * @param type $userName   email to select on
     * @return type  mixed      false on failure, array of results otherwise - see http://php.net/manual/en/mysqli.query.php
     * @throws Exception     
     */
    public static function getUserByUsername($userName) {
        $userName = \Core\Db::escape($userName);
        return \Core\Db::execute("SELECT * FROM `user` WHERE `username`='$userName';");
    }

    /**
     * Remove a row from the user table
     * @param type $userId  id of row to remove
     */
    public static function deleteUser($userId) {
        
    }

}
