<?php
require_once '../../connect.php';

$lastURL = '/amadoFurniture/admin/orderManagment/viewAllOrders.php';
// setting last url variable in a session so it can be accessed in case i want to redirect to last opened page
$_SESSION['lastURL'] = $lastURL;

// if not logged in goto login page
if (!isset($_SESSION['userDetails']['0']['name']) || $_SESSION['userDetails']['0']['user_type'] !== '0') {
    header('location: /amadoFurniture/login.php');
}

// if logged in
if (isset($_SESSION['userDetails']['0']['name']) && $_SESSION['userDetails']['0']['user_type'] == '0') {
$orderQuery = "SELECT * FROM orders";
$orderQueryResult = mysqli_query($dbConnect, $orderQuery);
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
include_once '../../includes/errors.php';
include_once '../../includes/messages.php';
?>

                    <div class="checkout_details_area mt-50 ml-4">

                        <div class="cart-title mb-5">
                            <h2>Orders</h2>
                            <?php if (mysqli_num_rows($orderQueryResult) == 0)
                              echo ' (No Orders)';
                                ?>
                        </div>

                        <div class="container">

                        <table>
                      <thead>
                        <tr>
                          <th scope="col">Order #</th>
                          <th scope="col">Date</th>
                          <th scope="col">Cost</th>
                          <th scope="col">Status</th>
                          <th scope="col">Edit</th>
                        </tr>
                      </thead>
                      <tbody>

                      <?php if (mysqli_num_rows($orderQueryResult) != 0) {
                          while ($order = $orderQueryResult->fetch_assoc()) {
                              ?>
                        <tr>

                          <td data-label="Order #"><?php echo $order['id'] ?></td>
                          <td data-label="Date"><?php echo $order['order_date'] ?></td>
                          <td data-label="Name"><?php echo $order['cost'] ?></td>
                          <td data-label="Status"><?php if($order['order_status'] == 1) echo '<span class="text-success">Enabled</span>'; else echo '<span class="text-danger">Disabled</span>';?></td>
                          <td data-label="Edit"> <a href="viewOrder.php?order_id=<?php echo $order['id'] ?>&customer_id=<?php echo $order['customer_id']?>"> <i class="fas fa-search text-warning"></i> </a></td>

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
