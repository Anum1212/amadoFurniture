<?php

require_once '../connect.php';

$lastURL = '/furniture/customer/customerDashboard.php';
// setting last url variable in a session so it can be accessed in case i want to redirect to last opened page
$_SESSION['lastURL'] = $lastURL;

// if not logged in goto login page
if (!isset($_SESSION['userDetails']['0']['name'])) {
    header('location: /furniture/login.php');
}

// if logged in
if (isset($_SESSION['userDetails']['0']['name'], $_GET['order_id'])) {
    $customer_id = $_SESSION['userDetails']['0']['id'];
    $order_id = $_GET['order_id'];

// get order details from order table for security checking purposes
    $customerOrderQuery = "SELECT * FROM orders WHERE id = $order_id";
    $customerOrderQueryResult = mysqli_query($dbConnect, $customerOrderQuery);
    if (mysqli_num_rows($customerOrderQueryResult) != 0) {
        while ($order = $customerOrderQueryResult->fetch_assoc()) {
          // check if order belongs to the customer
            if ($order['customer_id'] == $customer_id) {
              // if the order belongs to the customer get order item details from order_items table
                $OrderItemQuery = "SELECT * FROM order_items WHERE order_id = $customer_id";
                $OrderItemQueryResult = mysqli_query($dbConnect, $OrderItemQuery);
            }
// else redirect to customerOrders.php
            else {
                header('location: customerOrders.php');
            }
        }
    }
}

// pageIndicator var used to indicate which page the user is on so that that navbar link can be given active class
$pageIndicator = 'account';

?>

<!DOCTYPE html>
<html lang="en">

<head>

<?php
include '../includes/amado/head.php';
?>
<link rel="stylesheet" href="../myAssets/css/dashboard.css">

<link rel="stylesheet" href="../myAssets/css/table.css">
</head>

<body>

    <?php
include_once '../includes/amado/searchBar.php';
?>

<div class="main-content-wrapper d-flex clearfix row">
  <div class="col-12 col-md-2">
    <?php
    include_once '../includes/amado/sideNavBar.php';
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
            <a href="customerDashboard.php">Account Details</a>
            </li>
            <li class="active">
            <a href="customerOrders.php">Order Details</a>
            </li>
          </ul>
      </div>
    </div>
    </div>
  </div>
  <div class="container col-12 col-md-8">

  <?php
  include_once '../includes/errors.php';
  include_once '../includes/messages.php';
  ?>

    <div class="checkout_details_area mt-50 ml-4">
                        <div class="cart-title mb-5 ml-5">
                            <h2>Order Details</h2>
                        </div>
<?php
if (isset($OrderItemQueryResult)) {
    ?>
                        <table>
                      <thead>
                        <tr>
                          <th scope="col">Name</th>
                          <th scope="col">Price</th>
                          <th scope="col">Quantity</th>
                          <th scope="col">Total</th>
                        </tr>
                      </thead>
                      <tbody>

                      <?php
                      if (mysqli_num_rows($OrderItemQueryResult) != 0) {
                          while ($order = $OrderItemQueryResult->fetch_assoc()) {
                              ?>
                        <tr>
                          <td data-label="Order Date"><?php echo ucwords($order['product_name']) ?></td>
                          <td data-label="Cost"><?php echo $order['product_price'] ?></td>
                          <td data-label="Cost"><?php echo $order['product_quantity'] ?></td>
                          <td data-label="Cost"><?php echo $order['product_total'] ?></td>
                        </tr>

                      <?php
                          }
                      } ?>

                      </tbody>
                    </table>

                  <?php
} ?>

  </div>
  </div>
</div>

    <?php
    include_once '../includes/amado/footer.php';
    ?>

<?php
include_once '../includes/amado/scripts.php';
?>

</body>

</html>
