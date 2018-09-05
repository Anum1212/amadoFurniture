<?php
require_once 'connect.php';

if (isset($_GET['product_id'])) {
$product_id = $_GET['product_id'];

$lastURL = 'productDetails.php?product_id='.$product_id;
// setting last url variable in a session so it can be accessed in case i want to redirect to last opened page
$_SESSION['lastURL'] = $lastURL;

$productQuery = "SELECT * FROM products WHERE id = $product_id";
$productQueryResult = mysqli_query($dbConnect, $productQuery);
if (mysqli_num_rows($productQueryResult) > 0) {
    while ($product = $productQueryResult->fetch_assoc()) {
        $category_id= $product['category_id'];
        $productBrand= $product['brand'];
        $productName = $product['name'];
        $productPrice = $product['price'];
        $productDescription = $product['description'];
        $productQuantity = $product['quantity'];
    }
}

$categoryQuery = "SELECT * FROM categories WHERE id = $category_id";
$categoryQueryResult = mysqli_query($dbConnect, $categoryQuery);
if (mysqli_num_rows($categoryQueryResult) > 0) {
    while ($category = $categoryQueryResult->fetch_assoc()) {
        $categoryName = $category['name'];
    }
}

$productImageQuery = "SELECT * FROM product_images WHERE product_id = $product_id";
$productImageQueryResult = mysqli_query($dbConnect, $productImageQuery);
if (mysqli_num_rows($productImageQueryResult) > 0) {
    $productImageName = [];
    while ($productImage = $productImageQueryResult->fetch_assoc()) {
        $productImageName[] = $productImage['image_name'];
    }
}

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<?php
include 'includes/amado/head.php';
?>

<style>
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
</style>

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


        <!-- Product Details Area Start -->
        <div class="single-product-area section-padding-100 clearfix">
            <div class="container-fluid">
<?php
include_once 'includes/errors.php';
include_once 'includes/messages.php';
?>

                <div class="row">
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mt-50">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item"><a href="products.php?category_id=<?php echo $category_id?>"><?php echo ucwords($categoryName) ?></a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo ucwords($productName) ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-7">
                        <div class="single_product_thumb">
                            <div id="product_details_slider" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li class="active" data-target="#product_details_slider" data-slide-to="0" style="background-image: url(myAssets/images/productImages/<?php echo $productImageName['0']?>);">
                                    </li>
                                    <li data-target="#product_details_slider" data-slide-to="1" style="background-image: url(myAssets/images/productImages/<?php echo $productImageName['1']?>);">
                                    </li>
                                    <li data-target="#product_details_slider" data-slide-to="2" style="background-image: url(myAssets/images/productImages/<?php echo $productImageName['2']?>);">
                                    </li>
                                    <li data-target="#product_details_slider" data-slide-to="3" style="background-image: url(myAssets/images/productImages/<?php echo $productImageName['3']?>);">
                                    </li>
                                </ol>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <a class="gallery_img" href="myAssets/images/productImages/<?php echo $productImageName['0']?>">
                                            <img class="d-block w-100" src="myAssets/images/productImages/<?php echo $productImageName['0']?>" alt="First slide">
                                        </a>
                                    </div>
                                    <div class="carousel-item">
                                        <a class="gallery_img" href="myAssets/images/productImages/<?php echo $productImageName['1']?>">
                                            <img class="d-block w-100" src="myAssets/images/productImages/<?php echo $productImageName['1']?>" alt="Second slide">
                                        </a>
                                    </div>
                                    <div class="carousel-item">
                                        <a class="gallery_img" href="myAssets/images/productImages/<?php echo $productImageName['2']?>">
                                            <img class="d-block w-100" src="myAssets/images/productImages/<?php echo $productImageName['2']?>" alt="Third slide">
                                        </a>
                                    </div>
                                    <div class="carousel-item">
                                        <a class="gallery_img" href="myAssets/images/productImages/<?php echo $productImageName['3']?>">
                                            <img class="d-block w-100" src="myAssets/images/productImages/<?php echo $productImageName['3']?>" alt="Fourth slide">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5">
                        <div class="single_product_desc">
                            <!-- Product Meta Data -->
                            <div class="product-meta-data">
                                <div class="line"></div>
                                <p class="product-price">Rs <?php echo $productPrice ?></p>
                                <a href="product-details.html">
                                    <h6><?php echo ucwords($productName) ?></h6>
                                </a>
                                <!-- Avaiable -->
                                <?php if ($productQuantity != '0'){ ?>
                                <p class="avaibility"><i class="fa fa-circle"></i> In Stock</p>
                                <?php }?>
                                <?php if ($productQuantity == '0') { ?>
                                <p class="text-danger" style="font-size:12px"><i class="fa fa-circle"></i> Out of Stock</p>
                                <?php } ?>
                            </div>

                            <div class="short_overview my-5">
                                <p><?php echo ucfirst($productDescription) ?></p>
                            </div>

                            <!-- Add to Cart Form -->
                            <form class="cart clearfix" action="cartController.php?product_id=<?php echo $product_id?>" method="Post">
                                <div class="cart-btn d-flex mb-50">
                                    <p>Qty</p>
                                    <div class="quantity">
                                        <span class="qty-minus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 1 ) effect.value--;return false;"><i class="fa fa-caret-down" aria-hidden="true"></i></span>
                                        <input type="number" class="qty-text" id="qty" step="1" min="1" max="300" name="quantity" value="1">
                                        <span class="qty-plus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;"><i class="fa fa-caret-up" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                                <button type="submit" name="addToCart" value="5" class="btn amado-btn">Add to cart</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Product Details Area End -->

    </div>
    <!-- ##### Main Content Wrapper End ##### -->

    <?php
    include_once 'includes/amado/footer.php';
    ?>

<?php
include_once 'includes/amado/scripts.php';
?>

</body>

</html>
