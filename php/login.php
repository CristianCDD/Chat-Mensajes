<?php
session_start();
include_once "config.php";
include_once "cesar.php"; // Asegúrate de incluir las funciones de cifrado/descifrado

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

if (!empty($email) && !empty($password)) {

    // 1. Buscar usuario solo por email
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");

    if (mysqli_num_rows($sql) > 0) {

        $row = mysqli_fetch_assoc($sql);
        $password_cifrada = $row['password'];

        // 2. DESCIFRAR contraseña de la BD
        $password_descifrada = cesar_decrypt($password_cifrada);

        // 3. Compararla con la ingresada
        if ($password_descifrada === $password) {

            $status = "Activo ahora";

            // 4. Actualizar estado
            mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']}");

            // 5. Iniciar sesión
            $_SESSION['unique_id'] = $row['unique_id'];
            echo "success";

        } else {
            echo "Contraseña incorrecta";
        }

    } else {
        echo "Email incorrecto";
    }

} else {
    echo "Estos campos son requeridos";
}
?>
