<?php

//The Purpose of this class is to construct temporary threaded Messages
//They will be used only in the instance the the user is logged in 

class ThreadedMessage {
    private $senderId;
    private $senderName;
    private $threadId;
    private $message;

    /**
     * Construct and Image object
     * @param string   $senderId        the ID of the registered user who created this message, in user:userRowIdformat
     * @param string   $senderName        the user name of the registered user who created this message
     * @param int      $threadId        the id of the thread of messages this message belongs to
     * @param string   $message         message sent by sender
     * @param int      $created         the time this message was created
     */
    public function __construct($senderId, $recipientId, $threadId, $senderName, $message) {
        $this->setSenderId($senderId);
        $this->setRecipientId($recipientId);
        $this->setThreadId($threadId);
        $this->setMessage($message);
        $this->setSenderName($senderName);
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

    protected function setThreadId($var) {
        $this->threadId = $var;
    }

    public function getMessage() {
        return $this->message;
    }

    private function setMessage($var) {
        $this->message = $var;
    }

    public function getSenderName() {
        return $this->senderName;
    }

    private function setSenderName($var) {
        $this->senderName = $var;
    }

}
