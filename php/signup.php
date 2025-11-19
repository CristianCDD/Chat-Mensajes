<?php
session_start();
include_once "config.php";
include_once "cesar.php"; // Incluimos nuestras funciones de cifrado

// Recibimos datos del formulario y escapamos caracteres peligrosos
$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Validamos que no estén vacíos
if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)){

    // Validamos que sea un correo válido
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){

        // Revisamos si el correo ya existe
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
        if(mysqli_num_rows($sql) > 0){
            echo "$email - Este correo ya existe";
        } else {

            if(isset($_FILES['image'])){
                // Nombre y tipo del archivo
                $img_name = $_FILES['image']['name'];
                $img_type = $_FILES['image']['type'];
                $tmp_name = $_FILES['image']['tmp_name'];

                // Obtenemos la extensión
                $img_explode = explode('.', $img_name);
                $img_ext = end($img_explode);
    
                $extensions = ["jpeg", "png", "jpg"];
                $types = ["image/jpeg", "image/jpg", "image/png"];

                // Comprobamos que la extensión y el tipo sean correctos
                if(in_array($img_ext, $extensions) === true && in_array($img_type, $types) === true){
                    $time = time();
                    $new_img_name = $time.$img_name;

                    if(move_uploaded_file($tmp_name,"images/".$new_img_name)){
                        $status = "Activo ahora";
                        $random_id = rand(time(), 100000000);

                        // =========================
                        // Aplicamos cifrado César
                        // =========================
                        $fname_cifrado = cesar_encrypt($fname);
                        $lname_cifrado = cesar_encrypt($lname);
                        $password_cifrado = cesar_encrypt($password);

                        // Insertamos en la base de datos
                        $sql2 = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
                                    VALUES ({$random_id}, '{$fname_cifrado}','{$lname_cifrado}', '{$email}', '{$password_cifrado}', '{$new_img_name}', '{$status}')");

                        if($sql2){
                            $sql3 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                            if(mysqli_num_rows($sql3) > 0){
                                $row = mysqli_fetch_assoc($sql3);
                                $_SESSION['unique_id'] = $row['unique_id'];
                                echo "success";
                            } else {
                                echo "This email address not Exist!";
                            }
                        } else {
                            echo "Something went wrong. Please try again!";
                        }

                    }
                } else {
                    echo "Please upload an image file - jpeg, png, jpg";
                }
            }

        }

    } else {
        echo "$email is not a valid email!";
    }

} else {
    echo "All input fields are required!";
}
?>


