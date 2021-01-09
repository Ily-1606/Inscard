<?php
function curl($url){
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET"
));

$response = curl_exec($curl);
curl_close($curl);
return $response;
}
function get_info($url){
$response = curl($url);
$picture = explode('"',explode('"display_resources":[{"src":"',$response)[1])[0];
$picture = str_replace("\u0026","&",$picture);
$ss = explode('","blocked_by_viewer":',$response)[0];
$count = count(explode('"username":"',$ss));
$username = explode('"username":"',$ss)[$count - 1];
$data = [];
$data["url_picture"] = $picture;
$data["username"] = $username;
$res = curl("https://www.instagram.com/$username/");
$data["follows"] = explode('},"',explode('"edge_followed_by":{"count":',$res)[1])[0];
$data["follow_for"] = explode('},"',explode('"edge_follow":{"count":',$res)[1])[0];
$data["feed_count"] = explode(',"',explode('edge_owner_to_timeline_media":{"count":',$res)[1])[0];
$data["name"] = explode('"',explode('"full_name":"',$res)[1])[0];
$data["shortcode"] = explode('"',explode('"shortcode":"',$response)[1])[0];
$avatar = explode('"',explode('"profile_pic_url_hd":"',$res)[1])[0];
$avatar = str_replace("\u0026","&",$avatar);
$data["avatar"] = $avatar;
    return $data;
}
//$str = "\ud835\udcb1\ud835\udcb6\ud835\udcc3 \ud835\udc9c\ud835\udcc3\ud835\udcbd \ud835\udca9\ud835\udc54\ud835\udcca\ud835\udcce\ud835\udc52\ud835\udcc3 \ud83c\udf39";
//echo json_decode('"'.$str.'"');

//echo json_encode(get_info("https://www.instagram.com/p/B-CLJ6-gRF-/"));
