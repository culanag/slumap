<?php

// Upload and Rename File

if (isset($_POST['submit']))
{
    $filename = $_FILES["fileToUpload"]["name"];
    $file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
    $file_ext = substr($filename, strripos($filename, '.')); // get file name
    $filesize = $_FILES["fileToUpload"]["size"];
    $allowed_file_types = array('.doc','.docx','.rtf','.pdf','.jpg','.png');  
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
            move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "uploads/" . $newfilename);
            echo "File uploaded successfully.";    
            $poi = $_POST['poi']; 	
				
			foreach($json_arr["Points"] as &$value) {
				if ($value['pointname'] == $poi) {
					
					$value['panorama'] = "./uploads/" . $newfilename;
					
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
    } 
    elseif ($filesize > 40000000)
    {   
        // file size error
        echo "The file you are trying to upload is too large.";
    }
    else
    {
        // file type error
        echo "Only these file typs are allowed for upload: " . implode(', ',$allowed_file_types);
        unlink($_FILES["fileToUpload"]["tmp_name"]);
    }
}

?>