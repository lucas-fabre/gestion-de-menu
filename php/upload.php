<?php
// This file is used to upload pictures in html form. It contains some restricitions like formats and size.

class Image
{
    public function __construct()
    {
        // "$this" permit to get the assign variable and use it somewhere else in the class 
        // (have to use "$this" where you want to get it).
        $this->con = new PDO('mysql:host=localhost;dbname=gestion-menu', 'root', '');
    }

    // The function to call in Index.php for uploading the picture and put it in a folder to stor it.
    // It's not working properly because i didn't understand the "target_file" part.
    // The "uploadOK" is used to check each restriction and ensure the file is clean for upload (SQL injection, virus...)
    public function addimage($image1)
    {
        // Specify the folder to store uploaded pictures.
        $target_dir = "./uploads/";
        // I supposed it the part where I must specify the file to transfer into the specific folder.
        // The "basename" variables is the part I don't understand. I don't know what to put in there.
        $target_file = $target_dir.basename([$image1]["name"]);
        $uploadOk = 1;
        // Get the type of the uploaded file (.png, .jpg, .jpeg...) in lowercase.
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


        // Check if image file is a actual image or fake image.
        // The "isset($_POST["btn_add_pic"])" is used to confirm data's html form by clicking on the button "btn_add". 
        if(isset($_POST["btn_add"])) 
        {
            $check = getimagesize($_FILES[$image1]["tmp_name"]);
            // Add slashes between words to prevent SQL injections.
            $imgContent = addslashes(file_get_contents($image1));
            if($check !== false) 
            {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } 
            else 
            {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }

        // Check file size.
        if($_FILES[$image1]["size"] > 500000) 
        {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats.
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif")
        {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error.
        if($uploadOk == 0) 
        {
            echo "Sorry, your file was not uploaded.";
        }
        
        // if everything is ok, try to upload file.
        elseif($uploadOk == 1) 
        {
            // "$this" used to get the variable defined at the beginning of the class.
            // "prapare" is used to protect SQL command from manual modification (SQL injection).
            $insert = $this->con->prepare("INSERT INTO carte (image) VALUES ($imgContent) WHERE image = $image1");
            $insert->execute();
            if($insert)
            {
                echo "File uploaded successfully.";
            }
            else
            {
                echo "File upload failed, please try again.";
            }
        }
    }
}
?>