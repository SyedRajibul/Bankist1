<?php

$servername='localhost';
$username='root';
$password='';
$dbname='ssregister';
try{
  $db= new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
  
 

}catch(PDOException $ex){
  echo "Connection failed";
}

?>
