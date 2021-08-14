<?php
session_start();
require_once "admin/adminFunction.php";
$conn = connect();
?>
<?php
// Functions to filter user inputs
function filterName($field){
    // Làm sạch tên người dùng
    $field = filter_var(trim($field), FILTER_SANITIZE_STRING);
    
    // Xác thực tên người dùng
    if(filter_var($field, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        return $field;
    } else{
        return FALSE;
    }
}  
function filtersurName($field){
    // Làm sạch tên người dùng
    $field = filter_var(trim($field), FILTER_SANITIZE_STRING);
    
    // Xác thực tên người dùng
    if(filter_var($field, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        return $field;
    } else{
        return FALSE;
    }
}  
function filterPhone($field){
    // Làm sạch tên người dùng
    $field = filter_var(trim($field), FILTER_SANITIZE_NUMBER_INT);
    
    // Xác thực Email
    if(filter_var($field, FILTER_VALIDATE_INT)){
        return $field;
    } else{
        return FALSE;
    }
}  
function filterEmail($field){
    // Làm sạch Email
    $field = filter_var(trim($field), FILTER_SANITIZE_EMAIL);
    
    // Xác thực Email
    if(filter_var($field, FILTER_VALIDATE_EMAIL)){
        return $field;
    } else{
        return FALSE;
    }
}
function filterString($field){
    // Làm sạch nội dung
    $field = filter_var(trim($field), FILTER_SANITIZE_STRING);
    if(!empty($field)){
        return $field;
    } else{
        return FALSE;
    }
}
 
// Khai báo biến và khởi tạo các giá trị trống
$nameErr = $surnameErr = $phoneErr = $emailErr = $messageErr = "";
$name = $surname = $phone = $email = $subject = $message = "";
 
// Xử lý dữ liệu biểu mẫu khi biểu mẫu được gửi
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Xác thực tên người dùng
    if(empty($_POST["name"])){
        $nameErr = "Nhập tên của bạn.";
    } else{
        $name = filterName($_POST["name"]);
        if($name == FALSE){
            $nameErr = "Nhập tên hợp lệ.";
        }
    }

    if(empty($_POST["surname"])){
        $surnameErr = "Nhập tên của bạn.";
    } else{
        $surname = filtersurName($_POST["surname"]);
        if($surname == FALSE){
            $surnameErr = "Nhập tên hợp lệ.";
        }
    }

    if(empty($_POST["phone"])){
        $phoneErr = "Nhập phone của bạn.";
    } else{
        $phone = filterPhone($_POST["phone"]);
        if($phone == FALSE){
            $phoneErr = "Enter a valid phone number";
            header("location:contact.php");
            exit();
        }
    }
    
    // Xác thực Email
    if(empty($_POST["email"])){
        $emailErr = "Nhập địa chỉ Email.";     
    } else{
        $email = filterEmail($_POST["email"]);
        if($email == FALSE){
            $emailErr = "Enter a valid email";
            header("location:contact.php");
            exit();
        }
    }
    
    // Xác thực số điện thoại
    // if(empty($_POST["subject"])){
    //     $subject = "";
    // } else{
    //     $subject = filterString($_POST["subject"]);
    // }
    
    // Xác thực nội dung
    if(empty($_POST["message"])){
        $messageErr = "Điền nhận xét.";     
    } else{
        $message = filterString($_POST["message"]);
        if($message == FALSE){
            $messageErr = "Điền nhận xét hợp lệ.";
        }
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <script src="js/norepeat.js"></script>
    <script src="js/infomation.js"></script>
    <script>
        var input = document.getElementById('form_message');
        input.oninvalid = function(event) {
    event.target.setCustomValidity('Message should only contain lowercase letters. e.g. john');
}
    </script>
    <!-- jquery cdn-->
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <!-- way point plugin-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.js"></script>
    <!-- count up plugin (fixed bug decrease counting number when scroll to counting section again)-->
    <script src="vendor/counter up/jquery.counterup.js"></script>
    <!-- swiper.js-->
    <script src="vendor/swiper/swiper.min.js"></script>
    <!-- import fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <!-- Bootstrap-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- font awesome-->
    <link rel="stylesheet" href="vendor/fontawesome/css/all.css">
    <!-- swiper-->
    <link rel="stylesheet" href="vendor/swiper/swiper.min.css">
    <!--customer stylesheet-->
    <link rel="stylesheet" href="css/index_style.css">
    <link rel="stylesheet" href="css/home.css">
    <!-- customer javascript-->
    <script src="js/showMenuOnScroll.js"></script>
    <script src="js/toggleMenu.js"></script>
    <script src="js/DropMenu.js"></script>
    <script src="js/ScrollToTop.js"></script>
    <script src="js/validateForm.js" async></script>
</head>

<body>
    <div id="page">
        <div id="head">
            <div id="nav">
                <!--begin nav-->
                <!-- responsive -->
                <button class="hamburger">
                    <span></span>
                </button>

                <div id="menu">
                    <div id="logo">
                        <a href="index.php#about"><img src="imgs/logo.png" alt="logo"></a>
                    </div>

                    <a href="/starorganic/project2/">Home</a>
                    <div class="dropdown-item">
                        <a href="#" id="drop">Product <span class="cheveron"></span></a>
                        <div class="subitem">
                            <?php
                            $prd = $conn->query("SELECT * FROM category WHERE status = 1");
                            while ($row = $prd->fetch_assoc()) {
                                echo "
                                    <a href='product.php?id={$row['categoryID']}#prd'>{$row['categoryName']}</a>
                                ";
                            }
                            ?>
                        </div>
                    </div>
                    <a href="contact.php">Contact Us</a>
                    <a href="gallery.php">Gallery</a>
                </div>
                <!-- Search  -->
                <!-- <div id="search-box">
                    <input type="text" name="search-text" placeholder="Type to search">
                    <a href="#" id="search-btn">
                        <i class="fas fa-search"></i>
                    </a>
                </div> -->

            </div><!-- end nav-->
            <!-- Banner -->
            <div id="banner">
                <!--Begin banner-->
                <img src="imgs/logo.png" alt="logo-banner" id="logo-img">
                <p class="welcome">Contact Us</p>
                <h1 class="introduction">Let us know, I know what you're thinking</h1>
            </div>
            <!--End banner-->
        </div>
        <!--End head-->

        <!-- Begin container -->
        <div class="container">

            <div class="row">

                <div id="ct" class="col-lg-8 col-lg-offset-2">
                    <h1 class="contact_heading">Talk to us</h1>
                    <span class="separator"></span>
                    <h5 style="text-align:center">Do you need something specical? <br>Or you want to help us improve our services by providing your feedback? <br>Please let us know.</h5><br>
                    <form id="contact-form" method="post" role="form">

                        <div class="messages"></div>

                        <div class="controls">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form_name">Firstname *</label>
                                        <input id="form_name" type="text" name="name" class="form-control" placeholder="Please enter your firstname *" required="required" data-error="Firstname is required." value="<?php echo $name; ?>">
                                        <span class="error"><?php echo $nameErr; ?></span>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form_lastname">Lastname *</label>
                                        <input id="form_lastname" type="text" name="surname" class="form-control" placeholder="Please enter your lastname *" required="required" data-error="Lastname is required." value="<?php echo $surname; ?>">
                                        <span class="error"><?php echo $surnameErr; ?></span>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form_email">Email *</label>
                                        <input id="form_email" type="email" name="email" class="form-control" placeholder="Please enter your email *" required="required" data-error="Valid email is required." value="<?php echo $email; ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                                        <span class="error"><?php echo $emailErr; ?></span>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form_phone">Phone *</label>
                                        <input id="form_phone" type="tel" name="phone" class="form-control" required="required" placeholder="Please enter your phone *" data-error="Valid phone is required" value="<?php echo $phone; ?>" >
                                        <span class="error"><?php echo $phoneErr; ?></span>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="form_message">Message *</label>
                                        <textarea id="form_message" name="message" class="form-control" placeholder="Message for me *" rows="4" required="required" data-error="Please,leave us a message." pattern="[a-z]{1,15}"><?php echo $message; ?></textarea>
                                        <span class="error"><?php echo $messageErr; ?></span>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" name="ok" class="btn btn-success btn-send" value="Send message" onclick="send()">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <br>
                                    <p class="text-muted"><strong>*</strong> These fields are required. Contact form by <a href="index.php" target="_blank">Star Organic</a>.</p>
                                </div>
                            </div>
                        </div>

                    </form>
                    <?php
                    if (isset($_POST['ok'])) {
                        include_once 'function.php';
                        $obj = new Contact();
                        $res = $obj->contact_us($_POST);
                        if ($res == true) {
                            echo "<script>alert('Query successfully Submitted.Thank you')</script>";
                        } else {
                            echo "<script>alert('Something Went wrong!!')</script>";
                        }
                    }
                    ?>
                
                </div><!-- /.8 -->

            </div> <!-- /.row-->

        </div> <!-- /.container-->

        <!-- Begin location  -->
        <div id="location">
            <div class="location-text">
                <span class="separator"></span>
                <h3>Where can you find us?</h3>
                <span class="separator"></span>
            </div>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.9231238519315!2d105.81679641440749!3d21.035761792916315!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab0d127a01e7%3A0xab069cd4eaa76ff2!2zMjg1IMSQ4buZaSBD4bqlbiwgVsSpbmggUGjDuiwgQmEgxJDDrG5oLCBIw6AgTuG7mWkgMTAwMDAwLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1627045417756!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            <div id="location-info" class="row">
                <div class="location-detail col-md-4">
                    <i class="fas fa-phone-square-alt"></i>
                    <p><span>Phone number:</span><br /><b>0123 456 789</b></p>
                </div>
                <div class="location-detail col-md-4 ">
                    <i class="fas fa-at"></i>
                    <p><span>Email:</span><br /><b>starorganic.work@gmail.com</b></p>
                </div>
                <div class="location-detail col-md-4 ">
                    <i class="fas fa-search-location"></i>
                    <p><span>Our Location</span><br /><b>285<sup>th</sup>Doi Can street, Ba Dinh, Ha Noi, Vietnam</b>
                    </p>
                </div>
            </div>
        </div> <!-- end location div-->
    </div>
    <!--End content div-->

    <!-- Begin foot div -->
    <div id="foot">
        <div id="copyrights">
            Copyright & copy <?= date("Y") ?>. All rights reserved by Brothers In Farm
        </div>
        <div id="social-media">
            <a href="http://fb.com"><i class="fab fa-facebook-square"></i></a>
            <a href="http://instagram.com"><i class="fab fa-instagram"></i></a>
            <a href="http://twitter.com"><i class="fab fa-twitter-square"></i></a>
        </div>
    </div>
    <!--End foot div-->
    </div>
    <!--End page-->
    <a href="#" class="UpToTop"><i class="fas fa-arrow-up"></i></a>
</body>

</html>