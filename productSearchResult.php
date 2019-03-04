<?php
require_once 'connect.php';

// pageIndicator var used to indicate which page the user is on so that that navbar link can be given active class
$pageIndicator = 'search';

// path level to help me adjust asset paths 
$_SESSION['pathLevel'] = '';

$errors = array();

if (isset($_SESSION['searchWord'])) {
    $categoryQuery = "SELECT * FROM categories";
    $categoryQueryResult = mysqli_query($dbConnect, $categoryQuery);

    $productBrandQuery = "SELECT DISTINCT brand FROM products";
    $productBrandQueryResult = mysqli_query($dbConnect, $productBrandQuery);

    $searchWord = $_SESSION['searchWord'];
    $searchWord_soundexArray = $_SESSION['searchWord_soundexArray'];

    for($i=0; $i<count($searchWord); $i++){
    $searchQuery = "SELECT * FROM products WHERE (name LIKE '%$searchWord[$i]%' OR brand LIKE '%$searchWord[$i]%' OR brand_soundex LIKE  '%$searchWord_soundexArray[$i]%' OR name_soundex LIKE '%$searchWord_soundexArray[$i]%') AND product_status = '1'";
    $searchQueryResult = mysqli_query($dbConnect, $searchQuery);
    }

    // if search result is null return to previous page
    if (mysqli_num_rows($searchQueryResult) == 0) {
    array_push($errors, "Product Not Found");
    $_SESSION["errors"] = $errors;
      // header('location:'. $_SESSION['lastURL']);
    }

    $lastURL = 'productSearchResult.php';
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
              <li>
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
          if (mysqli_num_rows($searchQueryResult)>0) {
              while ($product = $searchQueryResult->fetch_assoc()) {
                  ?>
          <!-- Single Product Area -->
          <div class="col-12 col-sm-6 col-md-12 col-xl-6">
            <div class="single-product-wrapper">
              <!-- Product Image -->
              <div class="product-img">
              <?php
$productImage1Query = "SELECT * FROM product_images WHERE product_id = $product[id] AND image_number = 0";
                  $productImage1QueryResult = mysqli_query($dbConnect, $productImage1Query);
                  if (mysqli_num_rows($productImage1QueryResult)>0) {
                      while ($productImage1 = $productImage1QueryResult->fetch_assoc()) {
                          ?>
                          <?php
if ($productImage1['image_number'] == '0') { ?>
                <img style="height:460px" src="myAssets/images/productImages/<?php echo $productImage1['image_name'];?>">
                <?php } 
              }
            }
              ?>
              <?php
$productImage2Query = "SELECT * FROM product_images WHERE product_id = $product[id] AND image_number = 0";
                  $productImage2QueryResult = mysqli_query($dbConnect, $productImage2Query);
                  if (mysqli_num_rows($productImage2QueryResult)>0) {
                      while ($productImage2 = $productImage2QueryResult->fetch_assoc()) {
                          ?>
                <?php
if ($productImage2['image_number'] == '1') { ?>
        <img class="hover-img" style="height:460px" src="myAssets/images/productImages/<?php echo $productImage2['image_name'];?>">
                <?php } 
                }
              }
                ?>
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
