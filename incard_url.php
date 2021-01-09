<?php
if (isset($_POST["url"])) {
    if (!empty($_POST["url"])) {
        include_once("function.php");
        auto_creare_api("url");
        $source_width = 600;
        $source_height = 900;
        $final_img = imagecreatetruecolor(1200, 1200);
        imagealphablending($final_img, true);
        imagesavealpha($final_img, true);
        include_once("getinfo.php");
        $url = $_POST["url"];
        $im2 = get_image_from_url($url);
        $out = imagecreatetruecolor(1200, 1200);
        $jpeg = blurImage(resize_imagejpeg($im2, 1200, 1200), 0.37);
        $im2 = crop_center($im2, 900, 900);
        //$im2 = zoom($im2,1.2);
        $inside_card_w = 600 - ($source_width / 2);
        $inside_card_h = 600 -  ($source_height / 2);
        $filename = getdate()[0];
        //Create footer bar/

        imagecopy($final_img, $jpeg, 0, 0, 0, 1, 1200, 1200);
        imagecopy($final_img, rounded($im2, $source_width, $source_height, $source_width * 2, $source_height), $inside_card_w, $inside_card_h, 0, 0, $source_width, $source_height);
        $im2 = write_text($final_img, "18", 1000, 1185, "Coded by Ily1606", true);
        //header("Content-type: image/jpg");
        imagejpeg($final_img, "result/" . $filename . ".jpg");
        imagedestroy($final_img);
        $data = [];
        $data["status"] = "success";
        $data["data"] = "result/" . $filename . ".jpg?v=".getdate()[0];
    } else {
        $data = [];
        $data["status"] = "error";
        $data["msg"] = "Thiếu URL";
    }
} else {
    $data = [];
    $data["status"] = "error";
    $data["msg"] = "Thiếu URL";
}
header('Content-Type: application/json');
echo json_encode($data);
