<html>
    <head>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style_sign.css">
        <meta charset="utf-8">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-4"></div>
                <div class="col-4">
                    <div class="picture">
                        <img src="img/HTML Tutorial.jfif" alt="">
                    </div>
                    <h1>Register an account</h1>
                    <br>
                    <br>
                    <div class="register">
                        <form action ="register.php" method= "post">
                            Username or email address:
                            <input type="text" name="txt_username" class="form-control" >
                            Password:
                            <input type="password" name="txt_password" class="form-control">
                            Retype passkey:
                            <input type="password" name="re_password" class="form-control">
                            <br>   
                            <?php
                                require("config.php");
                                if (isset($_POST["register"])) {
                                    $user_name = $_POST["txt_username"];
                                    $password = $_POST["txt_password"];
                                    $re_password = $_POST["re_password"];
                                
                                    if ($password != $re_password) {
                                        echo "Nhập lại mật khẩu không chính xác";
                                    } else {
                                        $sql = "select * from tbl_account where user_name = '" .$user_name. "'";
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            echo "Tên đăng nhập đã tồn tại";
                                        } else {
                                            $sql_insert = "insert into tbl_account(user_name,password) values('" .$user_name. "', '" .$password. "')";
                                            if (mysqli_query($conn, $sql_insert)) {
                                                header("location:login.php");
                                                
                                            } else {
                                                echo "Error: " .$sql_insert. "<br>" . mysqli_error($conn);
                                            }
                                        }
                                    }
                                }
                            ?>           
                            <input style="margin-top:60px;width: 100%;" type="submit" value="Register" name="register" class="btn btn-primary">
                        </form>
                    </div>
                </div>
                <div class="col-4"></div>
            </div>
        </div>
    </body>
</html>