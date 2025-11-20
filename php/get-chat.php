<?php
session_start();

if (!isset($_SESSION['unique_id'])) {
    header("Location: ../login.php");
    exit();
}

include_once "config.php";
include_once "cesar.php";

$outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
$incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
$output = "";

// Consultar mensajes entre los dos usuarios
$sql = "SELECT messages.*, users.img 
        FROM messages 
        LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
        WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id}) 
           OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) 
        ORDER BY msg_id ASC";

$query = mysqli_query($conn, $sql);

if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {

        // --- Mensajes tipo archivo ---
        if ($row['type'] === 'file') {
            // Ruta correcta para el navegador
            $file_path = 'php/uploads/' . $row['msg'];
            $file_name = htmlspecialchars($row['msg']);

            $link_html = '<a href="' . $file_path . '" download>' . $file_name . '</a>';

            if ($row['outgoing_msg_id'] == $outgoing_id) {
                $output .= '<div class="chat outgoing">
                                <div class="details">' . $link_html . '</div>
                            </div>';
            } else {
                $output .= '<div class="chat incoming">
                                <img src="php/images/' . $row['img'] . '" alt="">
                                <div class="details">' . $link_html . '</div>
                            </div>';
            }

        // --- Mensajes de texto ---
        } else {
            $msg_descifrado = cesar_decrypt($row['msg']);

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
} else {
    $output .= '<div class="text">No hay mensajes aún</div>';
}

echo $output;
?>
