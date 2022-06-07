<?php
$dsn = "mysql:host=localhost;dbname=iteh2lb1var2";
$user = 'root';
$pass = 'pass';
try{
    $dbh = new PDO($dsn,$user,$pass);
    //print('Connected to database');
}
catch(PDOException $ex){
    echo $ex->GetMessage();
}
//$dbh = null;
?>