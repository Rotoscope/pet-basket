CREATE TABLE `pet` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(500) CHARACTER SET utf16 NOT NULL,
 `description` varchar(500) DEFAULT NULL,
 `special_needs` varchar(500) DEFAULT NULL,
 `weight` float DEFAULT NULL,
 `species` varchar(500) NOT NULL,
 `breed` varchar(50) DEFAULT NULL,
 `age` float NOT NULL,
 `sex`  enum('male', 'female') NOT NULL,
 `user_id` varchar(30) NOT NULL,
 `adoption_id` varchar(30) DEFAULT NULL,
 `created` bigint(20) NOT NULL,
 `updated` bigint(20) NOT NULL,
 `visibility` enum('y','n'),
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=ascii

