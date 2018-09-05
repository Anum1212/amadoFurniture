<?php
require_once '../../connect.php';

$lastURL = '/furniture/admin/productManagment/viewAllProducts.php';
// setting last url variable in a session so it can be accessed in case i want to redirect to last opened page
$_SESSION['lastURL'] = $lastURL;

// if not logged in goto login page
if (!isset($_SESSION['userDetails']['0']['name']) || $_SESSION['userDetails']['0']['user_type'] !== '0') {
    header('location: /furniture/login.php');
}

// if logged in
if (isset($_SESSION['userDetails']['0']['name']) && $_SESSION['userDetails']['0']['user_type'] == '0') {

$categoryQuery = "SELECT * FROM categories WHERE category_status = 1";
$categoryQueryResult = mysqli_query($dbConnect, $categoryQuery);

$productQuery = "SELECT * FROM products WHERE product_status = 1";
$productQueryResult = mysqli_query($dbConnect, $productQuery);
}

// pageIndicator var used to indicate which page the user is on so that that navbar link can be given active class
$pageIndicator = 'account';

?>

<!DOCTYPE html>
<html lang="en">

<head>

<?php
include '../../includes/amado/head.php';
?>
<link rel="stylesheet" href="../../myAssets/css/dashboard.css">
<!-- table css   -->
<link rel="stylesheet" href="../../myAssets/css/table.css">
</head>

<body>

    <?php
include_once '../../includes/amado/searchBar.php';
?>

<div class="main-content-wrapper d-flex clearfix row">
  <div class="col-12 col-md-2">
    <?php
    include_once '../../includes/amado/sideNavBar.php';
    ?>

  </div>
  <div class="col-12 col-md-2">
    <!-- Header Area End -->
    <div class="shop_sidebar_area" id="sideBar">
      <!-- ##### Single Widget ##### -->
      <div class="widget catagory mb-50">
        <!--  Catagories  -->
        <div class="catagories-menu">
          <ul>
            <li>
              <a href="/furniture/admin/adminDashboard.php">Account Details</a>
            </li>
            <li>
              <a href="addProduct.php">Add Products</a>
            </li>
            <li class="active">
              <a href="viewAllProducts.php">Edit Products</a>
            </li>
            <li>
             <a href="../orderManagment/viewAllOrders.php">Orders</a>
            </li>
          </ul>
      </div>
    </div>
    </div>
  </div>
  <div class="container col-12 col-md-8">

<?php
include_once '../../includes/errors.php';
include_once '../../includes/messages.php';
?>

                    <div class="checkout_details_area mt-50 ml-4">

                        <div class="cart-title mb-5">
                            <h2>Products</h2>
                            <?php if (mysqli_num_rows($productQueryResult) == 0)
                              echo ' (No Products)';
                              ?>
                        </div>

                        <div class="container">

                        <table>
                      <thead>
                        <tr>
                          <th scope="col">Brand</th>
                          <th scope="col">Name</th>
                          <th scope="col">Price</th>
                          <th scope="col">Quantity</th>
                          <th scope="col">Status</th>
                          <th scope="col">Edit</th>
                          <th scope="col">Delete</th>
                        </tr>
                      </thead>
                      <tbody>

                      <?php if (mysqli_num_rows($productQueryResult) > 0) {
                          while ($product = $productQueryResult->fetch_assoc()) {
                              ?>
                        <tr>

                          <td data-label="Brand"><?php echo $product['brand'] ?></td>
                          <td data-label="Name"><?php echo $product['name'] ?></td>
                          <td data-label="Price"><?php echo $product['price'] ?></td>
                          <td data-label="Quantity"><?php echo $product['quantity'] ?></td>
                          <td data-label="Status"><?php if($product['product_status'] == 1) echo '<span class="text-success">Enabled</span>'; else echo '<span class="text-danger">Disabled</span>span>';?></td>
                          <td data-label="Edit"> <a href="editProduct.php?product_id=<?php echo $product['id'] ?>"> <i class="fas fa-pen-square text-warning"></i> </a></td>
                          <td data-label="Delete"> <i class="fas fa-trash text-danger"> </td>

                        </tr>

                      <?php } }?>

                      </tbody>
                    </table>
                    </div>
                  </div>

  </div>
</div>

    <?php
    include_once '../../includes/amado/footer.php';
    ?>

<?php
include_once '../../includes/amado/scripts.php';
?>

</body>

</html>
