<?php
require_once 'connect.php';

// path level to help me adjust asset paths 
$_SESSION['pathLevel'] = '';

if (isset($_GET['category_id'])) {
    $categoryQuery = "SELECT * FROM categories";
    $categoryQueryResult = mysqli_query($dbConnect, $categoryQuery);
    $category_id = $_GET['category_id'];

    $productBrandQuery = "SELECT DISTINCT brand FROM products WHERE category_id = $category_id";
    $productBrandQueryResult = mysqli_query($dbConnect, $productBrandQuery);

    $productQuery = "SELECT * FROM products WHERE category_id = $category_id AND product_status = '1'";
    $productQueryResult = mysqli_query($dbConnect, $productQuery);

    $lastURL = 'products.php?category_id='.$category_id;
    // setting last url variable in a session so it can be accessed in case i want to redirect to last opened page
    $_SESSION['lastURL'] = $lastURL;
}
?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <?php
include 'includes/amado/head.php';
?>
  </head>
  <body>
    <!-- Search Wrapper Area Start -->
    <?php
include_once 'includes/amado/searchBar.php';
?>
    <!-- Search Wrapper Area End -->
    <!-- ##### Main Content Wrapper Start ##### -->
    <div class="main-content-wrapper d-flex clearfix">
      <?php
include_once 'includes/amado/sideNavBar.php';
?>
      <!-- Header Area End -->
      <div class="shop_sidebar_area">
        <!-- ##### Single Widget ##### -->
        <div class="widget catagory mb-50">
          <!-- Widget Title -->
          <h6 class="widget-title mb-30">Catagories
          </h6>
          <!--  Catagories  -->
          <div class="catagories-menu">
            <ul>
              <?php while ($category = $categoryQueryResult->fetch_assoc()) {
    ?>
              <li
                  <?php if ($category['id'] == $category_id) {
        echo 'class="active"';
    } ?> >
              <a href="products.php?category_id=<?php echo $category['id'] ?>">
                <?php echo ucwords($category['name']); ?>
              </a>
              </li>
            <?php
}?>
            </ul>
        </div>
      </div>
      <!-- ##### Single Widget ##### -->
      <div class="widget brands mb-50">
        <!-- Widget Title -->
        <h6 class="widget-title mb-30">Brands
        </h6>
        <div class="widget-desc">
          <!-- Single Form Check -->
          <?php
          if (mysqli_num_rows($productBrandQueryResult)>0) {
              while ($productBrand = $productBrandQueryResult->fetch_assoc()) {
                  ?>
          <div class="form-check">
            <label>
              <?php echo ucwords($productBrand['brand']); ?>
            </label>
          </div>
          <?php
              }
          }
?>
        </div>
      </div>
    </div>
    <div class="amado_product_area section-padding-100">
      <div class="container-fluid">
      <?php
      include_once 'includes/errors.php';
      include_once 'includes/messages.php';
      ?>
        <div class="row">
          <?php
          if (mysqli_num_rows($productQueryResult)>0) {
              while ($product = $productQueryResult->fetch_assoc()) {
                  ?>
          <!-- Single Product Area -->
          <div class="col-12 col-sm-6 col-md-12 col-xl-6">
            <div class="single-product-wrapper">
              <!-- Product Image -->
              <div class="product-img">
              <?php
$productImageQuery = "SELECT * FROM product_images WHERE product_id = $product[id]";
                  $productImageQueryResult = mysqli_query($dbConnect, $productImageQuery);
                  if (mysqli_num_rows($productImageQueryResult)>0) {
                      while ($productImage = $productImageQueryResult->fetch_assoc()) {
                          ?>
                          <?php
if ($productImage['image_number'] == '0') { ?>
                <img style="height:460px" src="myAssets/images/productImages/<?php echo $productImage['image_name'];?>">
                <?php } ?>
                <?php
if ($productImage['image_number'] == '1') { ?>
        <img class="hover-img" style="height:460px" src="myAssets/images/productImages/<?php echo $productImage['image_name'];?>">
                <?php } ?>
        <?php
                      }
                  } ?>
              </div>
              <!-- Product Description -->
              <div class="product-description d-flex align-items-center justify-content-between">
                <!-- Product Meta Data -->
                <div class="product-meta-data">
                  <div class="line">
                  </div>
                  <p class="product-price">Rs.
                    <?php echo $product['price'] ?>
                  </p>
                  <a href="productDetails.php?product_id=<?php echo $product['id'] ?>">
                    <h6>
                      <?php echo ucwords($product['brand']) .'<br>'. ucwords($product['name']) ?>
                    </h6>
                  </a>
                </div>
                                <!-- Ratings & Cart -->
                                <div class="ratings-cart text-right">
                                    <div class="cart">
                                      <form action="cartController.php?product_id=<?php echo $product['id']?>" method="Post">
                                      <input type="number" name="quantity" value="1" style="display:none">
                                      <button type="submit" name="addToCart" class="btn btn-link" data-toggle="tooltip" data-placement="left" title="Add to Cart"><img src="myAssets/amado/img/core-img/cart.png" alt=""></button>
                                    </form>
                                    </div>
                                </div>
              </div>
            </div>
          </div>
          <?php
              }
          }?>
        </div>
      </div>
    </div>
    </div>
  <!-- ##### Main Content Wrapper End ##### -->

  <?php
  include_once 'includes/amado/footer.php';
  ?>

  <?php
include_once 'includes/amado/scripts.php';
?>

<script>
    $('#sortByPrice').change(function() {
        alert("hii");
        // this.submit();
    });
    </script>
  </body>
</html>
