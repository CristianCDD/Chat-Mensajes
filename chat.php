<?php
session_start();

if (!isset($_SESSION['unique_id'])) {
    header("location: login.php");
}
?>
<?php include_once "header.php";  ?>
<?php include_once "php/cesar.php"; ?>

<body>

    <div class="wrapper">
        <section class="chat-area">
            <header>

                <?php
                include_once ("php/config.php");
                $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
                $sql = mysqli_query($conn, "SELECT * FROM users where unique_id = '{$user_id}'");

                if (mysqli_num_rows($sql) > 0) {
                    $row = mysqli_fetch_assoc($sql);
                }


                ?>

                <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <img src="php/images/<?php echo $row['img'] ?>" alt="">
                <div class="details">
                    <span><?php echo cesar_decrypt($row['fname']) . " " . cesar_decrypt($row['lname']); ?></span>
                    <p><?php echo $row['status'] ?></p>
                </div>
            </header>

            <div class="chat-box">
              
                
            </div>

          <form action="php/insert-chat.php" class="typing-area" autocomplete="off" enctype="multipart/form-data">
    <input type="text" hidden name="outgoing_id" value="<?php echo $_SESSION['unique_id']; ?>">
    <input type="text" hidden name="incoming_id" value="<?php echo $user_id; ?>">
    
    <input type="text" name="message" class="input-field" placeholder="Escribe un mensaje ...">
    <input type="file" name="file_upload" accept=".doc,.docx">
    
    <button><i class="fab fa-telegram-plane"></i></button>
</form>



        </section>
    </div>

   
<script src="js/chat.js"></script>
</body>

</html>
