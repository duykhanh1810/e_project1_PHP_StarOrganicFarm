<?php session_start();
require "admin/adminFunction.php";
$conn = connect();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = 1;
}

if (isset($_POST['search-text'])) {
    $search = filter_var($_POST['search-text'], FILTER_SANITIZE_STRING);
    $product = $conn->query("SELECT * FROM product
        INNER JOIN category ON product.categoryID = category.categoryID
        WHERE product.productName LIKE CONCAT('%','$search','%') 
        OR category.categoryName LIKE CONCAT('%','$search','%')
        AND product.status = 1 AND category.status = 1
        ");
} else {
    $product = $conn->query("SELECT * FROM product 
    INNER JOIN category ON product.categoryID = category.categoryID 
    WHERE product.categoryID = '$id' AND product.status = 1 AND category.status = 1");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

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
    <link rel="stylesheet" href="css/index_style.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/product.css">

    <!-- customer javascript-->
    <script src="js/showMenuOnScroll.js"></script>
    <script src="js/toggleMenu.js"></script>
    <script src="js/DropMenu.js"></script>
    <script src="js/popupEffect.js"></script>
    <script src="js/ScrollToTop.js"></script>
    <script src="js/cart.js" async></script>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, location.href);
        }
    </script>
    <title><?= admin_getCategoryName($id) ?></title>
</head>

<body>
        <?php require_once "head.php" ?>
        <div id="content">
            <div id="general-title">
                <h2 id="prd"><?= isset($_POST['search-text']) ? "We've got something for you:" : admin_getCategoryName($id) ?></h2>
                <span class="separator"></span>
            </div>
            <div id="product-container" class="container">
                <div class="row" id="row1">
                    <?php if ($product->num_rows > 0) {
                        $i = 1;
                        foreach ($product as $value) : ?>
                            <div class="product-card col-md-3 col-sm-6">
                                <div class="product-img">
                                    <img src="<?= $value['imgURL'] ?>" alt="<?= $value['productName'] ?>" class="img" onclick="toggle(<?= $i ?>)" />
                                </div>
                                <div class="product-details">
                                    <span class='pid' style="display:none"><?= $value['productID'] ?></span>
                                    <h3 style="color: black" class="product-name"><?= $value['productName'] ?></h3>
                                    <p>
                                        <span class="dollar"><i class="fas fa-dollar-sign"></i></span>
                                        <span class="product-price"><?= number_format($value['unitPrice'], 2) ?></span>
                                        <span class="dollar">/<?= $value['unit'] ?></span>
                                    </p>
                                    <!-- <button type="button" class="AddToCart mybtn"><i class="fas fa-cart-plus" onclick="submitCart();"></i> Add to Cart</button>
                                    <br> -->
                                    <button type="button" class="mybtn AddToCart1" onclick="addCart1(<?= $i-1?>);submitCart();">Add to cart</button>
                                </div>
                            </div>
                    <?php $i++;
                        endforeach;
                    } else {
                        echo "<div class='row' style='text-align:center'>
                            <h3>We regret that the product you're looking for is currently not available in our shop.</h3>
                            <h3> If you have any special demand, feel free to <b><a href='contact.php'>contact us</a>!</b></h3>
                        </div>";
                    }
                    ?>

                </div>
            </div> <!-- end product container-->
            <!-- cart section-->
            <div id="cart" class="container">
                <h2 class="cart-header">Cart <i class="fas fa-cart-arrow-down"></i></h2>
                <form id='cart-submit' action="addcart.php" method="post">
                <span class="separator"></span>
                <!-- cart product-->
                    <table class="table table-condensed" id="cart-product">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th class="text-center">Price</th>
                                <th>Quantity</th>

                            </tr>
                        </thead>
                        <tbody class="cart-items">
                            <!-- Load cart from session -->
                            <?php
                            require "cart.php";
                            ?>
                            <!-- add to cart by javascript-->
                        </tbody>
                        <tfoot>
                            <tr class="total-row">
                                <td class="toltal-price" colspan="3">TOTAL: <?= isset($_SESSION['total']) ? '$ ' . $_SESSION['total'] : '' ?></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class='order-btn'>
                        <!-- <button type='submit' name='cart' class="btn purchase-btn">Save in Cart</button> -->
                        <button type='submit' name='gotocart' class="btn purchase-btn" onclick="purchaseButtonClicked();">Go to Cart</button>
                    </div>
                </form>

            </div>
            <a href="#cart" class="scrollToCart"><i class="fab fa-opencart"></i></a>
            <!-- popup information for each product onclick product image-->
            <div id="popup-container">
                <?php 
                $i = 0;
                foreach ($product as $value) { ?>
                    <div id="popup-<?= $i + 1 ?>" class="popup">
                        <span class='pid' style="display:none"><?= $value['productID'] ?></span>
                        <h2 class='pname'><?= $value['productName'] ?></h2>
                        <img class='imgURL' src="<?= $value['imgURL'] ?>" alt="<?= $value['productName'] ?>" class="popup-img">
                        <p><?= $value['productDetail'] ?></p>
                        <p class='unitprice' style="visibility: hidden"><?= $value['unitPrice'] ?></p>
                        <button type="button" class="close-btn mybtn" onclick="toggle(<?= $i + 1 ?>)">Close</button>
                        <button type="button" class="AddToCart mybtn" onclick="addCart1(<?= $i ?>);toggle(<?= $i + 1 ?>); submitCart();"><i class="fas fa-cart-plus"></i> Add To Cart</button>
                        <!-- <a href="customer-cart.php" class="AddToCart mybtn" target="_blank"><i class="fas fa-cart-plus"></i> Add To Cart</a> -->
                    </div>
                <?php
                    $i++;
                } ?>
            </div>
            <!-- end popup container-->
        </div>
        <!--end content div-->
        <div id="foot">
            <div id="copyrights">
                Copyright & copy <?=date("Y")?>. All rights reserved by Brothers In Farm
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
        function submitCart(){
            document.getElementById("cart-submit").submit();
        }
        </script>
</body>

</html>
<?php $conn->close(); ?>