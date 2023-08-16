

<?php
session_start();
if(isset($_SESSION['unique_id'])){
    header("location: users.php");
}
?>
<?php include_once "header.php";  ?>

    <div class="wrapper">
        <section class="form login">
            <header>Realtime chat App</header>
            <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="error-text"></div>
               

                    <div class="field input">
                        <label for="">Email Address</label>
                        <input type="email" name="email" placeholder="Enter your email">
                    </div>

                    <div class="field input">
                        <label for="">Password</label>
                        <input type="password" name="password" placeholder="Enter your password">
                        <i class="fas fa-eye"></i>
                    </div>

                  

                    <div class="field button">
                        <input type="submit" value="Continue to chat">
                    </div>
                
            </form>
            <div class="link">Not yet signed up?<a href="index.php">Signup now</a></div>
        </section>
    </div>
    
    <script src="js/password.js"></script>
    <script src="js/login.js"></script>

</body>
</html>