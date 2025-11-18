<?php
session_start();
if(isset($_SESSION['unique_id'])){
    header("Location: users.php");
    exit();
}
?>

<?php include_once "header.php"; ?>

<body>
    <div class="wrapper">
        <section class="form signup">
            <header>Feisbuk</header>
            <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="error-text"></div>
                
                <div class="name-details">
                    <div class="field input">
                        <label>Nombres</label>
                        <input type="text" name="fname" placeholder="Ingresar nombres" required>
                    </div>
                    <div class="field input">
                        <label>Apellidos</label>
                        <input type="text" name="lname" placeholder="Ingresar apellidos" required>
                    </div>
                </div>

                <div class="field input">
                    <label>Correo</label>
                    <input type="email" name="email" placeholder="Ingresar correo electrónico" required>
                </div>

                <div class="field input">
                    <label>Contraseña</label>
                    <input type="password" name="password" placeholder="Ingresar nueva contraseña" required>
                    <i class="fas fa-eye"></i>
                </div>

                <div class="field image">
                    <label>Selecciona una imagen</label>
                    <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required>
                </div>

                <div class="field button">
                    <input type="submit" name="submit" value="Registrar">
                </div>
            </form>

            <div class="link">¿Ya tienes una cuenta? <a href="login.php">Iniciar sesión</a></div>
        </section>
    </div>

    <script src="js/password.js"></script>
    <script src="js/signup.js"></script>
</body>
</html>
