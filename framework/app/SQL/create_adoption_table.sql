CREATE TABLE IF NOT EXISTS `adoption` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `user_id_adopter` varchar(11) NOT NULL,
 `user_id_poster` varchar(11) NOT NULL,
 `pet_id` varchar(11) NOT NULL,
 `created` bigint(20) NOT NULL,
 `updated` bigint(20) NOT NULL,
 `visibility` enum('y','n'),
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=ascii