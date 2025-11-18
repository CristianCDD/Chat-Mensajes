<?php
session_start();

if(isset($_SESSION['unique_id'])){
    include_once "config.php";

    $outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $message     = mysqli_real_escape_string($conn, $_POST['message']);

    // Función de cifrado César +5
    function cesar_encrypt($text, $shift = 5){
        $result = "";
        $shift = $shift % 26;

        for($i = 0; $i < strlen($text); $i++){
            $char = $text[$i];

            if($char >= 'A' && $char <= 'Z'){
                $result .= chr((ord($char) - 65 + $shift) % 26 + 65);
            }
            elseif($char >= 'a' && $char <= 'z'){
                $result .= chr((ord($char) - 97 + $shift) % 26 + 97);
            }
            else{
                $result .= $char;
            }
        }
        return $result;
    }

    $message_encrypted = cesar_encrypt($message, 5);

    if(!empty($message)){
        $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg) 
                                    VALUES ({$incoming_id}, {$outgoing_id}, '{$message_encrypted}')")
        or die(mysqli_error($conn));
    }

}else{
    header("Location: ../login.php");
}
?>
