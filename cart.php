<?php

require_once 'connect.php';

$lastURL = 'cart.php';
// setting last url variable in a session so it can be accessed in case i want to redirect to last opened page
$_SESSION['lastURL'] = $lastURL;

// if not logged in goto login page
if (!isset($_SESSION['userDetails']['0']['name'])) {
    header('location: login.php');
}

// if logged in
if (isset($_SESSION['userDetails']['0']['name'])) {
    $customer_id = $_SESSION['userDetails']['0']['id'];
    $cartQuery = "SELECT * FROM cart WHERE customer_id = $customer_id";
    $cartQueryResult = mysqli_query($dbConnect, $cartQuery);
}

// pageIndicator var used to indicate which page the user is on so that that navbar link can be given active class
$pageIndicator = 'cart';
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
<?php
if (mysqli_num_rows($cartQueryResult) == 0) {
    ?>
  <div class="cart-table-area section-padding-100">
      <div class="container-fluid">
          <div class="row">
              <div class="col-12 col-lg-8">
                  <div class="cart-title mt-50">
                      <h2>Shopping Cart Empty</h2>
                  </div>
                </div>
                </div>
                </div>
                </div>
<?php
} ?>

<?php
if (mysqli_num_rows($cartQueryResult) > 0) {
        ?>
        <div class="cart-table-area section-padding-100">
            <div class="container-fluid">
            <?php
            include_once 'includes/errors.php';
            include_once 'includes/messages.php';
            ?>

                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="cart-title mt-50">
                            <h2>Shopping Cart</h2>
                        </div>

                        <form action="cartController.php" method="POST">
                            <div class="cart-table clearfix">
                                <table class="table table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i=0;
        $subtotal = [];
        while ($cart = $cartQueryResult->fetch_assoc()) {
            ?>
                                            <tr>

                                                <td class="cart_product_desc">
                                                    <h5>
                                                        <?php echo ucwords($cart['product_name']); ?>
                                                    </h5>
                                                </td>
                                                <td class="price">
                                                    <span>
                                                        <?php echo $cart['product_price']; ?>
                                                    </span>
                                                </td>
                                                <td class="qty">
                                                    <div class="qty-btn d-flex">
                                                        <div class="quantity">
                                                            <input type="number" value=<?php echo $cart['product_quantity'] ?> name="quantity[]">
                                                            <!-- getting row id -->
                                                            <input type="text" style="display:none" value="<?php echo $cart['id'] ?>" name="row_id[]">
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="cartController.php?row_id=<?php echo $cart['id']; ?>">
                                                                <i class="text-danger fas fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="subtotal">
                                                  <span>
                                                    <?php // add product prices
                                                    $subtotal[] = $cart['product_price']*$cart['product_quantity'];
            echo $subtotal[$i]; ?>
                                                  </span>
                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
        } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="cart-btn mt-50">
                                <button type="submit" name="updateCart" class="btn btn-success w-100">Update</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="cart-summary">
                            <h5>Cart Total</h5>
                            <ul class="summary-table">
                                <li>
                                  <?php
                                  $cartSubtotal = 0;
        for ($i=0; $i<count($subtotal); $i++) {
            $cartSubtotal = $cartSubtotal+$subtotal[$i];
        } ?>
                                    <span>subtotal:</span>
                                    <span>Rs <?php echo $cartSubtotal; ?></span>
                                </li>
                                <li>
                                    <span>delivery:</span>
                                    <span>Rs 250</span>
                                </li>
                                <li>
                                    <span>total:</span>
                                    <span>Rs <?php $total = $cartSubtotal+250;
        echo $total; ?></span>
                                </li>
                            </ul>
                            <div class="cart-btn mt-100">
                                <a href="cartController.php?checkOut" class="btn amado-btn w-100">Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } ?>
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
