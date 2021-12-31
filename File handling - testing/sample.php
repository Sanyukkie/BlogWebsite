<?php 
//file handling 
//1. file_exists()function: to check if file exists
echo "<h2>Checking if file exists or not</h2>";
if (file_exists("filehandling_lect.php")) {
    echo "file exists";
}
else {
    echo "file does not exist ";
}
echo "<hr><h2>Creating a file </h2>";
//2. Creating a file 
// Step 1: Use fopen function to open a file
// Step 2: Use functions like: fwrite to write, fread or fgets to read
// Step 3: Close the file
$newfile = fopen('file1.txt', 'w') or die ("Failed to create file");
$txt = "Hello World\n";
fwrite($newfile, $txt);
//to write more lines
$txt = "This is my first file";
fwrite($newfile, $txt);
fclose($newfile);
echo "<hr><h2>Reading from a file </h2>";
 //3. Reading from a file - fread()
 // https://www.php.net/manual/en/function.fread.php

 $filename = "file1.txt";
 $handle = fopen($filename, "r");
 $contents = fread($handle, filesize($filename));
 echo $contents;
 fclose($handle);

 // example fread 
 echo "<hr><h2> To read the defined number of characters from the file</h2>";
 $fh = fopen('file11.txt', 'r') or die ("Failed to read file");
 $text = fread($fh, 20);
 fclose($fh);
 echo $text;

echo "<hr><h2>Reading from a remote file </h2>";
// fread reading from a remote file
/*
$handle = fopen("https://yle.fi/uutiset/osasto/news/", "rb");
if (FALSE === $handle) {
    exit("Failed to open stream to URL");
}
$contents = stream_get_contents($handle);
echo $contents;
fclose($handle);
 */
 //4. Copying a file : copy() function
copy('file11.txt', 'file11cp.txt')
 or die ("Could not copy file");
 echo "file copied successfully";

//5. rename() - to rename or move a file or directory
if(rename('file11cpp.txt','folder1/newfile.txt')){
    echo "file renamed successfully";
}
else {echo "could not rename file";}

//6. Deleting a file - unlink()
if (unlink('folder1/filename.txt'))
{
    echo "file deleted successfully";
}
else {echo "Unable to delete file";}

/*7.  flock(): 
When many users try to write the same file, it can become corruputed.
Also when one user is writing a file and the other reading it, the person reading it can get odd results
To handle simultaneous users, flock() function can be used
Flock() function queues up all other requests to access a file until your program releases the lock.
*/

//open the file r+ for both reading & writing
$file = fopen('file99.txt', 'r+') or die('failed to open file');
//fgets to read the single line in your file
$text = fgets($file);
//flock to set file lock using LOCK_EX parameter
if (flock($file, LOCK_EX)){
    ftruncate($file, 0); //truncate a file
    fwrite($file,"some text to add ") or die ("COuld not write");
    fflush($file); //flush ouput before releasing the lock
    flock($file, LOCK_UN);// to release the lock with LOCK_UN
}
else
{echo "file updated successfully";}
fclose($file);

echo "<hr><h2>Reading an entire file</h2>";
//8. Reading an entire file: file_get_contents
echo file_get_contents('file99.txt');
// echo file_get_contents('https://yle.fi/uutiset/osasto/news/')

//9. Uploading Files :https://www.php.net/manual/en/features.file-upload.php
// Step 1: Create a form to upload file
?>
<hr><h2>Simple File Upload System </h2>
<form enctype="multipart/form-data" action="upload.php" method="POST">
    <!-- MAX_FILE_SIZE must precede the file input field -->
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    <!-- Name of input element determines name in $_FILES array -->
    Send this file: <input name="userfile" type="file" />
    <input type="submit" value="Send File" />
</form>
<hr><h2>PHP Date function </h2>
<?php 
// Date() - formatting local time or date
// https://www.php.net/manual/en/function.date.php

// Prints something like: Monday
echo date("l") . "<br>";

// Prints something like: Monday 8th of August 2005 03:12:46 PM
echo date('l jS \of F Y h:i:s A') . "<br>";

//auto update copyright year
echo "&copy" . date("Y");
//date format example
echo "Today is " . date("Y-m-d") . "<br>";

//to get time
echo "The current time is " . date("h:i:sa");

// set the default timezone to use. Available since PHP 5.1
date_default_timezone_set('Europe/Helsinki');
// timezones php : https://www.php.net/manual/en/timezones.europe.php
?>

