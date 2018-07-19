<?php

if (isset($_POST['submit'])) {
	$pointname = $_POST['pointname'];
	$building = $_POST['building'];
	$floor = $_POST['floor'];
	$x = $_POST['x'];
	$y = $_POST['y'];
	$description = $_POST['description'];
	$poi = $_POST['poi'];

	echo "Successfully edited " . $pointname . " at " . $building . "!";
	echo "<br><a href='editpoi.html'>Go back</a>";

	$data = file_get_contents("poi-v6.json");
    $json_arr = json_decode($data, true);
	
	foreach($json_arr["Points"] as &$value) {
		if ($value['pointname'] == $poi) {
			//echo $value['pointname'] == $poi;
			$value['pointname'] = $pointname;
			$value['building'] = $building;
			$value['floor'] = $floor;
			$value['x'] = $x;
			$value['y'] = $y;
			$value['description'] = $description;
		}
	}


    $newJSONPoint = json_encode($json_arr, JSON_PRETTY_PRINT);
    file_put_contents("poi-v6.json", $newJSONPoint);
}

?>