<?php

if (isset($_POST['submit'])) {
    $data = file_get_contents("poi-v6.json");
    $json_arr = json_decode($data, true);

    foreach($json_arr["Points"] as $key => $value) {
        if(in_array($_POST['poi'], $value)) {
            unset($json_arr["Points"][$key]);
        }
    }

    echo "Succesfully removed " . $_POST['poi'] . " from the map.";
    echo "<br><a href='removepoi.html'>Go back.</a>";
			
	$newJsonString = json_encode($json_arr, JSON_PRETTY_PRINT);
    file_put_contents("poi-v6.json", $newJsonString);
}

?>