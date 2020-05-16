<?php
include ('./config.php');

function Countfile()
{
    $directory = "/xampp/htdocs/test/uploads/";
$filecount = 0;
$files = glob($directory . "*");
if ($files){
 $filecount = count($files);
}
echo $filecount;
}

if ($_GET) {
        if ($_GET['key']) {
            $key = $_GET['key'];
            if ($key == $passkey) {
                echo Countfile();
            }else {
                echo 'Key ไม่ถูกต้อง';
            }
        }else{
            header("Refresh:0; url=index.php");
        }
    }
?>