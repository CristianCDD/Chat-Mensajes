<?php
include_once "cesar.php"; // Incluimos las funciones de cifrado/descifrado

while ($row = mysqli_fetch_assoc($sql)) {

    // Obtener último mensaje
    $sql2 = "SELECT * FROM messages 
             WHERE (incoming_msg_id = {$row['unique_id']} 
                    OR outgoing_msg_id = {$row['unique_id']}) 
               AND (outgoing_msg_id = {$outgoing_id} 
                    OR incoming_msg_id = {$outgoing_id}) 
             ORDER BY msg_id DESC LIMIT 1";

    $query2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($query2);

    if (mysqli_num_rows($query2) > 0) {
        $result = cesar_decrypt($row2['msg']); // Desciframos mensaje
    } else {
        $result = "Sin mensajes";
    }

    // DESCIFRAR nombre y apellido
    $fname = cesar_decrypt($row['fname']);  
    $lname = cesar_decrypt($row['lname']);  

    // Previsualización del último mensaje
    $msg = (strlen($result) > 26) ? substr($result, 0, 22) . '....' : $result;

    // Indica si el mensaje lo enviaste tú
    $you = ($row2 && $outgoing_id == $row2['outgoing_msg_id']) ? "Tu: " : "";

    // Estado de conexión
    $offline = ($row['status'] == "Desconectado") ? "offline" : "";

    // Render chat
    $output .= '<a href="chat.php?user_id=' . $row['unique_id'] . '">
                    <div class="content">
                        <img src="php/images/' . $row['img'] . '" alt="">
                        <div class="details">
                            <span>' . $fname . " " . $lname . '</span>
                            <p>' . $you . htmlspecialchars($msg) . '</p>
                        </div>
                    </div>
                    <div class="status-dot ' . $offline . '"><i class="fas fa-circle"></i></div>
                </a>';
}
?>

