<?php  include('../config.php'); ?> 
<?php include('public_functions.php');?>
<?php 
//when we click the button

$userid = $_SESSION["user"]["id"];

if (isset($_POST['submitedit'])){
   
    $errorlist = [];
    $fname = $_POST['edit-name'];
    $email = $_POST['edit-email'];
    $phone = $_POST['edit-phone'];
    $city = $_POST['edit-city'];
    $gender = $_POST['edit-gender'];
    $about = $_POST['edit-aboutme'];
    $file = $_FILES['file'];

    // variables for file properties
    $fileName = $_FILES['file']['name'];
    //the temporary names displays a full path to temporary location
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];


    // if profile picture wasnt changed

    if ($file['size'] == 0){
        // Checking if email is free to take
        $user_check_query = "SELECT * FROM users WHERE email='$email' and id != $userid LIMIT 1";
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);
        
        // checking if other variables are empty
        if (empty($fname)) {array_push($errorlist, "Name can not be empty");}
        if (empty($email)){ array_push($errorlist, "Email can not be empty");}
        if ($user['email'] === $email) { array_push($errorlist, "Email already exists");}

        // Updating profile if there is no errors
        if (empty($errorlist)){
        $query = "UPDATE users set fname = '$fname', email = '$email', city = '$city', phone = '$phone',  gender = '$gender', about = '$about' WHERE id = '$userid' LIMIT 1";
        mysqli_query($conn, $query);
        $_SESSION['user'] = userById($userid);
          //to go back to the front page after we are done and display success message
        header("Location: profile.php?editsuccess");
        }
    }
 
    // If profile picture was changed
    if($file['size'] > 0) {

        // ALLOWING ONLY SPECIFIC TYPE OF FILE

        // exploding a users file name to return an array of name and extention
        $fileExt = explode('.', $fileName);
        
        // changing the extention to lower case in case user has it saved with caps
        $fileActualExt = strtolower(end($fileExt));

        // creating an array of allowed file extentions
        $allowed = array('jpg', 'jpeg', 'png');

        // checking if the file is correct and its allowed to upload if the $fileActualExt is in the allowed array
        // checking if the file is correct and if its not allowed pushes the error to error list
        if (!in_array($fileActualExt, $allowed)){array_push($errorlist, "Wrong file type");}

        // checking if there was no error while uploading then...
        if (!empty($fileError)){array_push($errorlist, "There was an error uploading your file");}

        // checking if the file has a correct size
        if ($fileSize > 1000000){array_push($errorlist, "Your file was too big");}  

        // Checking if email is free to take
        $user_check_query = "SELECT * FROM users WHERE email='$email' and id != $userid LIMIT 1";
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);
        
        // checking if other variables are empty
        if (empty($fname)) {array_push($errorlist, "Name can not be empty");}
        if (empty($email)){ array_push($errorlist, "Email can not be empty");}
        if ($user['email'] === $email) { array_push($errorlist, "Email already exists");}

        if (empty($errorlist)){
            // Giving an uploaded file a unique name - it returns a value of the timeformat down to mikroseconds
            $fileNameNew = uniqid('',true).".".$fileActualExt;

            //destination where to upload a file
            $fileDestination ='static/profile_img/'.$fileNameNew;

            //creating a function that will move the file from temp location to the folder

            move_uploaded_file($fileTmpName, $fileDestination);
            // Uploading all the data into a database
            $query = "UPDATE users set fname = '$fname', email = '$email', city = '$city', phone = '$phone',  gender = '$gender', profile_pic = '$fileNameNew', about = '$about' WHERE id = '$userid' LIMIT 1";
            mysqli_query($conn, $query);
            $_SESSION['user'] = userById($userid);
                //to go back to the front page after we are done and display success message
            header("Location: profile.php?uploadsuccess");
        
        }
                
    }
}
?>