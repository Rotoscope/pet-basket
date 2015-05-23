CREATE TABLE IF NOT EXISTS `user` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `username` varchar(30) CHARACTER SET utf16 NOT NULL,
 `password` varchar(500) NOT NULL,
 `email` varchar(50) NOT NULL,
 `created` bigint(20) NOT NULL,
 `updated` bigint(20) NOT NULL,
 `is_admin` TINYINT(1) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=ascii
