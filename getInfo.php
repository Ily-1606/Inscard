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
  $id = explode("/p/",$url)[1];
  $id = str_replace("/",'',$id);
$response = json_decode(curl("https://www.instagram.com/graphql/query/?query_hash=2418469a2b4d9b47ae7bec08e3ec53ad&variables={%22shortcode%22:%22$id%22,%22child_comment_count%22:0,%22fetch_comment_count%22:0,%22parent_comment_count%22:0,%22has_threaded_comments%22:true}"),true);
$picture = $response["data"]["shortcode_media"]["display_url"];
$username = $response["data"]["shortcode_media"]["owner"]["username"];
$id = $response["data"]["shortcode_media"]["shortcode"];
$data = [];
$data["url_picture"] = $picture;
$data["username"] = $username;
$data["follows"] = $response["data"]["shortcode_media"]["owner"]["edge_followed_by"]["count"];
$data["feed_count"] = $response["data"]["shortcode_media"]["owner"]["edge_owner_to_timeline_media"]["count"];
$data["name"] = $response["data"]["shortcode_media"]["owner"]["full_name"];
$data["shortcode"] = $id;
$data["avatar"] = $response["data"]["shortcode_media"]["owner"]["profile_pic_url"];;
    return $data;
}
//echo json_encode(get_info("https://www.instagram.com/p/CJvGXKen8-y/"));
