<?php
// Alfabeto que se usará para cifrar y descifrar (solo minúsculas)
$ABC = "abcdefghijklmnñopqrstuvwxyz";
$A = mb_strlen($ABC, 'UTF-8');

// Función para convertir mensaje y clave a minúsculas
function normalize($str){
    return mb_strtolower($str, 'UTF-8');
}

// Función Vigenère simple (cifrar)
function vigenere_encrypt($mensaje, $clave){
    global $ABC, $A;
    $mensaje = normalize($mensaje);
    $clave = normalize($clave);

    $res = "";
    $len_clave = mb_strlen($clave, 'UTF-8');

    for($i = 0, $j = 0; $i < mb_strlen($mensaje, 'UTF-8'); $i++){
        $m = mb_substr($mensaje, $i, 1, 'UTF-8');
        $pos = mb_strpos($ABC, $m);

        if($pos !== false){
            $k = mb_substr($clave, $j % $len_clave, 1, 'UTF-8');
            $k_pos = mb_strpos($ABC, $k);
            $res .= mb_substr($ABC, ($pos + $k_pos) % $A, 1, 'UTF-8');
            $j++;
        } else {
            $res .= $m;
        }
    }

    return $res;
}

// Función Vigenère inversa (descifrar)
function vigenere_decrypt($mensaje, $clave){
    global $ABC, $A;
    $mensaje = normalize($mensaje);
    $clave = normalize($clave);

    $res = "";
    $len_clave = mb_strlen($clave, 'UTF-8');

    for($i = 0, $j = 0; $i < mb_strlen($mensaje, 'UTF-8'); $i++){
        $m = mb_substr($mensaje, $i, 1, 'UTF-8');
        $pos = mb_strpos($ABC, $m);

        if($pos !== false){
            $k = mb_substr($clave, $j % $len_clave, 1, 'UTF-8');
            $k_pos = mb_strpos($ABC, $k);
            $res .= mb_substr($ABC, ($pos - $k_pos + $A) % $A, 1, 'UTF-8');
            $j++;
        } else {
            $res .= $m;
        }
    }

    return $res;
}

// Función César simple (cifrar +2)
function cesar_encrypt_shift($mensaje, $shift = 2){
    global $ABC, $A;
    $res = "";
    for($i = 0; $i < mb_strlen($mensaje, 'UTF-8'); $i++){
        $m = mb_substr($mensaje, $i, 1, 'UTF-8');
        $pos = mb_strpos($ABC, $m);
        if($pos !== false){
            $res .= mb_substr($ABC, ($pos + $shift) % $A, 1, 'UTF-8');
        } else {
            $res .= $m;
        }
    }
    return $res;
}

// Función César inversa (-2)
function cesar_decrypt_shift($mensaje, $shift = 2){
    global $ABC, $A;
    $res = "";
    for($i = 0; $i < mb_strlen($mensaje, 'UTF-8'); $i++){
        $m = mb_substr($mensaje, $i, 1, 'UTF-8');
        $pos = mb_strpos($ABC, $m);
        if($pos !== false){
            $res .= mb_substr($ABC, ($pos - $shift + $A) % $A, 1, 'UTF-8');
        } else {
            $res .= $m;
        }
    }
    return $res;
}

// Función total de cifrado: Vigenère → César+2 → Vigenère
function cesar_encrypt($mensaje, $clave = "clave"){
    $tmp1 = vigenere_encrypt($mensaje, $clave);
    $tmp2 = cesar_encrypt_shift($tmp1, 2);
    $tmp3 = vigenere_encrypt($tmp2, $clave);
    return $tmp3;
}

// Función total de descifrado: Vigenère inversa → César-2 → Vigenère inversa
function cesar_decrypt($mensaje, $clave = "clave"){
    $tmp1 = vigenere_decrypt($mensaje, $clave);
    $tmp2 = cesar_decrypt_shift($tmp1, 2);
    $tmp3 = vigenere_decrypt($tmp2, $clave);
    return $tmp3;
}

// Función total de cifrado
function encrypt_total($mensaje, $clave = "clave"){
    return cesar_encrypt($mensaje, $clave);
}

// Función total de descifrado
function decrypt_total($mensaje_cifrado, $clave = "clave"){
    return cesar_decrypt($mensaje_cifrado, $clave);
}
?>
