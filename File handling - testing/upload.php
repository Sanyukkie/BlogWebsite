<?php 
//when we click the button
if (isset($_POST['submit'])){
    $file = $_FILES['file'];

    // variables for file properties
    $fileName = $_FILES['file']['name'];
     //the temporary names displays a full path to temporary location
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    // ALLOWING ONLY SPECIFIC TYPE OF FILE

    // exploding a users file name to return an array of name and extention
    $fileExt = explode('.', $fileName);
    
    // changing the extention to lower case in case user has it saved with caps
    $fileActualExt = strtolower(end($fileExt));

    // creating an array of allowed file extentions

    $allowed = array('jpg', 'jpeg', 'png');

    // checking if the file is correct and its allowed to upload if the $fileActualExt is in the allowed array

    if (in_array($fileActualExt, $allowed)){ 
        // checking if there was no error while uploading then...
        if ($fileError === 0){

            // checking if the file has a correct size
            if ($fileSize < 1000000){
                // Giving an uploaded file a unique name - it returns a value of the timeformat down to mikroseconds
                $fileNameNew = uniqid('',true).".".$fileActualExt;

                //destination where to upload a file
                $fileDestination ='uploads/'.$fileNameNew;

                //creating a function that will move the file from temp location to the folder

                move_uploaded_file($fileTmpName, $fileDestination);
                //to go back to the front page after we are done and display success message
                header("Location: fileupload.php?uploadsuccess");

            }
            // else to the file size if
            else {
                echo "Your file is too big!";
            }
        }
        // else to the if regarding error while uploading
        else {
            echo "There was an error uploading your file";
        }
    }

    else {
         echo "You cannot upload files of this type";

    }

}

?>