<?php

$conn = mysqli_connect("localhost", "root", "Cristian1074@", "chat", 3306);

if (!$conn) {
    echo "Error: " . mysqli_connect_error();
} else {
    echo "Conexión exitosa";
}
?>
