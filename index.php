<?php 
//setup
$passkey = "123456"; //key api
$urlfile = 'http://localhost/test/uploads/'; //url ของ uploads
$directory = "/xampp/htdocs/test/uploads/"; //directory uploads
//-------------------------------------------



function Countfile($directory)
{
$filecount = 0;
$files = glob($directory . "*");
if ($files){
 $filecount = count($files);
}
echo $filecount;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ฝากไฟล์</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<div class="container mt-3">
    <div class="card">
        <div class="card-body">
    <form action="" method="post" enctype="multipart/form-data">
        <h2 class="">Upload File</h2>
        <input type="file" name="fileupload"><br>
        <strong>Note:</strong>
        <span class="badge badge-success">.jpg</span>
        <span class="badge badge-success">.jpeg</span>
        <span class="badge badge-success">.gif</span>
        <span class="badge badge-success">.png</span>
        <span class="badge badge-success">max size of 10 MB.</span>
        <span class="badge badge-success">ไฟล์ทั้งหมด <?php Countfile($directory) ?></span><br>
        <input type="submit" name="submit" value="Upload" class="btn btn-primary mt-3">
    </form>
    <?php
// Check if the form was submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if file was uploaded without errors
    if(isset($_FILES["fileupload"]) && $_FILES["fileupload"]["error"] == 0){
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", "JPG" => "image/jpeg", "PNG" => "image/png");
        $filename = $_FILES["fileupload"]["name"];
        $filetype = $_FILES["fileupload"]["type"];
        $filesize = $_FILES["fileupload"]["size"];
    
        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) die('<div class="alert alert-danger mt-3 mb-lg-2" role="alert">Error: Please select a valid file format. <strong>'.$_FILES["fileupload"]["type"].'</strong></div>');
    
        // Verify file size - 10MB maximum
        $maxsize = 10 * 1024 * 1024;
        if($filesize > $maxsize) die('<div class="alert alert-danger mt-3 mb-lg-2" role="alert">Error: File size is larger than the allowed limit.</div>');
    
        // Verify MYME type of the file
        if(in_array($filetype, $allowed)){
            // Check whether file exists before uploading it
            if(file_exists("uploads/" . $filename)){
                echo '<div class="alert alert-danger mt-3 mb-lg-2" role="alert">'.$filename.' | มีไฟล์อยู่แล้ว</div>';
            } else{
                move_uploaded_file($_FILES["fileupload"]["tmp_name"], "uploads/" . $filename);
                echo '<div class="alert alert-success mt-3 mb-lg-2" role="alert">Link <a href="uploads/'.$filename.'">'.$urlfile.$filename.'</a></div><br><img class="img-fluid" alt="Responsive image" src="uploads/'.$filename.'">';
            } 
        } else{
            echo "Error: There was a problem uploading your file. Please try again."; 
        }
    } else{
        echo '<div class="alert alert-danger mt-3 mb-lg-2" role="alert">Error</div>';
    }
}

if ($_GET) {
    if ($_GET['key']) {
        $key = $_GET['key'];
        if ($key == $passkey) {
            $folder_path = "uploads"; 
            $files = glob($folder_path.'/*');  
            foreach($files as $file) { 
            if(is_file($file))  
            unlink($file);  
            }
            echo '<div class="alert alert-success mt-3 mb-lg-2" role="alert">ลบข้อมูลเรียบร้อย.....</div>';
            fopen("uploads/index.php", "w");
            header("Refresh:1; url=index.php");
        }else {
            echo '<div class="alert alert-danger mt-3 mb-lg-2" role="alert">Error: Key ไม่ถูกต้อง | '.$key.'</div>';
        }
    }
}
?>
</div>
</div>
</div>
</body>
</html>