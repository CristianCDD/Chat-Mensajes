<?php
    session_start();

    include_once "config.php";
    $outgoing_id = $_SESSION['unique_id'];
    $searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);

    $output = "";

    $sql = mysqli_query($conn, "SELECT * FROM users where not unique_id = {$outgoing_id}  and ( fname LIKE '%{$searchTerm}%' OR lname like '%{$searchTerm}%')");

    if(mysqli_num_rows($sql) > 0){
       include("data.php");
    }else{
        $output .= "No se encontro ningun usuario";

    }

    echo $output;

    
?>