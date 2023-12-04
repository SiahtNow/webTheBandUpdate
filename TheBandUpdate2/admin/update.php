<?php
    require("../config.php");
    // Kiểm tra xem người dùng đã chọn cập nhật chưa
    if(isset($_POST["btn_update"])){
        $id = $_POST["txt_type_id"];
        $location = $_POST["txt_cate_name"];
        $date_view = $_POST["txt_date"];
        $sql_update = "update type_ticket set location =N'".$location."', date_view ='".$date_view."' where type_id=".$id;
        if(mysqli_query($conn,$sql_update)){
            echo 'New record created ';
        header("location:type_ticket.php");
        } else{
        echo "Error: " . $sql_update. "<br>" . mysqli_error($conn);
        }

    }

?>

<html>
    <head>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body >
        <div class="container">
            <div class="row">
                <h1 style="text-align: center;">Trang quản trị danh mục</h1>
                <div class="col-6">
                    <!-- nếu method ="get" dễ bị lộ thông tin(gửi dl đi và hiển thị thông tin trên url)  -->
                    <form action="update.php" method="post">
                        <?php
                            if(isset($_GET["task"]) && $_GET["task"]=="update"){
                                $id = $_GET["id"];
                                $sql_select = "select * from type_ticket where type_id = ".$id;
                                $result = mysqli_query($conn,$sql_select);
                                if(mysqli_num_rows($result)>0){
                                    while($row = mysqli_fetch_assoc($result)){
                                       
                                        echo "<input type = 'hidden' name='txt_type_id' value='".$row["type_id"]."'>";
                                        echo "Nhập lại địa điểm: ";
                                        echo "<input value='".$row["location"]."' class = 'form-control' type = 'text' name='txt_cate_name'>";
                                        echo "<br>";
                                        echo "Nhập lại ngày xem: ";
                                        echo "<input value='".$row["date_view"]."' class='form-control' type='date' name='txt_date'>";
                                        echo "<br>";
                                    }

                                }
                            }  
                        ?>                   
                        <input class="btn btn-primary" type="submit"  value="Cập nhật" name="btn_update">
                    </form>

                </div>

            </div>
            <div class="row">
                <div class="col-12">
                    

                </div>

            </div>
        </div>        
    </body>
</html>