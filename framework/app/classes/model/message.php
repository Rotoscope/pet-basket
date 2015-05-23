<?php

namespace Model;

/**
 * Message model class
 * This model provides CRUD operations for the Message class
 */
class Message {

    public static function createMesage($messageObj) {
        $senderId = \Core\Db::escape($messageObj->getSenderId());
        $recipientId = \Core\Db::escape($messageObj->getRecipientId());
        $threadId = ($messageObj->getThreadId() === 'new') ? 
            self::getNextThread() :
            \Core\Db::escape($messageObj->getThreadId());
        if($threadId === null)
            throw new Exception("Error, no next thread id returned from db query");
        $message = \Core\Db::escape($messageObj->getMessage());
        $created = time();
        $updated = time();
        $senderVisibility = $messageObj->getSenderVisibility();
        $recipientVisibility = $messageObj->getRecipientVisibility();
        $sql = <<< q
INSERT INTO `message`(
`id`, 
`sender_id`,
`recipient_id`,
`thread_id`,
`message`,
`created`, 
`updated`,
`sender_visibility`,
`recipient_visibility`
) VALUES (
DEFAULT,
$senderId,
$recipientId,
$threadId,
'$message',
$created,
$updated,
$senderVisibility,
$recipientVisibility);
q;
        //var_dump($sql);
        //exit;
        $res = \Core\Db::execute($sql);
        return ($res === false) ? false : \Core\Db::insertId();
    }

    public static function getMessageById($messageId) {
        return \Core\Db::execute("SELECT * FROM message WHERE `id`=$messageId;");
    }

    public static function getMessagesBySenderId($senderId) {
        $sql = "SELECT * FROM message WHERE `sender_id`='$senderId' AND `sender_id` != `recipient_id`;";
        $res = \Core\Db::execute($sql);
        return $res;
    }

    public static function getMessagesByRecipientId($recipientId) {
        $sql = "SELECT * FROM message WHERE `recipient_id`='$recipientId' AND `sender_id` != `recipient_id`;";
        $res = \Core\Db::execute($sql);
        return $res;
    }

    public static function getMessagesByThreadId($threadId) {
        $sql = "SELECT * FROM message WHERE `thread_id`='$threadId' AND `sender_id` != `recipient_id`;";
        $res = \Core\Db::execute($sql);
        return $res;
    }

    /*
     * Select message rows with configurable WHERE
     * @var $whereOptions  an array of WHERE statement query constraints  
     * ex.  array(" sex='male' ", " breed="mutt");  
     */

    public static function getMessageByWhere($whereString) {
        $sql = "SELECT * FROM `message` " . $whereString . ";";
        $res = \Core\Db::execute($sql);
        //var_dump($sql);
        //exit;
        return $res;
    }

    public static function updateMessage($messageObj) {
        $id = $messageObj->getId();
        $message = \Core\Db::escape($messageObj->getMessage());
        $updated = time();
        $senderVisibility = $messageObj->getSenderVisibility();
        $recipientVisibility = $messageObj->getRecipientVisibility();
        $sql = <<< q
UPDATE `message` SET
`message` = '$message',
`updated` = $updated,
`sender_visibility` = $senderVisibility,
`recipient_visibility` = $recipientVisibility
WHERE `id` = $id;
q;
        //var_dump($sql);
        //exit;
        $res = \Core\Db::execute($sql);
        return ($res === false) ? false : true;
    }

    public static function getAllMessages() {
        $sql = "SELECT * from message WHERE `sender_id` != `recipient_id`";
        $res = \Core\Db::execute($sql);
        return $res;
    }

    public static function getNextThread() {
        $sql = "SELECT MAX(thread_id) FROM message;";
        $res = \Core\Db::execute($sql);
        return isset($res[0]['MAX(thread_id)']) ? $res[0]['MAX(thread_id)']+1 : null;
    }

}
