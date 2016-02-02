<?php
include '../includes/config.inc.php';
// connect database 
$database = new Database();
$database->openConnection();

$menu_item = mysql_real_escape_string($_REQUEST['menu_item']);
$menu_item_cate = mysql_real_escape_string($_REQUEST['menu_item_cate']);
$menu_item_price = mysql_real_escape_string($_REQUEST['menu_item_price']);
$menu_item_status = mysql_real_escape_string($_REQUEST['menu_item_status']);
if ($database->executeStatement_numrow("SELECT * FROM `menu` WHERE `menu_name` = '$menu_item' LIMIT 1 ") > 0) {
    echo "Menu is duplicate!";
    die();
} 

if (isset($_FILES['myfile'])) {
    $sFileName = $_FILES['myfile']['name'];
    $sFileType = $_FILES['myfile']['type'];
    $tempFile = $_FILES['myfile']['tmp_name'];
    $allowed_mime = array(
        'image/jpeg' => 'jpg',
        'image/pjpeg' => 'jpg',
        'image/gif' => 'gif',
        'image/png' => 'png',
    );

    if (in_array(findexts($sFileName), $allowed_mime)) {

        $filename = md5(uniqid()) . '.' . findexts($sFileName);
        $filename2 = "small_" . $filename;
        $pathname = "../img_product/" . $filename;
        $pathname2 = "../img_product/" . $filename2;
        
        if (move_uploaded_file($tempFile, $pathname)) {
            $size = GetimageSize($pathname);
            $width = 120;
            $height = round($width * $size[1] / $size[0]);
            if (findexts($sFileName) == "jpg") {
                $images_orig = ImageCreateFromJPEG($pathname);
                $photoX = ImagesX($images_orig);
                $photoY = ImagesY($images_orig);
                $images_fin = ImageCreateTrueColor($width, $height);
                ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width, $height, $photoX, $photoY);
                ImageJPEG($images_fin, $pathname2);
            }
            if (findexts($sFileName) == "png") {
                $images_orig = imagecreatefrompng($pathname);
                $photoX = ImagesX($images_orig);
                $photoY = ImagesY($images_orig);
                $images_fin = ImageCreateTrueColor($width, $height);
                imagealphablending($images_fin, false);
                imagesavealpha($images_fin, true);
                $transparent = imagecolorallocatealpha($images_fin, 255, 255, 255, 127);
                imagefilledrectangle($images_fin, 0, 0, $width, $height, $transparent);
                ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width, $height, $photoX, $photoY);
                imagepng($images_fin, $pathname2);
            }
            if (findexts($sFileName) == "gif") {
                $images_orig = imagecreatefromgif($pathname);
                $photoX = ImagesX($images_orig);
                $photoY = ImagesY($images_orig);
                $images_fin = ImageCreateTrueColor($width, $height);
                ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width, $height, $photoX, $photoY);
                imagegif($images_fin, $pathname2);
            }

            ImageDestroy($images_orig);
            ImageDestroy($images_fin);
            unlink($pathname);
            $database->executeStatement("INSERT INTO menu VALUES('','$menu_item_cate','$menu_item','$menu_item_price','$filename2','$menu_item_status')");
            echo <<<EOF

 {OK}

EOF;
        }
    } else {
        echo 'Not ext';
    }
} else {
     $database->executeStatement("INSERT INTO menu VALUES('','$menu_item_cate','$menu_item','$menu_item_price','$filename2','$menu_item_status')");
    echo 'OK';
}

function findexts($filename) {
    $filename = strtolower($filename);
    $exts = split("[/\\.]", $filename);
    $n = count($exts) - 1;
    $exts = $exts[$n];
    return $exts;
}

?>