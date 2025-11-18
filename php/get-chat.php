<?php
session_start();

if(isset($_SESSION['unique_id'])){
    include_once "config.php";

    $outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $output = "";

    // Función para descifrar César -5
    function cesar_decrypt($text, $shift = 5){
        $result = "";
        $shift = $shift % 26;

        for($i = 0; $i < strlen($text); $i++){
            $char = $text[$i];

            if($char >= 'A' && $char <= 'Z'){
                $result .= chr((ord($char) - 65 - $shift + 26) % 26 + 65);
            }
            elseif($char >= 'a' && $char <= 'z'){
                $result .= chr((ord($char) - 97 - $shift + 26) % 26 + 97);
            }
            else{
                $result .= $char;
            }
        }
        return $result;
    }

    $sql = "SELECT * FROM messages 
            LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
            WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id}) 
               OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) 
            ORDER BY msg_id ASC";

    $query = mysqli_query($conn, $sql);

    if(mysqli_num_rows($query) > 0){
        while($row = mysqli_fetch_assoc($query)){
            $msg_descifrado = cesar_decrypt($row['msg']);

            if($row['outgoing_msg_id'] === $outgoing_id){
                $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>' . $msg_descifrado . '</p>
                                </div>
                            </div>';
            }else{
                $output .= '<div class="chat incoming">
                                <img src="php/images/'. $row['img'] .'" alt="">
                                <div class="details">
                                    <p>' . $msg_descifrado . '</p>
                                </div>
                            </div>';
            }
        }
        echo $output;
    }

}else{
    header("Location: ../login.php");
}
?>
