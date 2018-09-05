<?php

require_once '../connect.php';

$lastURL = '/amadoFurniture/customer/customerDashboard.php';
// setting last url variable in a session so it can be accessed in case i want to redirect to last opened page
$_SESSION['lastURL'] = $lastURL;

// if not logged in goto login page
if (!isset($_SESSION['userDetails']['0']['name'])) {
    header('location: /amadoFurniture/login.php');
}

// if logged in
if (isset($_SESSION['userDetails']['0']['name'])) {
  $customer_id = $_SESSION['userDetails']['0']['id'];
  $customerOrderQuery = "SELECT * FROM orders WHERE customer_id = $customer_id";
  $customerOrderQueryResult = mysqli_query($dbConnect, $customerOrderQuery);
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
                        <div class="cart-title mb-5">
                            <h2>Order Details</h2>
                        </div>
                        <div class="container">

                        <table>
                      <thead>
                        <tr>
                          <th scope="col">Order Date</th>
                          <th scope="col">Cost</th>
                          <th scope="col"></th>
                        </tr>
                      </thead>
                      <tbody>

                      <?php if (mysqli_num_rows($customerOrderQueryResult) != 0) {
                          while ($order = $customerOrderQueryResult->fetch_assoc()) {
                              ?>
                        <tr>

                          <td data-label="Order Date"><?php echo $order['order_date'] ?></td>
                          <td data-label="Cost"><?php echo $order['cost'] ?></td>
                          <td data-label=""> <a href="customerOrderDetails.php?order_id=<?php echo $order['id'] ?>"> <i class="fas fa-search text-warning"></i> </a></td>

                        </tr>

                      <?php } }?>

                      </tbody>
                    </table>
                  </div>

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
