<?php
    require("../config.php");

    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $date_buy = date('Y/m/d', time());
    $sql_insert = "insert into tbl_buy_ticket ( post_date) values('" . $date_buy . "')";
                                
     //Xóa
     if (isset($_GET["task"]) && $_GET["task"] == "delete") {
        $id = $_GET["id"];
        $sql_delete = "delete from tbl_buy_ticket where ticket_id = " . $id;
        if (mysqli_query($conn, $sql_delete)) {
            header("location:manager_ticket.php");
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    //xóa tất cả
    if (isset($_POST["delete_all"])) {
        $sql_delete_all = "DELETE FROM tbl_buy_ticket";
        if (mysqli_query($conn, $sql_delete_all)) {
            echo "Xóa tất cả dữ liệu thành công";
        } else {
            echo "Lỗi: " . mysqli_error($conn);
        }
    }

    //Xóa theo chọn
    if (isset($_POST["delete_check"])) {
        $ticket_id = $_POST["cate"];
        foreach ($ticket_id as $c) {
            $sql_delete = "delete from tbl_buy_ticket where ticket_id = " . $c;
            if (mysqli_query($conn, $sql_delete)) {
                header("location:manager_ticket.php");
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }

    // BƯỚC 2: TÌM TỔNG SỐ RECORDS
    $result = mysqli_query($conn, 'select count(ticket_id) as total from tbl_buy_ticket');
    $row = mysqli_fetch_assoc($result);
    $total_records = $row['total'];

    // BƯỚC 3: TÌM LIMIT VÀ CURRENT_PAGE
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $limit = 5;

    // BƯỚC 4: TÍNH TOÁN TOTAL_PAGE VÀ START
    // tổng số trang
    $total_page = ceil($total_records / $limit);

    // Giới hạn current_page trong khoảng 1 đến total_page
    if ($current_page > $total_page) {
        $current_page = $total_page;
    } else if ($current_page < 1) {
        $current_page = 1;
    }
    // Tìm Start
    $start = ($current_page - 1) * $limit;

    //upadate
    // Truy vấn dữ liệu từ bảng
    
    
    ?>

<html>
    <header>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/ticket.css">
    </header>
    <body>
        <div class="row header">
            <h1 style="text-align: center;">Trang quản trị loại vé</h1>
            <div class="col-1"></div>
            <div class="col-10">
                <table>
                    <tr>
                        <th>Người Mua Vé</th>
                        <th>Hạng Vé</th>
                        <th>Hàng Ghế</th>
                        <th>Số Lượng Vé</th>
                        <th>Địa Điểm</th>
                        <th>Thời Gian</th>
                        <th>Thao Tác</th>
                        <th>Chọn</th>
                    </tr>
                    <form action="manager_ticket.php" method="post"> 
                        <input id="button_ticket" type="submit" value="xóa tất cả" name="delete_all" class="btn btn-primary" id="">
                        <br>
                        <input id="button_ticket" type="submit" value="xóa theo chọn" name="delete_check" class="btn btn-primary" id="">
                        <br>
                        Tìm khách hàng:
                        <input class="form-control" type="text" name="txt_search" id="">
                        <br>
                        <input class="btn btn-success" type="submit" value="Tim kiem" name="search" id="">
                        
                        <?php 
                            // PHẦN HIỂN THỊ TIN TỨC
                            // BƯỚC 6: HIỂN THỊ DANH SÁCH TIN TỨC
                            echo "<br>";

                            $sql = "";
                            if (isset($_POST["search"])) {
                                $location = $_POST['txt_search'];
                                $sql = "select * from tbl_buy_ticket where location like '%" . $location . "%'";
                            } else
                                $sql = "select * from tbl_buy_ticket LIMIT " . $start . "," . $limit;
                            
                            // Thực thi câu truy vấn
                            $result = mysqli_query($conn, $sql);

                            // Kiểm tra và hiển thị dữ liệu
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                        echo "<td>".$row["user_name"]. ", " .$row["email"]."</td>";
                                        echo "<td>" .$row["type_ticket"]."</td>";
                                        echo "<td>" .$row["rows_of_seat"]."</td>";
                                        echo "<td>" .$row["quantity"]."</td>";
                                        echo "<td>" .$row["location"]."</td>";
                                        echo "<td>" .$row["date_buy"]."</td>";
                                        echo "<td>";
                                            echo "<a class='btn btn-danger' href='manager_ticket.php?task=delete&id=" . $row["ticket_id"] . "'>Xoa</a>";
                                        echo "</td>";
                                        echo "<td>";
                                            echo "<input type = 'checkbox' name= 'cate[]' value= '" . $row["ticket_id"] . "' class= 'form-check-input''>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "Không có dữ liệu";
                            }
                            // Đóng kết nối
                            mysqli_close($conn);
                        
                            // PHẦN HIỂN THỊ PHÂN TRANG
                            // BƯỚC 7: HIỂN THỊ PHÂN TRANG

                            // nếu current_page > 1 và total_page > 1 mới hiển thị nút prev
                            if ($current_page > 1 && $total_page > 1) {
                                echo '<a href="manager_ticket.php?page=' . ($current_page - 1) . '">Prev</a> | ';
                            }

                            // Lặp khoảng giữa
                            for ($i = 1; $i <= $total_page; $i++) {
                                // Nếu là trang hiện tại thì hiển thị thẻ span
                                // ngược lại hiển thị thẻ a
                                if ($i == $current_page) {
                                    echo '<span>' . $i . '</span> | ';
                                } else {
                                    echo '<a href="manager_ticket.php?page=' . $i . '">' . $i . '</a> | ';
                                }
                            }

                            // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
                            if ($current_page < $total_page && $total_page > 1) {
                                echo '<a href="manager_ticket.php?page=' . ($current_page + 1) . '">Next</a> | ';
                            }
                    ?>
                    </form>
                    
                </table>
            </div>
            <div class="col-1"></div>
            <div class="row">
            <div class="col-1"></div>
                
                <div class="col-1"></div>
            </div>
        </div>
    </body>
</html>