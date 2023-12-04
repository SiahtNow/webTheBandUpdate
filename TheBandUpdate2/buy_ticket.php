<?php
    require("config.php");
    
    //thêm mới (mua)
    if (isset($_POST["buy_ticket"])) {
        //Kiểm tra xem nút btn_insert đã được ấn hay chưa bằng cách kiểm tra biến $_POST["btn_insert"] có tồn tại hay không
        $user_name = $_POST["name"];
        $email = $_POST["email"];
        $type_ticket = $_POST["type_ticket"];
        $rows_of_seat = $_POST["rows_of_seats"];
        $quantity = $_POST["number_of_tickets"];
            //Phương thức kiểm tra và di chuyển file upload vào thư mục đích là $target_file, nếu thành công trả về True và thực hiện lệnh phía dưới
            $sql_insert = "insert into tbl_buy_ticket(user_name, email, type_ticket, rows_of_seat, quantity) values('".$user_name."','".$email."','".$type_ticket."','".$rows_of_seat."','" . $quantity . "')";
            if (mysqli_query($conn, $sql_insert)) {
                //Thực hiện truy vấn đối tượng kết nối $conn và insert dữ liệu phía trên nếu thực hiện thành công thì chuyển hướng đến category
                header("location:buy_ticket.php");
                //echo "New record created successfully";
            } else {
                //Nếu sai thì báo lỗi 
                echo "Error: " . $sql_insert . "<br>" . mysqli_error($conn);
            }
    }
    if (isset($_POST["go_home"])) {
        header("location:index.php");
    }
?>

<html>
    <header>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/buy_ticket.css">
    </header>
    <body>
        <div class="row">
            <p>TRANG MUA VÉ</p>
            <div class="col-1"></div>
            <div class="col-5">
                <form action="" method="post" enctype="multipart/form-data">
                    <input class="form-control" type="text" name="name" id="button_input" placeholder="Tên">
                    <br>
                    <input class="form-control" type="text" name="email" id="button_input" placeholder="Email">
                    <br>
                    <input class="form-control" type="text" name="type_ticket" id="button_input" placeholder="Hạng vé">
                    <br>
                    <input class="form-control" type="number" min="1" name="rows_of_seats" id="button_input" placeholder="Hàng ghế">
                    <br>
                    <input class="form-control" type="number" min="1" max="5" name="number_of_tickets" id="button_input" placeholder="Số Lượng vé(tối đa 5 vé)">
                    <br>
                    <input type="submit" value="Mua Vé" name="buy_ticket" class="btn btn-primary" id="">
                    <input type="submit" value="Về Trang Chủ" name="go_home" class="btn btn-primary" id="">
                </form>
                
            </div>
            <div class="col-5">
                <p>BẢNG GIÁ VÉ</p>
                <table>
                    <tr>
                        <th>Hạng Vé</th>
                        <th>Địa ĐIểm</th>
                        <th>Thời Gian</th>
                    </tr>
                    <form action="buy_ticket.php" method="post"> 
                        <?php 
                            // Tạo câu truy vấn SQL để lấy dữ liệu từ bảng
                            $sql = "SELECT * FROM type_ticket";

                            // Thực thi câu truy vấn
                            $result = mysqli_query($conn, $sql);

                            // Kiểm tra và hiển thị dữ liệu
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                        echo "<td>" .$row["type_ticket"]."</td>";
                                        echo "<td>" .$row["location"]."</td>";
                                        echo "<td>" .$row["date_view"]."</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "Không có dữ liệu";
                            }
                            // Đóng kết nối
                            mysqli_close($conn);
                        ?>    
                    
                    </form>
                    
                </table>
            </div>
            <div class="col-1"></div>
        </div>
    </body>
</html>