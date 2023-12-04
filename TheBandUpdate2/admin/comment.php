<?php
    //Tái sử dụng config.php
    require("../config.php");
    //Xóa
    if (isset($_GET["task"]) && $_GET["task"] == "delete") {
        $id = $_GET["id"];
        $sql_delete = "delete from tbl_comment where message_id = " . $id;
        if (mysqli_query($conn, $sql_delete)) {
            header("location:comment.php");
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    //Xóa theo chọn
    if (isset($_POST["delete_check"])) {
        $message_id = $_POST["cate"];
        foreach ($message_id as $c) {
            $sql_delete = "delete from tbl_comment where message_id = " . $c;
            if (mysqli_query($conn, $sql_delete)) {
                header("location:comment.php");
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }
?>

<html>
    <head>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>
        <div class="container">
            <h1 style="text-align: center;">Trang quản trị bình luận</h1>
            <div class="row">
                <div class="col-6">
                    <form action="comment.php" method="post" enctype="multipart/form-data">
                        Tìm kiếm bình luận:
                        <input class="form-control" type="text" name="txt_search" id="">
                        <br>
                        <input class="btn btn-success" type="submit" value="Tìm kiếm" name="search" id="">
                    </form>
                </div>
            </div>
            <?php
            // BƯỚC 2: TÌM TỔNG SỐ RECORDS
            $result = mysqli_query($conn, 'select count(message_id) as total from tbl_comment');
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
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Nội dung</th>
                            <th>Thời gian</th>
                            <th>Thao tác</th>
                            <th>Chọn</th>
                        </tr>
                        <form action="comment.php" method="post">
                            <input style="margin-right: 10px;" type="submit" value="Xóa theo chọn" name="delete_check" class="btn btn-info" id="">
                            <br>
                            <br>
                            <?php
                            // PHẦN HIỂN THỊ TIN TỨC
                            // BƯỚC 6: HIỂN THỊ DANH SÁCH TIN TỨC
                            $sql = "";
                            if (isset($_POST["search"])) {
                                $user_name = $_POST['txt_search'];
                                $sql = "select * from tbl_comment where user_name like '%" . $user_name . "%'";
                            } else
                                $sql = "select * from tbl_comment LIMIT " . $start . "," . $limit;
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row["user_name"] . "</td>";
                                    echo "<td>" . $row["email"] . "</td>";
                                    echo "<td>" . $row["content"] . "</td>";
                                    echo "<td>" . $row["post_date"] . "</td>";
                                    echo "<td>";
                                    echo "<a style='margin-right: 10px;' class='btn btn-warning' href='update.php?task=update&id=" . $row["message_id"] . "'>Sửa</a>";
                                    echo "<a class='btn btn-danger' href='comment.php?task=delete&id=" . $row["message_id"] . "'>Xóa</a>";
                                    echo "</td>";
                                    echo "<td>";
                                    echo "<input type = 'checkbox' name= 'cate[]' value= '" . $row["message_id"] . "' class= 'form-check-input''>";
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
                        echo '<a href="comment.php?page=' . ($current_page - 1) . '">Prev</a> | ';
                    }

                    // Lặp khoảng giữa
                    for ($i = 1; $i <= $total_page; $i++) {
                        // Nếu là trang hiện tại thì hiển thị thẻ span
                        // ngược lại hiển thị thẻ a
                        if ($i == $current_page) {
                            echo '<span>' . $i . '</span> | ';
                        } else {
                            echo '<a href="comment.php?page=' . $i . '">' . $i . '</a> | ';
                        }
                    }

                    // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
                    if ($current_page < $total_page && $total_page > 1) {
                        echo '<a href="comment.php?page=' . ($current_page + 1) . '">Next</a> | ';
                    }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>