<?php

// Upload and Rename File

if (isset($_POST['submit']))
{
    $filename = $_FILES["file"]["name"];
    $file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
    $file_ext = substr($filename, strripos($filename, '.')); // get file name
    $filesize = $_FILES["file"]["size"];
    $allowed_file_types = array('gif','.jpeg','.jpg','.png');  
    $data = file_get_contents("poi-v6.json");
    $json_arr = json_decode($data, true);

    if (in_array($file_ext,$allowed_file_types) && ($filesize < 40000000))
    {   
        // Rename file
        $newfilename = md5($file_basename) . $file_ext;
        if (file_exists("uploads/" . $newfilename))
        {
            // file already exists error
            echo "You have already uploaded this file.";
        }
        else
        {       
            move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/" . $newfilename);
            echo "File uploaded successfully.";  
			echo "<br><a href='upload.html'>Upload another one.</a>";
            $poi = $_POST['poi']; 
			$caption = $_POST['caption'];		
				
			foreach($json_arr["Points"] as &$value) {
				if ($value['pointname'] == $poi) {
					if(in_array("", $value['image'])) {
						
						array_pop($value['image']);
						array_pop($value['imageinfo']);
						array_push($value['image'], "./uploads/" . $newfilename);					
						array_push($value['imageinfo'], $caption);	
						
					} else {
						
						array_push($value['image'], "./uploads/" . $newfilename);					
						array_push($value['imageinfo'], $caption);		
						
					}
					
					file_put_contents("manifest.appcache", "\nuploads/" . $newfilename, FILE_APPEND);
				}
			}
			
			$newJsonString = json_encode($json_arr, JSON_PRETTY_PRINT);
			file_put_contents("poi-v6.json", $newJsonString);
			
        }
    }
    elseif (empty($file_basename))
    {   
        // file selection error
        echo "Please select a file to upload.";
		echo "<br><a href='upload.html'>Go back.</a>";
    } 
    elseif ($filesize > 40000000)
    {   
        // file size error
        echo "The file you are trying to upload is too large.";
		echo "<br><a href='upload.html'>Try again.</a>";
    }
    else
    {
        // file type error
        echo "Only these file types are allowed for upload: " . implode(', ',$allowed_file_types);
        unlink($_FILES["file"]["tmp_name"]);
		echo "<br><a href='upload.html'>Try again.</a>";
    }
}

?>