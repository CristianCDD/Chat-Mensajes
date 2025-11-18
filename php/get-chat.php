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
$output = "";

// Consultamos los mensajes entre los dos usuarios
$sql = "SELECT * FROM messages 
        LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
        WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id}) 
           OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) 
        ORDER BY msg_id ASC";

$query = mysqli_query($conn, $sql);

if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        $msg_descifrado = cesar_decrypt($row['msg']); // Descifrado----------

        if ($row['outgoing_msg_id'] == $outgoing_id) {
            $output .= '<div class="chat outgoing">
                            <div class="details">
                                <p>' . htmlspecialchars($msg_descifrado) . '</p>
                            </div>
                        </div>';
        } else {
            $output .= '<div class="chat incoming">
                            <img src="php/images/' . $row['img'] . '" alt="">
                            <div class="details">
                                <p>' . htmlspecialchars($msg_descifrado) . '</p>
                            </div>
                        </div>';
        }
    }
}

echo $output;
?>
