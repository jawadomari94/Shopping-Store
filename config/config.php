<?php

// if(!isset($_SERVER['HTTP_REFERER'])){
//     header('location: http://localhost/Freshcery/index.php');
//     exit;
// }

try{

 
if(!defined('HOST'))  define("HOST", "localhost");

if(!defined('DBNAME')) define("DBNAME", "freshcery");
 
if(!defined('USERNAME')) define("USERNAME", "root"); 
 
if(!defined('PASSWORD')) define("PASSWORD", "");

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
