<?php

session_start();
include_once "config.php";

$outgoing_id = $_SESSION['unique_id'];
$sql = mysqli_query($conn, "SELECT * FROM users where not unique_id = {$outgoing_id}");
$output = "";

if(mysqli_num_rows($sql) == 1 ){
    $output = "No hay usuarios disponibles para chatear";
}else if(mysqli_num_rows($sql) > 0){
    include "data.php";
}

echo $output;

?>