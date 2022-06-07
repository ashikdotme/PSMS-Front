<?php 
$host = "localhost";
$db_name = "psms";
$user = "root";
$password = "";

date_default_timezone_set("Asia/Dhaka");
try{
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
}
catch(PDOException $m){
    echo "Connection failed: " . $m->getMessage();
}



// Count any Column Value from Students Table
function stRowCount($col,$val){
    global $pdo;
    $stm=$pdo->prepare("SELECT $col FROM students WHERE $col=?");
    $stm->execute(array($val));
    $count = $stm->rowCount();
    return $count;
}
