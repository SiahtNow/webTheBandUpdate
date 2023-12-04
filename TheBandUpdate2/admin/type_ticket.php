<?php
    //Tái sử dụng config.php
    require("../config.php");

    //Thêm vé mới
    if (isset($_POST["add_ticket"])) {
        //Kiểm tra xem nút btn_insert đã được ấn hay chưa bằng cách kiểm tra biến $_POST["btn_insert"] có tồn tại hay không
        $location = $_POST["txt_location"];
        $type_ticket =$_POST["type_ticket"];
        $date_view = $_POST["date_date_view"];
        $target_dir = "upload_img/";
        $target_file = $target_dir . basename($_FILES["file_upload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (move_uploaded_file($_FILES["file_upload"]["tmp_name"], $target_file)) {
            //Phương thức kiểm tra và di chuyển file upload vào thư mục đích là $target_file, nếu thành công trả về True và thực hiện lệnh phía dưới
            $sql_insert = "insert into type_ticket(location,type_ticket, date_view, link_img) values('" . $location . "','" . $type_ticket . "','" . $date_view . "','" . $target_file . "')";
            if (mysqli_query($conn, $sql_insert)) {
                //Thực hiện truy vấn đối tượng kết nối $conn và insert dữ liệu phía trên nếu thực hiện thành công thì chuyển hướng đến category
                header("location:type_ticket.php");
                //echo "New record created successfully";
            } else {
                //Nếu sai thì báo lỗi 
                echo "Error: " . $sql_insert . "<br>" . mysqli_error($conn);
            }
        } else {
            //Báo lỗi không thể upload file
            echo "Sorry, there was an error uploading your file.";
        }
    }
    
    //Kiểm tra xem đã thực hiện thao tác logout chưa, nếu rồi nó sẽ destroy phiên làm việc này và chuyển hướng đến login
    if (isset($_POST["logout"])) {
        session_destroy();
        header("location:../login.php");
    }

    if (isset($_POST["go_home"])) {
        header("location:../index.php");
    }

    if (isset($_POST["go_manager_ticket"])) {
        header("location:manager_ticket.php");
    }

    //Xóa
    if (isset($_GET["task"]) && $_GET["task"] == "delete") {
        $id = $_GET["id"];
        $sql_delete = "delete from type_ticket where type_id = " . $id;
        if (mysqli_query($conn, $sql_delete)) {
            header("location:type_ticket.php");
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    //Xóa theo chọn
    if (isset($_POST["delete_check"])) {
        $type_id = $_POST["cate"];
        foreach ($type_id as $c) {
            $sql_delete = "delete from type_ticket where type_id = " . $c;
            if (mysqli_query($conn, $sql_delete)) {
                header("location:type_ticket.php");
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }

?>

<html>
    <head>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
    </head>

    <body>
        <div class="container">
            <h1 style="text-align: center;">Trang quản trị loại vé</h1>
            <div class="row">
                <div class="col-6">
                    <form action="type_ticket.php" method="post" enctype="multipart/form-data">
                        Địa điểm biểu diễn:
                        <input class="form-control" type="text" name="txt_location" id="">
                        <br>
                        Hạng vé:
                        <input class="form-control" type="text" name="type_ticket" id="">
                        <br>
                        Ngày trình diễn:
                        <input class="form-control" type="date" name="date_date_view" id="">
                        <br>
                        <input class="form-control" type="file" name="file_upload">
                        <br>
                        <input class="btn btn-success" type="submit" value="Thêm loại vé" name="add_ticket" id="">
                        <br>
                        <br>
                        Tìm kiếm địa điểm:
                        <input class="form-control" type="text" name="txt_search" id="">
                        <br>
                        <input class="btn btn-success" type="submit" value="Tim kiem" name="search" id="">
                    </form>
                </div>
            </div>
            <?php
            // BƯỚC 2: TÌM TỔNG SỐ RECORDS
            $result = mysqli_query($conn, 'select count(type_id) as total from type_ticket');
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
            ?>
            <div class="row">
                <div class="col-12">
                    <table class="table table-striped">
                        <tr>
                            <th>Mã loại vé</th>
                            <th>Hạng vé</th>
                            <th>Địa điểm</th>
                            <th>Ngày diễn</th>
                            <th>Ảnh địa điểm</th>
                            <th>Thao tác</th>
                            <th>Chọn</th>
                        </tr>
                        <form action="type_ticket.php" method="post">
                            <input style="margin-right: 10px;" type="submit" value="Xóa theo chọn" name="delete_check" class="btn btn-info" id="">
                            <input style="margin-right: 10px;" type="submit" value="Xóa tất cả" name="delete_all" class="btn btn-danger" id="">
                            <input style="margin-right: 10px;" type="submit" value="Đăng xuất" name="logout" class="btn btn-primary" id="">
                            <input style="margin-right: 10px;" type="submit" value="Về trang chủ" name="go_home" class="btn btn-primary" id="">
                            <input style="margin-right: 10px;" type="submit" value="Quản lý mua vé" name="go_manager_ticket" class="btn btn-primary" id="">
                            <br>
                            <br>
                            <?php
                            // PHẦN HIỂN THỊ TIN TỨC
                            // BƯỚC 6: HIỂN THỊ DANH SÁCH TIN TỨC
                            $sql = "";
                            if (isset($_POST["search"])) {
                                $location = $_POST['txt_search'];
                                $sql = "select * from type_ticket where location like '%" . $location . "%'";
                            } else
                                $sql = "select * from type_ticket LIMIT " . $start . "," . $limit;
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                        echo "<td>" . $row["type_id"] . "</td>";
                                        echo "<td>".$row["type_ticket"]."</td>";
                                        echo "<td>" . $row["location"] . "</td>";
                                        echo "<td>" . $row["date_view"] . "</td>";
                                        echo "<td><img style='height: 50px; width: 100px;' src='" . $row["link_img"] . "'></td>";
                                        echo "<td>";
                                            echo "<a style='margin-right: 10px;' class='btn btn-warning' href='update_cate.php?task=update&id=" . $row["type_id"] . "'>Sua</a>";
                                            echo "<a class='btn btn-danger' href='type_ticket.php?task=delete&id=" . $row["type_id"] . "'>Xoa</a>";
                                        echo "</td>";
                                        echo "<td>";
                                            echo "<input type = 'checkbox' name= 'cate[]' value= '" . $row["type_id"] . "' class= 'form-check-input''>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "Empty data";
                            }
                            ?>
                        </form>
                    </table>
                </div>
                <div class="pagination">
                    <?php
                    // PHẦN HIỂN THỊ PHÂN TRANG
                    // BƯỚC 7: HIỂN THỊ PHÂN TRANG

                    // nếu current_page > 1 và total_page > 1 mới hiển thị nút prev
                    if ($current_page > 1 && $total_page > 1) {
                        echo '<a href="type_ticket.php?page=' . ($current_page - 1) . '">Prev</a> | ';
                    }

                    // Lặp khoảng giữa
                    for ($i = 1; $i <= $total_page; $i++) {
                        // Nếu là trang hiện tại thì hiển thị thẻ span
                        // ngược lại hiển thị thẻ a
                        if ($i == $current_page) {
                            echo '<span>' . $i . '</span> | ';
                        } else {
                            echo '<a href="type_ticket.php?page=' . $i . '">' . $i . '</a> | ';
                        }
                    }

                    // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
                    if ($current_page < $total_page && $total_page > 1) {
                        echo '<a href="type_ticket.php?page=' . ($current_page + 1) . '">Next</a> | ';
                    }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>