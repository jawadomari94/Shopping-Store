<?php

// if(!isset($_SERVER['HTTP_REFERER'])){
//     header('location: http://localhost/Freshcery/index.php');
//     exit;
// }

try{
define("HOST", "localhost");
define("DBNAME", "freshcery");
define('USERNAME', 'root');
define('PASSWORD', '');

$conn = new PDO("mysql:host=".HOST.";dbname=".DBNAME.";charset=utf8",USERNAME,PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

// if($conn == true){
//     echo "connected";
// }else{
//     echo "failed";
// }
}catch(PDOException $e){
    echo "failed".$e->getMessage();

}
