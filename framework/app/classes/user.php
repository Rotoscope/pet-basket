<?php

class User {

    private $password;
    private $isAdmin;
    private $created;
    private $updated;
    public $id;
    public $username;
    public $email;
    public $lastLogin;

    /**
     * Creae a new instance of this User class
     * @param string $username
     * @param string $password
     * @param string $email
     * @param int $created         in unixtime
     * @param int $updated         in unixtime
     * @param int $isAdmin         1 user is admin, user is not admin otherwise
     * @param string $lastLogin    timestamp in Y-m-d H:i:s format
     */
    public function __construct($username, $password, $email, $created, $updated, $isAdmin, $lastLogin) {
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setEmail($email);
        $this->setCreated($created);
        $this->setUpdated($created);
        $this->setIsAdmin($isAdmin);
        $this->setLastLogin($lastLogin);
    }

    /**
     * Save this User to the database
     * @return type mixed   false on failure, integer of newly created row otherwise
     */
    public function save() {
        return Model\User::createUser($this);
    }

    /**
     * Update this User in the database
     * @return type mixed   false on failure, integer of newly created row otherwise
     */
    public function update() {
        return Model\User::updateUser($this);
    }

    /**
     * Create a User instance given an id from the user table 
     * @param type $userId     id of row in user table
     * @return User or null
     */
    public static function constructById($userId) {
        $row = Model\User::getUserById($userId);
        $row = isset($row[0]) ? $row[0] : $row;
        if (isset($row['id'])) {
            $user = self::constructByRow($row);
            $user->setId($row['id']);
            return $user;
        }
        return null;
    }

    /**
     * Create a User given a row from the user table
     * @param array $row  row from the user table
     * @return \User
     */
    public static function constructByRow($row) {
        if (isset($row['id'])) {
            $user = new User($row['username'], $row['password'], $row['email'], $row['created'], $row['updated'], $row['is_admin'], $row['last_login']);
            $user->setId($row['id']);
            return $user;
        }
        return null;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($var) {
        $this->id = $var;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($var) {
        $this->username = $var;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($var) {
        $this->password = $var;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($var) {
        $this->email = $var;
    }

    public function getCreated() {
        return $this->created;
    }

    public function setCreated($var) {
        $this->created = $var;
    }

    public function getUpdated() {
        return $this->updated;
    }

    public function setUpdated($var) {
        $this->updated = $var;
    }

    public function getIsAdmin() {
        return $this->isAdmin;
    }

    public function setIsAdmin($var) {
        $this->isAdmin = $var;
    }

    public function getLastLogin() {
        return $this->lastLogin;
    }

    public function setLastLogin($var) {
        $this->lastLogin = $var;
    }

}
