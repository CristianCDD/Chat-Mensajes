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

if (!empty($_FILES['file_upload']['name'])) {
    $file_name = $_FILES['file_upload']['name'];
    $file_tmp = $_FILES['file_upload']['tmp_name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $allowed_ext = ['doc', 'docx'];

    if (in_array($file_ext, $allowed_ext)) {
        $new_file_name = time() . '_' . $file_name;
        $upload_dir = 'uploads/';

        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        if (move_uploaded_file($file_tmp, $upload_dir . $new_file_name)) {
            $sql = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, type) 
                    VALUES ({$incoming_id}, {$outgoing_id}, '{$new_file_name}', 'file')";
            mysqli_query($conn, $sql);
        }
    } else {
        echo "Tipo de archivo no permitido";
    }
} else if(!empty($message)) {
    // Mensaje de texto normal cifrado
    $message_encrypted = cesar_encrypt($message);
    $sql = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, type) 
            VALUES ({$incoming_id}, {$outgoing_id}, '{$message_encrypted}', 'text')";
    mysqli_query($conn, $sql);
}

?>

