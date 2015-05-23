<?php

namespace Model;

class Image {

    public static function createImage($imageObj) {
        $name = \Core\Db::escape($imageObj->getName());
        $fileName = \Core\Db::escape($imageObj->getFileName());
        $fileType = \Core\Db::escape($imageObj->getFileType());
        $fileSize = \Core\Db::escape($imageObj->getFileSize());
        $width = \Core\Db::escape($imageObj->getWidth());
        $height = \Core\Db::escape($imageObj->getHeight());
        $description = \Core\Db::escape($imageObj->getDescription());
        $thumbnails = \Core\Db::escape(json_encode($imageObj->getThumbnails()));
        $petId = $imageObj->getPetId();
        $created = $imageObj->getCreated();
        $updated = $imageObj->getUpdated();
        $sql = <<< q
INSERT INTO `image`(
`id`, 
`name`,
`file_name`, 
`file_type`, 
`file_size`, 
`width`, 
`height`, 
`description`, 
`thumbnails`,
`pet_id`,
`created`, 
`updated`
) 
VALUES (
DEFAULT,
'$name',
'$fileName',
'$fileType',
$fileSize,
$width,
$height,
'$description',
'$thumbnails',
'$petId',
$created,
$updated
);
q;
        $res = \Core\Db::execute($sql);
        return ($res === false) ? false : \Core\Db::insertId();
    }

    public static function getImageById($imageId) {
        return \Core\Db::execute("SELECT * FROM image WHERE `id`=$imageId;");
    }

    public static function getImageByName($imageName) {
        $cleanImageName = \Core\Db::escape($imageName);
        return \Core\Db::execute("SELECT `name` FROM image WHERE `name`='$cleanImageName';");
    }

    public static function getImageByFileName($imageFileName) {
        $cleanImageFileName = \Core\Db::escape($imageFileName);
        return \Core\Db::execute("SELECT `name` FROM image WHERE `file_name`='$cleanImageFileName';");
    }

    public static function getImagesByPetId($petId) {
        return \Core\Db::execute("SELECT * FROM image WHERE `pet_id`='$petId';");
    }

    public static function updateImage($imageId) {
        
    }

    public static function destroyImage($imageId) {
        
    }

}
