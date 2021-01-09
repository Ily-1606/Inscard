<?php
        include_once("function.php");
        //auto_creare_api("instagram");
        $source_height = 950;
        $source_width = $source_height / 1.618;
        $final_img = imagecreatetruecolor(1200, 1200);
        imagealphablending($final_img, true);
        imagesavealpha($final_img, true);
        include_once("getinfo.php");
        $url = "https://www.instagram.com/p/B9RnbiZHLo2/";
        $data = get_info($url);
        $filename = $data["shortcode"];
        $im2 = get_image_from_url($data["url_picture"]);
        $avatar = get_image_from_url($data["avatar"]);
        $out = imagecreatetruecolor(1200, 1200);
        $jpeg = crop_center($im2, 1200, 1200, true, true);
        $jpeg = blurImage($jpeg, 0.37);
        $im2 = crop_center_card($im2);
        $im2 = resize_imagejpeg($im2, 950,950);
        $im2 = crop_center($im2, $source_width, $source_height, false, false);
        //$im2 = zoom($im2,1.2);
        $inside_card_w = 600 - ($source_width / 2);
        $inside_card_h = 600 -  ($source_height / 2);
        $im2 = write_text($im2, "16", 50, 225, json_decode('"' . $data["name"] . '"'));
        $im2 = write_text($im2, "20", 180, 150, $data["feed_count"], true);
        $im2 = write_text($im2, "16", 180, 180, "Bài viết");
        $im2 = write_text($im2, "20", 280, 150, $data["follows"], true);
        $im2 = write_text($im2, "16", 280, 180, "Người theo dõi");
        $im2 = write_text($im2, "20", 450, 150, $data["follow_for"], true);
        $im2 = write_text($im2, "16", 450, 180, "Đang theo dõi");
        $im2 = write_text($im2, "25", $source_width - 70, 100, json_decode('"&#xf0c9;"'), true, true);
        $im2 = write_text($im2, "18", "center", 70, $data["username"], true);

        //Create footer bar/

        $im2 = write_text($im2, "35", 40, $source_height - 100, json_decode('"&#xf015;"'), true, true);
        $im2 = write_text($im2, "35", 160, $source_height - 100, json_decode('"&#xf002;"'), true, true);
        $im2 = write_text($im2, "35", 280, $source_height - 100, json_decode('"&#xf0fe;"'), true, true);
        $im2 = write_text($im2, "35", 400, $source_height - 100, json_decode('"&#xf004;"'), true, true);
        imagecopy($final_img, $jpeg, 0, 0, 0, 1, 1200, 1200);
        imagecopy($final_img, rounded($im2, $source_width, $source_height, $source_width * 2, $source_height), $inside_card_w, $inside_card_h, 0, 0, $source_width, $source_height);
        //Start avatar
        $avatar1 = resizeCrop($avatar, 100, 100);
        imagecopy($final_img, rounded($avatar1, 100, 100, 100, 100, "source"), $inside_card_w + 50, $inside_card_h + 100, 0, 1, 100, 100);
        $avatar2 = resizeCrop($avatar, 50, 50);
        imagecopy($final_img, rounded($avatar2, 50, 50, 50, 50, "source"), $inside_card_w + 520, $inside_card_h + 810, 0, 1, 50, 50);
        $im2 = write_text($final_img, "18", 1000, 1185, "Coded by Ily1606", true);
        header("Content-type: image/jpg");
        imagejpeg($final_img);
        imagedestroy($final_img);