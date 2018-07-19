<?php

if (isset($_POST['submit'])) {
	$filename = $_FILES["file"]["name"];
    $file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
    $file_ext = substr($filename, strripos($filename, '.')); // get file name
    $filesize = $_FILES["file"]["size"];

    $filename_360 = $_FILES["fileToUpload"]["name"];
    $file_basename_360 = substr($filename_360, 0, strripos($filename_360, '.')); // get file extention
    $file_ext_360 = substr($filename_360, strripos($filename_360, '.')); // get file name
    $filesize_360 = $_FILES["fileToUpload"]["size"];

    $allowed_file_types = array('gif','.jpeg','.jpg','.png');

	$pointname = $_POST['pointname'];
	$building = $_POST['building'];
	$floor = $_POST['floor'];
	$x = $_POST['x'];
	$y = $_POST['y'];
	$class = "Miscellaneous";
	$description = $_POST['description'];
	$image = [];
	$caption = [];
	$panorama = "";

 if (in_array($file_ext,$allowed_file_types) && ($filesize < 40000000)) {
 	 $newfilename = md5($file_basename) . $file_ext;
 	 move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/" . $newfilename);

 	 $image = "./uploads/" . $newfilename;
 	 $caption = $_POST['caption'];
 	 file_put_contents("manifest.appcache", "\nuploads/" . $newfilename, FILE_APPEND);
 }

 if (in_array($file_ext_360,$allowed_file_types) && ($filesize_360 < 40000000)) {
 	$newfilename_360 = md5($file_basename_360) . $file_ext_360;
 	move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "uploads/" . $newfilename_360);

 	$panorama = "./uploads/" . $newfilename_360;
 	file_put_contents("manifest.appcache", "\nuploads/" . $newfilename_360, FILE_APPEND);
 }
	echo "Successfully added " . $pointname . " at " . $building . "!";
	echo "<br><a href='addpoi.html'>Go back</a>";

	$data = file_get_contents("poi-v6.json");
    $json_arr = json_decode($data, true);

    $newPoint['pointname'] = $pointname;
    $newPoint['building'] = $building;
    $newPoint['floor'] = $floor;
    $newPoint['x'] = $x;
    $newPoint['y'] = $y;
    $newPoint['class'] = $class;
	$newPoint['description'] = $description;
    $newPoint['image'] = [$image];
    $newPoint['imageinfo'] = [$caption];
    $newPoint['panorama'] = $panorama;

    array_push($json_arr['Points'], $newPoint);

    $newJSONPoint = json_encode($json_arr, JSON_PRETTY_PRINT);
    file_put_contents("poi-v6.json", $newJSONPoint);
}

?>