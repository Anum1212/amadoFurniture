<?php

require_once 'connect.php';

$lastURL = 'index.php';
// setting last url variable in a session so it can be accessed in case i want to redirect to last opened page
$_SESSION['lastURL'] = $lastURL;

// pageIndicator var used to indicate which page the user is on so that that navbar link can be given active class
$pageIndicator = 'index';
?>

<!DOCTYPE html>
<html lang="en">

<head>

<?php
include 'includes/amado/head.php';
?>

</head>

<body>

<?php
include_once 'includes/amado/searchBar.php';
?>

    <!-- ##### Main Content Wrapper Start ##### -->
    <div class="main-content-wrapper d-flex clearfix">


<?php
include_once 'includes/amado/sideNavBar.php';
?>

        <!-- Product Catagories Area Start -->
        <div class="products-catagories-area clearfix">
            <div class="amado-pro-catagory clearfix">

                <!-- Single Catagory -->
                <div class="single-products-catagory clearfix">
                    <a href="products.php?category_id=2">
                        <img src="myAssets/amado/img/homePageImages/chairs.jpg" alt="">
                        <!-- Hover Content -->
                        <div class="hover-content">
                            <h4>Chairs</h4>
                            <div class="line"></div>
                        </div>
                    </a>
                </div>

                <!-- Single Catagory -->
                <div class="single-products-catagory clearfix">
                    <a href="products.php?category_id=1">
                        <img src="myAssets/amado/img/homePageImages/tables.jpg" alt="">
                        <!-- Hover Content -->
                        <div class="hover-content">
                            <h4>Tables</h4>
                            <div class="line"></div>
                        </div>
                    </a>
                </div>

                <!-- Single Catagory -->
                <div class="single-products-catagory clearfix">
                    <a href="products.php?category_id=3">
                        <img src="myAssets/amado/img/homePageImages/sofas.jpg" alt="">
                        <!-- Hover Content -->
                        <div class="hover-content">
                            <h4>Sofas</h4>
                            <div class="line"></div>
                        </div>
                    </a>
                </div>

                <!-- Single Catagory -->
                <div class="single-products-catagory clearfix">
                    <a href="products.php?category_id=8">
                        <img src="myAssets/amado/img/homePageImages/kids.jpg" alt="">
                        <!-- Hover Content -->
                        <div class="hover-content">
                            <h4>Kids</h4>
                            <div class="line"></div>
                        </div>
                    </a>
                </div>

                <!-- Single Catagory -->
                <div class="single-products-catagory clearfix">
                    <a href="products.php?category_id=5">
                        <img src="myAssets/amado/img/homePageImages/plants.jpg" alt="">
                        <!-- Hover Content -->
                        <div class="hover-content">
                            <h4>Plants</h4>
                            <div class="line"></div>
                        </div>
                    </a>
                </div>

                <!-- Single Catagory -->
                <div class="single-products-catagory clearfix">
                    <a href="products.php?category_id=4">
                        <img src="myAssets/amado/img/homePageImages/beds.jpeg" alt="">
                        <!-- Hover Content -->
                        <div class="hover-content">
                            <h4>Beds</h4>
                            <div class="line"></div>
                        </div>
                    </a>
                </div>

                <!-- Single Catagory -->
                <div class="single-products-catagory clearfix">
                    <a href="products.php?category_id=9">
                        <img src="myAssets/amado/img/homePageImages/pets.jpg" alt="">
                        <!-- Hover Content -->
                        <div class="hover-content">
                            <h4>Pets</h4>
                            <div class="line"></div>
                        </div>
                    </a>
                </div>

                <!-- Single Catagory -->
                <div class="single-products-catagory clearfix">
                    <a href="products.php?category_id=6">
                        <img src="myAssets/amado/img/homePageImages/outdoor.jpg" alt="">
                        <!-- Hover Content -->
                        <div class="hover-content">
                            <h4>Outdoor</h4>
                            <div class="line"></div>
                        </div>
                    </a>
                </div>

                <!-- Single Catagory -->
                <div class="single-products-catagory clearfix">
                    <a href="products.php?category_id=7">
                        <img src="myAssets/amado/img/homePageImages/office.jpg" alt="">
                        <!-- Hover Content -->
                        <div class="hover-content">
                            <h4>Office</h4>
                            <div class="line"></div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
        <!-- Product Catagories Area End -->
    </div>
    <!-- ##### Main Content Wrapper End ##### -->

    <?php
    include_once 'includes/amado/footer.php';
    ?>

<?php
include_once 'includes/amado/scripts.php';
?>

</body>

</php?category_id=>
