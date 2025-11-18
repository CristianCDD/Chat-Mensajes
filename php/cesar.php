<?php
// php/cesar.php

function cesar_encrypt($text, $shift = 5){
    $result = "";
    $shift = $shift % 26;
    for($i = 0; $i < strlen($text); $i++){
        $char = $text[$i];
        if($char >= 'A' && $char <= 'Z'){
            $result .= chr((ord($char) - 65 + $shift) % 26 + 65);
        } elseif($char >= 'a' && $char <= 'z'){
            $result .= chr((ord($char) - 97 + $shift) % 26 + 97);
        } else{
            $result .= $char;
        }
    }
    return $result;
}

function cesar_decrypt($text, $shift = 5){
    $result = "";
    $shift = $shift % 26;
    for($i = 0; $i < strlen($text); $i++){
        $char = $text[$i];
        if($char >= 'A' && $char <= 'Z'){
            $result .= chr((ord($char) - 65 - $shift + 26) % 26 + 65);
        } elseif($char >= 'a' && $char <= 'z'){
            $result .= chr((ord($char) - 97 - $shift + 26) % 26 + 97);
        } else{
            $result .= $char;
        }
    }
    return $result;
}
?>
