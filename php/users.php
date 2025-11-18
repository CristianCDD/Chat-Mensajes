<?php
session_start();

if(!isset($_SESSION['unique_id'])){
    header("Location: ../login.php");
    exit();
}

include_once "config.php";

$outgoing_id = $_SESSION['unique_id'];
$output = "";

$sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id != {$outgoing_id}");

if(mysqli_num_rows($sql) > 0){
    include "data.php"; // Se espera que $output se genere aquí
} else {
    $output = "No hay usuarios disponibles para chatear";
}

echo $output;
?>
