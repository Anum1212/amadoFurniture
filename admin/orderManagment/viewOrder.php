<?php
require_once '../../connect.php';

// path level to help me adjust asset paths 
$_SESSION['pathLevel'] = '../../';

// if not logged in goto login page
if (!isset($_SESSION['userDetails']['0']['name']) || $_SESSION['userDetails']['0']['user_type'] != '0') {
    header("location: $_SESSION[pathLevel]login.php");
}

// if logged in
if (isset($_SESSION['userDetails']['0']['name']) && $_SESSION['userDetails']['0']['user_type'] == '0') {
if(isset($_GET['order_id'])){

  $order_id = $_GET['order_id'];

  $orderItemQuery = "SELECT * FROM order_items WHERE order_id = $order_id";
  $orderItemQueryResult = mysqli_query($dbConnect, $orderItemQuery);
}
}

// pageIndicator var used to indicate which page the user is on so that that navbar link can be given active class
$pageIndicator = 'account';

?>

<!DOCTYPE html>
<html lang="en">

<head>

<?php
include "$_SESSION[pathLevel]includes/amado/head.php";
?>
<link rel="stylesheet" href="<?php echo $_SESSION['pathLevel'] ?>myAssets/css/dashboard.css">
<!-- table css   -->
<link rel="stylesheet" href="<?php echo $_SESSION['pathLevel'] ?>myAssets/css/table.css">
</head>

<body>

    <?php
include_once "$_SESSION[pathLevel]includes/amado/searchBar.php";
?>

<div class="main-content-wrapper d-flex clearfix row">
  <div class="col-12 col-md-2">
    <?php
    include_once "$_SESSION[pathLevel]includes/amado/sideNavBar.php";
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
              <a href="/amadoFurniture/admin/adminDashboard.php">Account Details</a>
            </li>
            <li>
              <a href="../productManagment/addProduct.php">Add Products</a>
            </li>
            <li>
              <a href="../productManagment/viewAllProducts.php">Edit Products</a>
            </li>
            <li class="active">
              <a href="viewAllOrders.php">Orders</a>
            </li>
          </ul>
      </div>
    </div>
    </div>
  </div>
  <div class="container col-12 col-md-8">

<?php
include_once "$_SESSION[pathLevel]includes/errors.php";
include_once "$_SESSION[pathLevel]includes/messages.php";
?>

                    <div class="checkout_details_area mt-50 ml-4">

                        <div class="cart-title mb-5">
                            <h2>Order Details</h2>
                        </div>

                        <div class="container">

                        <table>
                      <thead>
                        <tr>
                          <th scope="col">Name #</th>
                          <th scope="col">Price</th>
                          <th scope="col">Quantity</th>
                          <th scope="col">Total</th>
                        </tr>
                      </thead>
                      <tbody>

                      <?php if (mysqli_num_rows($orderItemQueryResult) != 0) {
                          while ($orderItem = $orderItemQueryResult->fetch_assoc()) {
                              ?>
                        <tr>

                          <td data-label="Name #"><?php echo $orderItem['product_name'] ?></td>
                          <td data-label="Price"><?php echo $orderItem['product_price'] ?></td>
                          <td data-label="Quantity"><?php echo $orderItem['product_quantity'] ?></td>
                          <td data-label="Total"><?php echo $orderItem['product_total'] ?></td>
                        </tr>

                      <?php } }?>

                      </tbody>
                    </table>
                    </div>
                  </div>

  </div>
</div>

    <?php
    include_once "$_SESSION[pathLevel]includes/amado/footer.php";
    ?>

<?php
include_once "$_SESSION[pathLevel]includes/amado/scripts.php";
?>

</body>

</html>
