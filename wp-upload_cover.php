<?php
/**
 * WordPress User Page
 *
 * Handles authentication, registering, resetting passwords, forgot password,
 * and other user handling.
 *
 * @package WordPress
 */

/** Make sure that the WordPress bootstrap has run before continuing. */
require(dirname(__FILE__) . '/wp-load.php');

if (isset($_FILES["upload"])) {
    $name = $_FILES["upload"]["name"];
    $upload_dir = wp_upload_dir();
    $extention = explode(".", $_FILES['upload']['name']);
    $ext = $extention[count($extention) - 1];

    $link = $upload_dir['basedir'] . "/CoverPage/" . $_POST['uid'] . ".jpg";
    $link = str_replace("\\", "/", $link);
    if( file_exists( $link ))
    {
        unlink($link);
    }

    $valid_exts = array('jpeg', 'jpg', 'png', 'gif');
    $max_file_size = 2000 * 1024; #200kb
    $nw = 1700;
    $nh = 500; # image with & height

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_FILES['upload'])) {
            if (!$_FILES['upload']['error'] && $_FILES['upload']['size'] < $max_file_size ) {
                # get file extension
                $ext = strtolower(pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION));
                # file type validity
                if (in_array($ext, $valid_exts)) {
                    $path = $link;
                    $size = getimagesize($_FILES['upload']['tmp_name']);
                    # grab data form post request
                    $x = (int)$_POST['x'];
                    $y = (int)$_POST['y'];
                    $w = (int)$_POST['w'] ? $_POST['w'] : $size[0];
                    $h = (int)$_POST['h'] ? $_POST['h'] : $size[1];
                    $original_width = (int)$_POST['original_width'];
                    $original_height = (int)$_POST['original_height'];
                    # read image binary data
                    $data = file_get_contents($_FILES['upload']['tmp_name']);
                    # create v image form binary data
                    $vImg = imagecreatefromstring($data);

                    //$dstImg = imagecreatetruecolor($newImage['crop']['width'], $newImage['crop']['height']);

                    //imagecopyresampled($dst_img, $src_img, 0, 0, $newImage['crop']['x'], $newImage['crop']['y'], 0, 0, $width, $height);
                    $dstImg = imagecreatetruecolor( $w , $h );
                    # copy image
                    imagecopyresampled($dstImg, $vImg, 0  , 0 , $x, $y, $w , $h  , $w, $h);
                    # save image
                     imagejpeg($dstImg, $path);
                 //    move_uploaded_file($dstImg, $link);
                    echo site_url() . "/wp-content/uploads/CoverPage/" . $_POST['uid'] . ".jpg";
                    # clean memory
                    imagedestroy($dstImg);

                } else {
                    echo 'unknown problem!';
                }
            } else {
                echo 'file is too small or large';
            }
        } else {
            echo 'file not set';
        }
    } else {
        echo 'bad request!';
    }


}

exit();
?>
 
