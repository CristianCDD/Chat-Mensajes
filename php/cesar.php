<?php
// php/cesar.php

// ================================
// Alfabeto español (27 letras: incluye ñ)
// ================================
$ABC = "abcdefghijklmnñopqrstuvwxyz";
$clave_cesar = 6; // Cambia este valor para ajustar la clave en cifrado y descifrado
$A = mb_strlen($ABC, 'UTF-8'); // Tamaño del alfabeto: 27

// ================================
// Función de cifrado César
// Fórmula: C = m + [k mod A]
// ================================
function cesar_encrypt($mensaje){
    global $ABC, $A, $clave_cesar; // Usamos la clave global
    $C = ""; // Variable donde se guardará el mensaje cifrado

    // Recorremos cada carácter del mensaje
    for($i = 0; $i < mb_strlen($mensaje, 'UTF-8'); $i++){
        $m = mb_substr($mensaje, $i, 1, 'UTF-8'); // letra actual
        $m_lower = mb_strtolower($m, 'UTF-8');    // convertimos a minúscula para buscar
        $pos = mb_strpos($ABC, $m_lower, 0, 'UTF-8'); // buscamos posición de m en el alfabeto

        if($pos !== false){
            // C = m + [clave_cesar mod A]
            $C_index = ($pos + ($clave_cesar % $A)) % $A;
            $C_char = mb_substr($ABC, $C_index, 1, 'UTF-8');

            // Conservamos mayúsculas si la letra original era mayúscula
            $C .= ctype_upper($m) ? mb_strtoupper($C_char, 'UTF-8') : $C_char;
        } else {
            // Si no es letra del alfabeto, se deja igual
            $C .= $m;
        }
    }

    return $C; // Retornamos el mensaje cifrado
}

// ================================
// Función de descifrado César
// Fórmula: m = C - [k mod A]
// ================================
function cesar_decrypt($C_text){
    global $ABC, $A, $clave_cesar; // Usamos la misma clave global
    $mensaje = ""; // Variable donde se guardará el mensaje descifrado

    // Recorremos cada carácter del mensaje cifrado
    for($i = 0; $i < mb_strlen($C_text, 'UTF-8'); $i++){
        $C = mb_substr($C_text, $i, 1, 'UTF-8'); // letra cifrada
        $C_lower = mb_strtolower($C, 'UTF-8');    // convertimos a minúscula para buscar
        $pos = mb_strpos($ABC, $C_lower, 0, 'UTF-8'); // buscamos posición de C en el alfabeto

        if($pos !== false){
            // m = C - [clave_cesar mod A]
            $m_index = ($pos - ($clave_cesar % $A) + $A) % $A;
            $m_char = mb_substr($ABC, $m_index, 1, 'UTF-8');

            // Conservamos mayúsculas si la letra original era mayúscula
            $mensaje .= ctype_upper($C) ? mb_strtoupper($m_char, 'UTF-8') : $m_char;
        } else {
            // Si no es letra del alfabeto, se deja igual
            $mensaje .= $C;
        }
    }

    return $mensaje; // Retornamos el mensaje descifrado
}
?>


