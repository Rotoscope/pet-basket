CREATE TABLE `message` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `sender_id` varchar(30) CHARACTER SET utf16 NOT NULL,
 `recipient_id` varchar(30) CHARACTER SET utf16 NOT NULL,
 `thread_id` int(11) NOT NULL,
 `message`  varchar(8000) CHARACTER SET utf16 NOT NULL,
 `created` bigint(20) NOT NULL,
 `updated` bigint(20) NOT NULL,
 `visibility` enum('y', 'n'),
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16

 