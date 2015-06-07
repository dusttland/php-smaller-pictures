<?php

$filename = $_GET['name'];

$file = 'img/' . $filename;
$pathToSave = 'thumbnails/';

if (makeThumbnail($file, $pathToSave.'1_300x200.png', 300, 200)) {
    makeThumbnail($file, $pathToSave.'1_200x200.png', 200, 200);
    makeThumbnail($file, $pathToSave.'1_100x100.png', 100, 100);
    makeThumbnail($file, $pathToSave.'1_550x220.png', 550, 220);
    header('Location: index.php');
} else {
    header('Location: index.php?error=error');
}





function makeThumbnail($file, $outPutFile, $thumbnailWidth, $thumbnailHeight)
{
    if (!file_exists($file)) return false;
    if (filesize($file) > 8000000) return false;
    if ($thumbnailWidth <= 0 || $thumbnailHeight <= 0) return false;

    $widthToHeightRatio = $thumbnailWidth / $thumbnailHeight;

    list($width, $height) = getimagesize($file);
    $what = getimagesize($file);

    $newWidth;
    $newHeight;

    if ($width > $height * $widthToHeightRatio) {
        $newHeight = $thumbnailHeight;
        $newWidth = $newHeight * ($width / $height);
    } else {
        $newWidth = $thumbnailWidth;
        $newHeight = $newWidth * ($height / $width);
    }

    $file_name = basename($file);
    //print "MIME ".$what['mime'];
    switch(strtolower($what['mime'])) {
        case 'image/png':
                $img = imagecreatefrompng($file);
            break;
        case 'image/jpeg':
                $img = imagecreatefromjpeg($file);
            break;
        case 'image/gif':
                $img = imagecreatefromgif($file);
            break;
        default:
                return false;
            die();
    }   

    $smallerImg = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($smallerImg, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    $startX = ($newWidth - $thumbnailWidth) / 2;
    $startY = ($newHeight - $thumbnailHeight) / 2;

    $thumbnail = imagecreatetruecolor($thumbnailWidth, $thumbnailHeight);
    imagecopy($thumbnail, $smallerImg, 0, 0, $startX, $startY, $newWidth, $newHeight);

    imagepng($thumbnail, $outPutFile, 9);
    imagedestroy($thumbnail);

    return true;
}

?>