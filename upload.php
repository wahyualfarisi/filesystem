<?php 
    //upload.php 

    if($_FILES['upload_file']['name'] != '')
    {
        $data         = explode(".", $_FILES['upload_file']['name']);
        $extension    = $data[1];
        $allowed_ext  = array("jpg","png","gif");

        // if(in_array($extension, $allowed_ext) )
        // {

        // }
        print_r($data);

    }else 
    {
        echo "Please Select File";
    }


?>