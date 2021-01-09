<?php

function crop_center($src_img, $max_width, $max_height, $bool = false, $zoom = false)
{
    $height = imagesy($src_img);
    $width = imagesx($src_img);
    $scale = null;
    if ($zoom) {
        if ($bool == true)
            if ($height < $width) $scale = $max_height / $height;
            else $scale = $max_width / $width;
        if($scale != null)
        $src_img = zoom($src_img, $scale);
        else
        $src_img = resize_imagejpeg($src_img, $max_width, $max_height);
    }
    $height = imagesy($src_img);
    $width = imagesx($src_img);
    $width = $width / 2 - $max_width / 2;
    $height = $height / 2 - $max_height / 2;
    $src_img = imagecrop($src_img, ['x' => $width, 'y' => $height, 'width' => $max_width, 'height' => $max_height]);
    return ($src_img);
}
function crop_center_card($src_img)
{
    $height = imagesy($src_img);
    $width = imagesx($src_img);
    if ($height < $width) $width = $height;
    else $height = $width;
    $src_img = resize_imagejpeg($src_img, $width, $height);
    return ($src_img);
}
function get_image_from_url($imageurl)
{
    $imageurl = urldecode($imageurl);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $imageurl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // good edit, thanks!
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1); // also, this seems wise considering output is image.
    $data = curl_exec($ch);
    curl_close($ch);
    $image = imagecreatefromstring($data);
    return $image;
}
function resize_imagejpeg($src, $w, $h)
{
    $width = imagesx($src);
    $height = imagesy($src);
    $dst = imagecreatetruecolor($w, $h);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $w, $h, $width, $height);
    return $dst;
}
function resizeCrop($src, $newwidth, $newheight)
{
    return imagescale($src, $newwidth, $newheight);
}
function zoom($imgin, $percent)
{
    $width = imagesx($imgin);
    $height = imagesy($imgin);
    $new_width = $width * $percent;
    // $new_width = 600;
    $new_height = $height * $percent;
    // $new_height = 900;

    // Resample
    $image_out = imagecreatetruecolor($new_width, $new_height);
    imagecopyresampled($image_out, $imgin, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    return $image_out;
}
function write_text($image, $size, $x, $y, $text, $bold = false, $icon = false)
{
    $color = imagecolorallocate($image, 255, 255, 255);
    // Set Path to Font File
    if ($bold == false)
        $font_path = dirname(__FILE__) . '/arial.ttf';
    else
        $font_path = dirname(__FILE__) . '/arial_b.ttf';
    if ($icon == true)
        $font_path = dirname(__FILE__) . '/font-awesome.ttf';
    // Set Text to Be Printed On Image
    $angle = 0;
    // Print Text On Image
    if ($x == "center") {
        list($left,, $right) = imageftbbox($size, $angle, $font_path, $text);
        $x = imagesx($image) / 2 - ($right - $left) / 2;
    }
    imagettftext($image, $size, $angle, $x, $y, $color, $font_path, $text);
    return $image;
}
function blurImage($srcimg, $blur)
{
    $blur = $blur * $blur;
    $blur = max(0, min(1, $blur));

    $srcw = imagesx($srcimg);
    $srch = imagesy($srcimg);

    $dstimg = imagecreatetruecolor($srcw, $srch);

    $f1a = $blur;
    $f1b = 1.0 - $blur;


    $cr = 0;
    $cg = 0;
    $cb = 0;
    $nr = 0;
    $ng = 0;
    $nb = 0;

    $rgb = imagecolorat($srcimg, 0, 0);
    $or = ($rgb >> 16) & 0xFF;
    $og = ($rgb >> 8) & 0xFF;
    $ob = ($rgb) & 0xFF;

    //-------------------------------------------------
    // first line is a special case
    //-------------------------------------------------
    $x = $srcw;
    $y = $srch - 1;
    while ($x--) {
        //horizontal blurren
        $rgb = imagecolorat($srcimg, $x, $y);
        $cr = ($rgb >> 16) & 0xFF;
        $cg = ($rgb >> 8) & 0xFF;
        $cb = ($rgb) & 0xFF;

        $nr = ($cr * $f1a) + ($or * $f1b);
        $ng = ($cg * $f1a) + ($og * $f1b);
        $nb = ($cb * $f1a) + ($ob * $f1b);

        $or = $nr;
        $og = $ng;
        $ob = $nb;

        imagesetpixel($dstimg, $x, $y, ($nr << 16) | ($ng << 8) | ($nb));
    }
    //-------------------------------------------------

    //-------------------------------------------------
    // now process the entire picture
    //-------------------------------------------------
    $y = $srch - 1;
    while ($y--) {

        $rgb = imagecolorat($srcimg, 0, $y);
        $or = ($rgb >> 16) & 0xFF;
        $og = ($rgb >> 8) & 0xFF;
        $ob = ($rgb) & 0xFF;

        $x = $srcw;
        while ($x--) {
            //horizontal
            $rgb = imagecolorat($srcimg, $x, $y);
            $cr = ($rgb >> 16) & 0xFF;
            $cg = ($rgb >> 8) & 0xFF;
            $cb = ($rgb) & 0xFF;

            $nr = ($cr * $f1a) + ($or * $f1b);
            $ng = ($cg * $f1a) + ($og * $f1b);
            $nb = ($cb * $f1a) + ($ob * $f1b);

            $or = $nr;
            $og = $ng;
            $ob = $nb;


            //vertical
            $rgb = imagecolorat($dstimg, $x, $y + 1);
            $vr = ($rgb >> 16) & 0xFF;
            $vg = ($rgb >> 8) & 0xFF;
            $vb = ($rgb) & 0xFF;

            $nr = ($nr * $f1a) + ($vr * $f1b);
            $ng = ($ng * $f1a) + ($vg * $f1b);
            $nb = ($nb * $f1a) + ($vb * $f1b);

            $vr = $nr;
            $vg = $ng;
            $vb = $nb;

            imagesetpixel($dstimg, $x, $y, ($nr << 16) | ($ng << 8) | ($nb));
        }
    }
    //-------------------------------------------------
    $opacity = 0.7;
    imagealphablending($dstimg, false); // imagesavealpha can only be used by doing this for some reason
    imagesavealpha($dstimg, true); // this one helps you keep the alpha. 
    $transparency = 1 - $opacity;
    imagefilter($dstimg, IMG_FILTER_COLORIZE, 0, 0, 0, 127 * $transparency);
    return $dstimg;
}
function rounded($im2, $source_width, $source_height, $_width, $_height)
{


    $corner_image = imagecreatetruecolor(
        $source_width,
        $source_height
    );
    $clear_colour = imagecolorallocate(
        $corner_image,
        255,
        0,
        255
    );

    imagefill($im2, 0, 0, $clear_colour);




    imagecolortransparent(
        $im2,
        $clear_colour
    );

    $mask = imagecreatetruecolor($source_width, $source_height);
    $black = imagecolorallocate($mask, 0, 0, 0);
    $magenta = imagecolorallocate($mask, 255, 0, 255);

    imagefill($mask, 0, 0, $magenta);

    imagefilledellipse(
        $mask,
        $source_width / 2,
        $source_height / 2,
        $_width,
        $_height,
        $black
    );
    imagecolortransparent($mask, $black);


    imagecopymerge(
        $im2,
        $mask,
        0,
        0,
        0,
        0,
        $source_width,
        $source_height,
        100
    );
    return $im2;
}
