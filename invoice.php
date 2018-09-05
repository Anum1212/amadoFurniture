<?php
require_once 'connect.php';


$lastURL = 'invoice.php';
// setting last url variable in a session so it can be accessed in case i want to redirect to last opened page
$_SESSION['lastURL'] = $lastURL;

// if user not logged in redirect to login
if (!isset($_SESSION['userDetails']['0']['name'])) {
    header('location: login.php');
}

// if user logged in continue
if (isset($_SESSION['userDetails']['0']['name'], $_GET['order_id'])) {
    // get order_id
    $order_id = $_GET['order_id'];
    // get customer_id
    $customer_id = $_SESSION['userDetails']['0']['id'];

    // getting inserted order details for displaying in invoice
    $orderQuery = "SELECT * FROM orders WHERE id = $order_id AND customer_id = $customer_id";
    $orderQueryResult = mysqli_query($dbConnect, $orderQuery);
    while ($order = $orderQueryResult->fetch_assoc()) {
        $order_date = $order['order_date'];
        $order_cost = $order['cost'];
    }

    // getting inserted order items for displaying in invoice
    $orderItemQuery = "SELECT * FROM order_items WHERE order_id = $order_id";
    $orderItemQueryResult = mysqli_query($dbConnect, $orderItemQuery);
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

<?php
include_once 'includes/amado/searchBar.php';
?>

<!-- ##### Main Content Wrapper Start ##### -->
<div class="main-content-wrapper d-flex clearfix">

    <?php
include_once 'includes/amado/sideNavBar.php';
?>

<div class="container">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body p-0">

                    <div class="row pb-5 p-5">
                        <div class="col-md-6">
                            <p class="font-weight-bold mb-4">Customer Information</p>
                            <p class="mb-1"><?php echo ucwords($_SESSION['userDetails']['0']['name']) ?></p>
                            <p class="mb-1"><?php echo $_SESSION['userDetails']['0']['email'] ?></p>
                            <p class="mb-1"><?php echo $_SESSION['userDetails']['0']['contact'] ?></p>
                            <p class="mb-1"><?php echo ucwords($_SESSION['userDetails']['0']['address']). ', ' .ucwords($_SESSION['userDetails']['0']['city']) ?></p>
                        </div>

                        <div class="col-md-6 text-right">
                            <p class="font-weight-bold mb-1">Invoice #<?php echo $order_id ?></p>
                            <p class="text-muted">Order Date: <?php
                            $convertDate = strtotime($order_date);
                            $order_date = date('d-M-Y', $convertDate);
                            echo $order_date; ?> </p>
                        </div>
                    </div>

                    <div class="row p-5">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="border-0 text-uppercase small font-weight-bold">Item</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Unit Price</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Quantity</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php if (mysqli_num_rows($orderItemQueryResult) > 0) {
                                while ($orderItem = $orderItemQueryResult->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?php echo ucwords($orderItem['product_name']) ?></td>
                                        <td><?php echo $orderItem['product_price'] ?></td>
                                        <td><?php echo $orderItem['product_quantity'] ?></td>
                                        <td><?php echo $orderItem['product_total'] ?></td>
                                    </tr>
                                  <?php
                                }
                            }?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex flex-row-reverse text-white p-2" style="background-color:#FBB807">
                        <div class="py-3 px-5 text-right">
                            <div class="mb-2">Grand Total</div>
                            <div class="h2 font-weight-light"><?php echo $order_cost ?></div>
                        </div>

                        <div class="py-3 px-5 text-right">
                            <div class="mb-2">Delivery</div>
                            <div class="h2 font-weight-light">Rs 250</div>
                        </div>

                        <div class="py-3 px-5 text-right">
                            <div class="mb-2">Sub - Total amount</div>
                            <div class="h2 font-weight-light"><?php echo $order_cost-250 ?></div>
                        </div>
                    </div>
                </div>
            </div>
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

    </body>

    </html>
