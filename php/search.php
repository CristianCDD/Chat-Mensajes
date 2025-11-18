<?php
session_start();

if(!isset($_SESSION['unique_id'])){
    header("Location: ../login.php");
    exit();
}

include_once "config.php";

$outgoing_id = $_SESSION['unique_id'];
$searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);
$output = "";

// Buscar usuarios que no sean el actual y coincidan con nombre o apellido
$sql = mysqli_query($conn, "SELECT * FROM users 
                            WHERE unique_id != {$outgoing_id} 
                              AND (fname LIKE '%{$searchTerm}%' OR lname LIKE '%{$searchTerm}%')");

if(mysqli_num_rows($sql) > 0){
    include("data.php"); // Se espera que aquí se genere $output
} else {
    $output = "No se encontró ningún usuario con ese nombre.";
}

echo $output;
?>
