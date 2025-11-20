<?php
session_start();
include_once "config.php";
include_once "cesar.php";

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

if (!empty($email) && !empty($password)) {

    $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");

    if (mysqli_num_rows($sql) > 0) {

        $row = mysqli_fetch_assoc($sql);
        $password_cifrada = $row['password'];

        // DESCIFRAR
        $password_descifrada = cesar_decrypt($password_cifrada);

        // ✅ NORMALIZAR LA CONTRASEÑA INGRESADA
        $password_ingresada = normalize($password);

        if ($password_descifrada === $password_ingresada) {

            $status = "Activo ahora";
            mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']}");

            $_SESSION['unique_id'] = $row['unique_id'];
            echo "success";

        } else {
            echo "Contraseña incorrecta";
        }

    } else {
        echo "Email incorrecto";
    }

} else {
    echo "Todos los campos son requeridos";
}
?>
