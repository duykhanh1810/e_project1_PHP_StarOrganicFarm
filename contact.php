<?php
session_start();
require_once "admin/adminFunction.php";
$conn = connect();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <script src="js/norepeat.js"></script>
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

                    <a href="index.php">Home</a>
                    <div class="dropdown-item">
                        <a href="#" id="drop">Product <span class="cheveron"></span></a>
                        <div class="subitem">
                            <?php
                            $prd = $conn->query("SELECT * FROM category");
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
                <div id="search-box">
                    <input type="text" name="search-text" placeholder="Type to search">
                    <a href="#" id="search-btn">
                        <i class="fas fa-search"></i>
                    </a>
                </div>

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

                <div class="col-lg-8 col-lg-offset-2">
                    <h1 class="contact_heading">Talk to us</h1>
                    <span class="separator"></span>

                    <form id="contact-form" method="post" role="form">

                        <div class="messages"></div>

                        <div class="controls">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form_name">Firstname *</label>
                                        <input id="form_name" type="text" name="name" class="form-control" placeholder="Please enter your firstname *" required="required" data-error="Firstname is required.">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form_lastname">Lastname *</label>
                                        <input id="form_lastname" type="text" name="surname" class="form-control" placeholder="Please enter your lastname *" required="required" data-error="Lastname is required.">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form_email">Email *</label>
                                        <input id="form_email" type="email" name="email" class="form-control" placeholder="Please enter your email *" required="required" data-error="Valid email is required.">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form_phone">Phone</label>
                                        <input id="form_phone" type="tel" name="phone" class="form-control" placeholder="Please enter your phone">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="form_message">Message *</label>
                                        <textarea id="form_message" name="message" class="form-control" placeholder="Message for me *" rows="4" required="required" data-error="Please,leave us a message."></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" name="ok" class="btn btn-success btn-send" value="Send message">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
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
            Copyright & copy 2021. All rights reserved by Agricultural brothers
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