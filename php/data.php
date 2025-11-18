<?php
include_once "cesar.php"; // Incluimos las funciones de cifrado/descifrado

while ($row = mysqli_fetch_assoc($sql)) {
    $sql2 = "SELECT * FROM messages 
             WHERE (incoming_msg_id = {$row['unique_id']} 
                    OR outgoing_msg_id = {$row['unique_id']}) 
               AND (outgoing_msg_id = {$outgoing_id} 
                    OR incoming_msg_id = {$outgoing_id}) 
             ORDER BY msg_id DESC LIMIT 1";

    $query2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($query2);

    if (mysqli_num_rows($query2) > 0) {
        $result = cesar_decrypt($row2['msg']); // Desciframos el mensaje
    } else {
        $result = "Sin mensajes";
    }

    $msg = (strlen($result) > 26) ? substr($result, 0, 22) . '....' : $result;
    $you = ($row2 && $outgoing_id == $row2['outgoing_msg_id']) ? "Tu: " : "";
    $offline = ($row['status'] == "Desconectado") ? "offline" : "";

    $output .= '<a href="chat.php?user_id=' . $row['unique_id'] . '">
                    <div class="content">
                        <img src="php/images/' . $row['img'] . '" alt="">
                        <div class="details">
                            <span>' . $row['fname'] . " " . $row['lname'] . '</span>
                            <p>' . $you . htmlspecialchars($msg) . '</p>
                        </div>
                    </div>
                    <div class="status-dot ' . $offline . '"><i class="fas fa-circle"></i></div>
                </a>';
}
?>
