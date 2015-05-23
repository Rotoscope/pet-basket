<?php

class Message {

    private $id;
    private $senderId;
    private $recipientId;
    private $threadId;
    private $message;
    private $created;
    private $updated;
    private $senderVisibility;
    private $recipientVisibility;

    /**
     * Construct and Image object
     * @param string   $senderId        the ID of the registered user who created this message, in user:userRowIdformat
     * @param string   $recipientId     the ID of the register user who is to recieve this message, in user:userRowId format
     * @param int      $threadId        the id of the thread of messages this message belongs to
     * @param string   $message         message sent by sender
     * @param int      $created         the time this message was created
     * @param int      $updated          the time this message was last updated
     * @param bool     $visibility      boolean value that indicares if the message is vissible to teh recipient           
     */
    public function __construct($senderId, $recipientId, $threadId, $message, $created, $updated, $senderVisibility, $recipientVisibility) {
        $this->setSenderId($senderId);
        $this->setRecipientId($recipientId);
        $this->setThreadId($threadId);
        $this->setMessage($message);
        $this->setCreated($created);
        $this->setUpdated($updated);
        $this->setSenderVisibility($senderVisibility);
        $this->setRecipientVisibility($recipientVisibility);
    }

    /**
     * Create a new Message record in the database
     * @return int  row id of newly created message row 
     */
    public function save() {
        return Model\Message::createMesage($this);
    }

    /**
     * Update a new Message record in the database
     * @return int  row id of newly created message row 
     */
    public function update() {
        return Model\Message::updateMessage($this);
    }

    /**
     * Instantiate a Message from a message table id
     * @param int $messageId  id of image to create an message instance from  
     * @return \Message
     */
    public static function constructById($messageId) {
        $row = Model\Image::getImageById($imageId);
        if (isset($row['id'])) {
            $image = self::constructByRow($row);
            $image->setId($row['id']);
            return $image;
        }
        return null;
    }

    /**
     * Instantiate a Message from and message table row
     * @param array $row   row from message table
     * @return \Message
     */
    public static function constructByRow($row) {
        if (isset($row['id'])) {
            $message = new Message(
                    $row['sender_id'], $row['recipient_id'], $row['thread_id'], $row['message'], $row['created'], $row['updated'], $row['sender_visibility'], $row['recipient_visibility']
            );
            $message->setId($row['id']);
            return $message;
        }
        return null;
    }

    public function getId() {
        return $this->id;
    }

    protected function setId($var) {
        $this->id = $var;
    }

    public function getSenderId() {
        return $this->senderId;
    }

    protected function setSenderId($var) {
        $this->senderId = $var;
    }

    public function getRecipientId() {
        return $this->recipientId;
    }

    protected function setRecipientId($var) {
        $this->recipientId = $var;
    }

    public function getThreadId() {
        return $this->threadId;
    }

    public function setThreadId($var) {
        $this->threadId = $var;
    }

    private function setCreated($var) {
        $this->created = $var;
    }

    public function getCreated() {
        return $this->created;
    }

    private function setUpdated($var) {
        $this->updated = $var;
    }

    public function getUpdated() {
        return $this->updated;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setMessage($var) {
        $this->message = $var;
    }

    public function getSenderVisibility() {
        return $this->senderVisibility;
    }

    public function getRecipientVisibility() {
        return $this->recipientVisibility;
    }

    public function setSenderVisibility($var) {
        $this->senderVisibility = $var;
    }

    public function setRecipientVisibility($var) {
        $this->recipientVisibility = $var;
    }

}
