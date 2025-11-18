

<?php
session_start();
if(isset($_SESSION['unique_id'])){
    header("location: users.php");
}
?>
<?php include_once "header.php";  ?>

    <div class="wrapper">
        <section class="form login">
            <header>Feisbuk</header>
            <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="error-text"></div>
               

                    <div class="field input">
                        <label for="">Correo electronico</label>
                        <input type="email" name="email" placeholder="Ingrese su correo">
                    </div>

                    <div class="field input">
                        <label for="">Contraseña</label>
                        <input type="password" name="password" placeholder="Ingrese su contraseña">
                        <i class="fas fa-eye"></i>
                    </div>

                  

                    <div class="field button">
                        <input type="submit" value="Iniciar sesion">
                    </div>
                
            </form>
            <div class="link">¿Aún no te has registrado?<a href="index.php">Registrate ahora</a></div>
        </section>
    </div>
    
    <script src="js/password.js"></script>
    <script src="js/login.js"></script>

</body>
</html>