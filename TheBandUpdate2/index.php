<?php
    require("config.php");
    //Dùng để tái sử dụng lại các biến trong config.php đã dùng để liên kết database
    session_start();
    //Câu lệnh dưới để che đi warning
    error_reporting(E_ERROR | E_PARSE);

    if (isset($_POST["send_message"])) {
        //Kiểm tra xem nút send_message đã được ấn hay chưa bằng cách kiểm tra biến $_POST["btn_insert"] có tồn tại hay không
        $user_id = $_SESSION["user"];
        $user_name = $_POST["txt_user_name"];
        $email = $_POST["txt_email"];
        $content = $_POST["txt_content"];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date('Y/m/d', time());
        $sql_insert = "insert into tbl_comment(user_id, user_name, email, content, post_date) values('" . $user_id . "','" . $user_name . "','" . $email . "','" . $content . "','" . $date . "')";
        if (mysqli_query($conn, $sql_insert)) {
            //Thực hiện truy vấn đối tượng kết nối $conn và insert dữ liệu phía trên nếu thực hiện thành công thì chuyển hướng đến category
            header("location: index.php");
            //echo "New record created successfully";
        } else {
            //Nếu sai thì báo lỗi 
            echo "Error: " . $sql_insert . "<br>" . mysqli_error($conn);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The band</title>
    <link rel="stylesheet" href="css/style_index.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="js/bootstrap.bundle.min.js">
    <!-- <link rel="stylesheet" href="css/style_new.css"> -->
    <script src="js/bootstrap.bundle.js"></script>
</head>
<body>
    <div id="main">
        <div id="header" style="background-color: #0D6EFD;">
            <!-- Begin: Nav -->
            <ul id="nav">
                <li><a style="color: #000; font-weight: bold;" href="#">Home</a></li>
                <li><a style="color: #000; font-weight: bold;" href="#band">Band</a></li>
                <li><a style="color: #000; font-weight: bold;" href="#tour">Tour</a></li>
                <li><a style="color: #000; font-weight: bold;" href="#contact">Contact</a></li>
                <li>
                    <a style="color: #000; font-weight: bold;" href="">
                        More 
                        <i class="nav-arrow-down ti-angle-down"></i>
                    </a>
                    <ul class="subnav">
                        <li><a style="font-weight: bold;"  href="#">Merchandise</a></li>
                        <li><a style="font-weight: bold;"  href="#">Extras</a></li>
                        <li><a style="font-weight: bold;"  href="#">Media</a></li>
                        
                    </ul>
                </li>
                <li>
                    <?php
                        //Kiem tra xem dang nhap hay chua
                        if (!$_SESSION["user"]) {
                            //nếu tên user không tồn tại thì nó sẽ chuyển hướng đến login
                            echo'<ul id="singin_singout">';
                                echo'<li class="Sing_in" ><a style="color: #000; font-weight: bold;" href="login.php">Sign in</a></li>';
                                echo'<li class="Sing_out" ><a style="color: #000; font-weight: bold;" href="register.php">Sign up</a></li>';
                            echo'</ul>';
                        } elseif ($role !=0) {
                            //nếu tên user đã tồn tại thì in ra dòng dưới
                            // echo "Xin chào thành viên " . $_SESSION["user"];
                            echo'<form action="index.php" method="post">';
                                echo "Xin chào thành viên " . $_SESSION["user"];
                                echo'<input style="margin-top: -4px" class="btn btn-danger" type="submit" name="logout" value="Đăng xuất" id="">';
                            echo'</form>';
                        }
                        else {
                            echo'<form action="index.php" method="post">';
                                echo "Xin chào thành viên " . $_SESSION["user"];
                                echo'<input style="margin-top: -4px" class="btn btn-danger" type="submit" name="logout" value="Đăng xuất" id="">';
                                echo'<input style="margin-top: -4px" class="btn btn-danger" type="submit" name="admin" value="Admin" id="">';
                            echo'</form>';
                        }
                    ?>
                </li>         
            </ul>
            
            <?php
                //Kiểm tra xem đã thực hiện thao tác logout chưa, nếu rồi nó sẽ destroy phiên làm việc này và chuyển hướng đến login
                if (isset($_POST["logout"])) {
                    session_destroy();
                    header("location:login.php");
                }

                if (isset($_POST["admin"])) {
                    session_destroy();
                    header("location:admin/type_ticket.php");
                }

            ?>
            
            <!-- End: Nav -->

            <!-- Begin: Search button -->
            <!-- <div class="search-btn">
                <i class="search-icon ti-search"></i>
            </div> -->
            <!-- End: Search button -->
        </div>

        <div id="slider">
            <div id="carouselExampleIndicators" class="carousel slide">
                            <div class="carousel-indicators">
                              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 3"></button>
                              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 3"></button>
                            </div>
                            <div class="carousel-inner" style="padding: 0px;">
                              <div class="carousel-item active">
                                <img style="height: 500px;" src="img/places/place1.jpg" class="d-block w-100" alt="...">
                              </div>
                              <div class="carousel-item">
                                <img style="height: 500px;" src="img/places/place2.jpg" class="d-block w-100" alt="...">
                              </div>
                              <div class="carousel-item">
                                <img style="height: 500px;" src="img/places/place3.jpg" class="d-block w-100" alt="...">
                              </div>
                              <div class="carousel-item">
                                <img style="height: 500px;" src="img/places/place1.jpg" class="d-block w-100" alt="...">
                              </div>
                              <div class="carousel-item">
                                <img style="height: 500px;" src="img/places/place2.jpg" class="d-block w-100" alt="...">
                              </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Next</span>
                            </button>
                          </div>
            <div class="text-content">
                <h2 style="color: red;" class="text-heading">New York</h2>
                <div style="color: red;" class="text-description">The atmosphere in New York is lorem ipsum.</div>
            </div>
        </div>

        <div id="content">
            <!-- About section -->
            <div id="band" class="content-section">
                <h2 class="section-heading">THE BAND</h2>
                <p class="section-sub-heading">We love music</p>
                <p class="about-text">
                    We have created a fictional band website. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
                <div class="row members-list">
                    <div class="col col-third text-center">
                        <p class="member-name">Name</p>
                        <img src="img/band/member1.jpg" alt="Name" class="member-img">
                    </div>
                    <div class="col col-third text-center">
                        <p class="member-name">Name</p>
                        <img src="img/band/member1.jpg" alt="Name" class="member-img">
                    </div>
                    <div class="col col-third text-center">
                        <p class="member-name">Name</p>
                        <img src="img/band/member1.jpg" alt="Name" class="member-img">
                    </div>
                </div>
            </div>

            <!-- Tour section -->
            <div id="tour" class="tour-section">
                <div class="content-section">
                    <h2 class="section-heading text-while">TOUR DATES</h2>
                    <p class="section-sub-heading text-while">Remember to book your tickets!</p>
                    
                    <!-- Tickets -->
                    <ul class="tickets-list">
                        <li>September <span class="sold-out">Sold out</span></li>
                        <li>October <span class="sold-out">Sold out</span></li>
                        <li>November <span class="quantity">3</span></li>
                    </ul>

                    <!-- Places -->
                    <div class="row places-list">
                        <div class="col col-third">
                            <img src="img/places/place1.jpg" alt="New York" class="place-img">
                            <div class="place-body">
                                <h3 class="place-heading">New York</h3>
                                <p class="place-time">Fri 27 Nov 2016</p>
                                <p class="place-desc">Praesent tincidunt sed tellus ut rutrum sed vitae justo.</p>
                                <!-- <button class="js-buy-ticket btn" id="buy_tickets_button">Buy Tickets</button> -->
                                <a class="btn btn-primary" href="buy_ticket.php">Buy Tickets</a>
                            </div>
                        </div>
                        <div class="col col-third">
                            <img src="img/places/place2.jpg" alt="New York" class="place-img">
                            <div class="place-body">
                                <h3 class="place-heading">Paris</h3>
                                <p class="place-time">Sat 28 Nov 2016</p>
                                <p class="place-desc">Praesent tincidunt sed tellus ut rutrum sed vitae justo.</p>
                                <!-- <button class="js-buy-ticket btn" id="buy_tickets_button">Buy Tickets</button> -->
                                <a class="btn btn-primary" href="buy_ticket.php">Buy Tickets</a>
                            </div>
                        </div>
                        <div class="col col-third">
                            <img src="img/places/place3.jpg" alt="New York" class="place-img">
                            <div class="place-body">
                                <h3 class="place-heading">San Francisco</h3>
                                <p class="place-time">Sun 29 Nov 2016</p>
                                <p class="place-desc">Praesent tincidunt sed tellus ut rutrum sed vitae justo.</p>
                                <!-- <button class="js-buy-ticket btn" id="buy_tickets_button">Buy Tickets</button> -->
                                <a class="btn btn-primary" href="buy_ticket.php">Buy Tickets</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

             <!-- Begin: Contact section -->
             <div id="contact" class="content-section">
                <h2 class="section-heading">CONTACT</h2>
                <p class="section-sub-heading">Fan? Drop a note!</p>
                
                <div class="row contact-content">
                    <div class="col col-half contact-info">
                        <div class="row" id="information">
                                    <div class="location">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                            <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10"/>
                                            <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                                        </svg>
                                        Chicago, US
                                    </div>
                                    <div class="location">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                                            <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                                        </svg>
                                        Phone: +00 151515
                                    </div>
                                    <div class="location">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
                                        </svg>
                                        Email: mail@mail.com
                                    </div>
                                </div>
                        </div>
                    <div class="col col-half contact-form">
                        <form action="index.php" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col col-half">
                                    <input type="text" name="txt_user_name" placeholder="Name" required id="" class="form-control">
                                </div>
                                <div class="col col-half">
                                    <input type="email" name="txt_email" placeholder="Email" required id="" class="form-control">
                                </div>
                            </div>
                            <div class="row mt-8">
                                <div class="col col-full">
                                    <input type="text" name="txt_content" placeholder="Message" required id="" class="form-control">
                                </div>
                            </div>
                            <input id="send_button" name="send_message" type="submit" value="SEND">
                        </form>
                    </div>
                </div>

                <div class="container">
                    <br>
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
                                </tr>
                                <form action="tbl_comment.php" method="post">
                                    <?php
                                    // PHẦN HIỂN THỊ TIN TỨC
                                    // BƯỚC 6: HIỂN THỊ DANH SÁCH TIN TỨC
                                    $sql = "";
                                    $sql = "select * from tbl_comment LIMIT " . $start . "," . $limit;
                                    $result = mysqli_query($conn, $sql);
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>" . $row["user_name"] . "</td>";
                                            echo "<td>" . $row["email"] . "</td>";
                                            echo "<td>" . $row["content"] . "</td>";
                                            echo "<td>" . $row["post_date"] . "</td>";
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
                                echo '<a href="index.php?page=' . ($current_page - 1) . '">Prev</a> | ';
                            }

                            // Lặp khoảng giữa
                            for ($i = 1; $i <= $total_page; $i++) {
                                // Nếu là trang hiện tại thì hiển thị thẻ span
                                // ngược lại hiển thị thẻ a
                                if ($i == $current_page) {
                                    echo '<span>' . $i . '</span> | ';
                                } else {
                                    echo '<a href="index.php?page=' . $i . '">' . $i . '</a> | ';
                                }
                            }

                            // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
                            if ($current_page < $total_page && $total_page > 1) {
                                echo '<a href="index.php?page=' . ($current_page + 1) . '">Next</a> | ';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End: Contact section -->

            <div class="map-section">
                <img src="img/map/map.jpg" alt="">
            </div>
        </div>

        <div id="footer">
            <div class="social-list">
                <p>
                    <a href="">
                    <svg class=" icon_1" xmlns="http://www.w3.org/2000/svg"  fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
                        </svg>
                    </a>
                    <a href="">
                    <svg class=" icon_1" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                            <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
                        </svg>
                    </a>
                    <a href="">
                    <svg class=" icon_1" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                            <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8"/>
                        </svg>
                    </a>
                    <a href="">
                    <svg class=" icon_1" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-pinterest" viewBox="0 0 16 16">
                            <path d="M8 0a8 8 0 0 0-2.915 15.452c-.07-.633-.134-1.606.027-2.297.146-.625.938-3.977.938-3.977s-.239-.479-.239-1.187c0-1.113.645-1.943 1.448-1.943.682 0 1.012.512 1.012 1.127 0 .686-.437 1.712-.663 2.663-.188.796.4 1.446 1.185 1.446 1.422 0 2.515-1.5 2.515-3.664 0-1.915-1.377-3.254-3.342-3.254-2.276 0-3.612 1.707-3.612 3.471 0 .688.265 1.425.595 1.826a.24.24 0 0 1 .056.23c-.061.252-.196.796-.222.907-.035.146-.116.177-.268.107-1-.465-1.624-1.926-1.624-3.1 0-2.523 1.834-4.84 5.286-4.84 2.775 0 4.932 1.977 4.932 4.62 0 2.757-1.739 4.976-4.151 4.976-.811 0-1.573-.421-1.834-.919l-.498 1.902c-.181.695-.669 1.566-.995 2.097A8 8 0 1 0 8 0"/>
                        </svg>
                    </a>
                    <a href="">
                    <svg class=" icon_1" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                            <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15"/>
                        </svg>
                    </a>
                    <a href="">
                    <svg class=" icon_1" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                            <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401m-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4"/>
                        </svg>
                    </a>
                </p>
            </div>
            <p class="copyright">Powered by <a href="">w3.css</a></p>
        </div>
    </div>

    <div class="modal js-modal">
        <div class="modal-container js-modalContainer">
            <div class="modal-close js-modal-close">
                <i class="ti-close"></i>
            </div>

            <header class="modal-header">
                <!-- <i class="modal-heading-icon ti-bag"></i> -->
                <p id="modal_header">Tickets</p>
            </header>

            <div class="modal-body">
                <label for="ticket-quantity" class="modal-label">
                    <i class="ti-shopping-cart"></i>
                    Tickets, $15 pre person
                </label>
                <input id="ticket-quantity" type="text" class="modal-input" placeholder="How many?"> 
                
                <label for="ticket-email" class="modal-label">
                    <i class="ti-user"></i>
                    Send to
                </label>
                <input id="ticket-email" type="email" class="modal-input" placeholder="Enter email..."> 
            
                <button id="buy-tickets">
                    Pay
                    <i class="ti-check"></i>
                </button>
            </div>

            <footer class="modal-footer">
                <p class="modal-help">Need <a href="#">help?</a></p>
            </footer>
        </div>
    </div>

    <script>
        const buyBtns = document.querySelectorAll('.js-buy-ticket')
        const modal = document.querySelector('.js-modal')
        const modalContainer = document.querySelector('.js-modalContainer')
        const modalClose = document.querySelector('.js-modal-close')

        //Hàm hiển thị modal mua vé (thêm class open vào modal)
        function showBuyTickets() {
            modal.classList.add('open')
        }

        //Hàm ẩn modal mua vé (xóa class open vào modal)
        function hideBuyTickets() {
            modal.classList.remove('open')
        }

        //Lặp qua từng thẻ button và nghe hành vi click
        for (const buyBtn of buyBtns) {
            buyBtn.addEventListener('click', showBuyTickets)
        }

        //Nghe hành vi click vào button close
        modalClose.addEventListener('click', hideBuyTickets)
        
        //Nghe hành vi click ở phần bên ngoài modal-container để close lại
        modal.addEventListener('click', hideBuyTickets)

        //Nghe hành vi click ở phía trong modal-container và ngăn nó đóng
        modalContainer.addEventListener('click', function (event) {
            //Hàm ngăn sự kiện nổi bọt khi gặp modal-container
            event.stopPropagation()
        })
    </script>
</body>
</html>