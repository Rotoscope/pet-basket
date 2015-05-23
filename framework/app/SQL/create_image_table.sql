CREATE TABLE `image` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(500) CHARACTER SET utf16 NOT NULL,
 `file_name` varchar(500) NOT NULL,
 `file_type` varchar(50) NOT NULL,
 `file_size` bigint(20) NOT NULL,
 `width` int(11) NOT NULL,
 `height` int(11) NOT NULL,
 `description` varchar(500) DEFAULT NULL,
 `thumbnails` varchar(8000) DEFAULT NULL,
 `pet_id`  varchar(50) DEFAULT NULL,
 `created` bigint(20) NOT NULL,
 `updated` bigint(20) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=ascii
