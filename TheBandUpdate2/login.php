<?php
    require("config.php");
    session_start();

    if(isset($_POST["login"])) {
        $user_name = $_POST["txt_username"];
        $password = $_POST["txt_password"];
        $sql = "select * from tbl_account where user_name = '".$user_name."' and password = '".$password."'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result) == 1) {
            $_SESSION["user"] = $user_name;
            header("location:index.php");
        } else {
            echo"Sai ten dang nhap hoac mat khau";
        }
    }
?>
<html>
    <head>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/style_sign.css">
    </head>
    <body>
        <div class="container">
            <div class="row">

               <div class="col-4"></div>
               <div class="col-4">
                    <div class="picture">
                        <img src="img/HTML Tutorial.jfif" alt="">
                    </div>
                    <h1>Sign in to The Band</h1>
                    <br>
                    <br>
                    <div class="login">
                        <form method= "post">
                            Username or email address:
                            <input type="text" name="txt_username" class="form-control">
                            Password:
                            <input type="password" name="txt_password" class="form-control">
                            <br>
                            <a href="#">Forgot Password?</a>               
                            <br>
                            <input style="margin-top:60px;width: 100%;" type="submit" value="Log in" name="login" class="btn btn-primary">
                        </form>
                    </div>
                    <br>
                    <div class="another_login">
                        <a href="">Sign in with the passkey</a>
                        <p>New to The Band?
                            <span>
                                <a href="register.php">Creat a account</a>
                            </span>
                        </p>
                       
                    </div>    
               </div>
               <div class="col-4"></div>
            </div>
        </div>
    </body>
</html>