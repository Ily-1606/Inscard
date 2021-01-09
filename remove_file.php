<?php
if(isset($_GET["action"])){
if($_GET["action"] == "im_not_robot"){
$files = glob('result/*'); //get all file names
foreach($files as $file){
    if(is_file($file))
    unlink($file); //delete file
}
}
}
?>