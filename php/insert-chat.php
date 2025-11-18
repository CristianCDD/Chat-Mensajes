<?php
    session_start();

    if(isset($_SESSION['unique_id'])){
        include_once "config.php";

        $outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']); //Nuestro ID
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']); //Id de la otra persona

        $message = mysqli_real_escape_string($conn, $_POST['message']);

        if(!empty($message)){
            $sql = mysqli_query($conn, "INSERT INTO messages
             (incoming_msg_id, outgoing_msg_id, msg) values
              ({$incoming_id}, {$outgoing_id}, '{$message}')") or die() ;
        }       
        }else{
            header("../login.php");
        }


   
?>