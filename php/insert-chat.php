<?php
session_start();

if (!isset($_SESSION['unique_id'])) {
    header("Location: ../login.php");
    exit();
}

include_once "config.php";
include_once "cesar.php"; // Incluimos las funciones de cifrado/descifrado

$outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
$incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
$message     = mysqli_real_escape_string($conn, $_POST['message']);

if (!empty($message)) {
    $message_encrypted = cesar_encrypt($message); // Ciframos el mensaje

    $sql = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg) 
            VALUES ({$incoming_id}, {$outgoing_id}, '{$message_encrypted}')";

    if (!mysqli_query($conn, $sql)) {
        die("Error al insertar mensaje: " . mysqli_error($conn));
    }
}
?>

