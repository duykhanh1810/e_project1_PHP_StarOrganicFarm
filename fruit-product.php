<?php session_start();
require "admin/adminFunction.php";
$conn = connect();
$product = $conn->query("SELECT * FROM product 
                        INNER JOIN category ON product.categoryID = category.categoryID 
                        WHERE product.categoryID = 1 AND product.status = 1");
$data = array();
if ($product->num_rows > 0) {
    while ($row = $product->fetch_assoc()) {
        $data[] = $row;
    }
}
$count = count($data);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fruit</title>
    <!-- jquery cdn-->
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>

    <!-- import fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <!-- Bootstrap-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- font awesome-->
    <link rel="stylesheet" href="vendor/fontawesome/css/all.css">
    <!-- swiper plugin-->
    <script src="vendor/swiper/swiper.min.js"></script>
    <link rel="stylesheet" href="vendor/swiper/swiper.min.css">
    <!--customer stylesheet-->
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/product.css">

    <!-- customer javascript-->
    <script src="js/showMenuOnScroll.js"></script>
    <script src="js/toggleMenu.js"></script>
    <script src="js/DropMenu.js"></script>
    <script src="js/popupEffect.js"></script>
    <script src="js/ScrollToTop.js"></script>
    <script src="js/cart.js" async></script>
    <style>
        .swiper-slide .slide-caption {
            position: absolute;
            top: 272px;
            height: 15%;
            width: 100%;
            background-color: rgba(82, 129, 17, .6);
            z-index: 100;
        }
    </style>
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
                            <a href="rice-rice-product.php#rar">Rice</a>
                            <a href="oils-product.php#op">Oils</a>
                            <a href="fruit-product.php#fp">Fruit</a>
                            <a href="condiments-product.php#cp">Condiment and spice</a>
                        </div>
                    </div>
                    <a href="contact.php">Contact Us</a>
                    <a href="gallery.php">Gallery</a>
                    <?php if (isset($_SESSION['login']) && $_SESSION['login'] === true) { ?>
                        <a href="logout.php"><?= $_SESSION['name'] ?>. LogOut</a>
                    <?php } else { ?>
                        <a href="login.php#page-title">Login</a>
                    <?php } ?>
                </div>
                <!-- Search  -->
                <div id="search-box">
                    <input type="text" name="search-text" placeholder="Type to search">
                    <a href="#" id="search-btn">
                        <i class="fas fa-search"></i>
                    </a>
                </div>

            </div><!-- end nav-->


            <!-- Swiper -->
            <div class="swiper-container" id="banner-slideshow">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="slide-img">
                            <img src="imgs/rice-bg.jpg" alt="">
                        </div>
                        <div class="slide-caption">
                            <div class="content">
                                <h3>Rice and rice's products </h3>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="slide-img">
                            <img src="imgs/oils-bg.jpg" alt="">
                        </div>
                        <div class="slide-caption">
                            <div class="content">
                                <h3>Oils</h3>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="slide-img">
                            <img src="imgs/condiments-bg.jpg" alt="">
                        </div>
                        <div class="slide-caption">
                            <div class="content">
                                <h3>Spices and Condiments.</h3>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="slide-img">
                            <img src="imgs/fruit-bg.jpg" alt="">
                        </div>
                        <div class="slide-caption">
                            <div class="content">
                                <h3>Our fresh and delicous Fruit Pulp</h3>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
                <!-- Add Arrows -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>


        </div>
        <!--end head div-->
        <div id="content">
            <div id="general-title">
                <h2 id="fp">Fruit</h2>
                <span class="separator"></span>
            </div>
            <div id="product-container" class="container">

                <div class="row" id="row1">
                    <?php for ($i = 0; $i <= ($count - 1); $i++) { ?>
                        <div class="product-card col-md-3 col-sm-6">
                            <div class="product-img">
                                <img src="<?= $data[$i]['imgURL'] ?>" alt="<?= $data[$i]['productName'] ?>" class="img" onclick="toggle(<?= $i + 1 ?>)" />
                            </div>
                            <div class="product-details">
                                <span class='pid' style="display:none"><?= $data[$i]['productID'] ?></span>
                                <h3 class="product-name"><?= $data[$i]['productName'] ?></h3>
                                <p class="product-price"><?= number_format($data[$i]['unitPrice'], 2) ?></p>
                                <button type="button" class="AddToCart mybtn"><i class="fas fa-cart-plus"></i> Add To Cart</button>
                            </div>
                        </div>
                    <?php
                    }  ?>
                </div>

            </div> <!-- end product container-->
            <!-- cart section-->
            <div id="cart" class="container">
                <h2 class="cart-header">Cart <i class="fas fa-cart-arrow-down"></i></h2>
                <span class="separator"></span>
                <!-- cart product-->
                <form action="cart.php" method="post">
                <table class="table table-condensed" id="cart-product">
                    <thead>
                        <th>Product</th>
                        <th class="text-center">Price</th>
                        <th>Quantity</th>
                    </thead>
                    <tbody class="cart-items">
                        <!-- add to cart by js-->
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <td class="toltal-price" colspan="2">TOTAL: $0.00</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
                <div class='order-btn'>
                    <button type='submit' name='cart' class="btn purchase-btn">Place Order</button>
                    <!-- <a href="login.php#page-title" class="btn purchase-btn">Place Order</a> -->
                </div>
                </form>
            </div>
            <a href="#cart" class="scrollToCart"><i class="fab fa-opencart"></i></a>
            <!-- popup information for each product onclick product image-->
            <div id="popup-container">

                <!-- Begin row 1 popup -->
                <?php for ($i = 0; $i <= ($count - 1); $i++) { ?>
                    <div id="popup-<?= $i + 1 ?>" class="popup">
                        <span class='pid' style="display:none"><?= $data[$i]['productID'] ?></span>
                        <h2 class='pname'><?= $data[$i]['productName'] ?></h2>
                        <img class='imgURL' src="<?= $data[$i]['imgURL'] ?>" alt="<?= $data[$i]['productName'] ?>" class="popup-img">
                        <p><?= $data[$i]['productDetail'] ?></p>
                        <p class='unitprice' style="visibility: hidden"><?= $data[$i]['unitPrice'] ?></p>
                        <button type="button" class="close-btn mybtn" onclick="toggle(<?= $i + 1 ?>)">Close</button>
                        <button type="button" class="AddToCart mybtn" onclick="addCart1(<?= $i ?>);toggle(<?= $i + 1 ?>)"><i class="fas fa-cart-plus"></i> Add To Cart</button>
                        <!-- <a href="customer-cart.php" class="AddToCart mybtn" target="_blank"><i class="fas fa-cart-plus"></i> Add To Cart</a> -->
                    </div>
                <?php } ?>
            </div><!-- end popup container-->

        </div>
        <!--end content div-->

        <div id="foot">
            <div id="copyrights">
                Copyright & copy 2021. All rights reserved by Brothers In Farm.
            </div>
            <div id="social-media">
                <a href="http://fb.com"><i class="fab fa-facebook-square"></i></a>
                <a href="http://instagram.com"><i class="fab fa-instagram"></i></a>
                <a href="http://twitter.com"><i class="fab fa-twitter-square"></i></a>
            </div>
        </div>
        <!--End foot div-->
    </div><!-- end page div-->
    <a href="#" class="UpToTop"><i class="fas fa-arrow-up"></i></a>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper('.swiper-container', {
            spaceBetween: 30,
            centeredSlides: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });

        function addCart1(i) {
            var id = document.querySelectorAll(".pid")[i].textContent;
            var name = document.querySelectorAll(".pname")[i].textContent;
            var img = document.querySelectorAll(".imgURL")[i].src;
            var price = document.querySelectorAll(".unitprice")[i].textContent;
            addProductToCart(id, name, img, price);
        }
    </script>
</body>

</html>