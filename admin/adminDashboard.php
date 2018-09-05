<?php

require_once '../connect.php';

$lastURL = '/furniture/admin/adminDashboard.php';
// setting last url variable in a session so it can be accessed in case i want to redirect to last opened page
$_SESSION['lastURL'] = $lastURL;

// if not logged in goto login page
if (!isset($_SESSION['userDetails']['0']['name']) || $_SESSION['userDetails']['0']['user_type'] != '0') {
    // echo 'not admin';
    header('location: /furniture/login.php');
}

// if logged in
if (isset($_SESSION['userDetails']['0']['name']) && $_SESSION['userDetails']['0']['user_type'] == '0') {
    $customer_id = $_SESSION['userDetails']['0']['id'];
    $customer_name = $_SESSION['userDetails']['0']['name'];
    $customer_email = $_SESSION['userDetails']['0']['email'];
    $customer_contact = $_SESSION['userDetails']['0']['contact'];
    $customer_address = $_SESSION['userDetails']['0']['address'];
    $customer_city = $_SESSION['userDetails']['0']['city'];
}

// initializing variables
$name = "";
$contact = "";
$address = "";
$city = "";
$errors = array();

// REGISTER USER
if (isset($_POST['editCustomerDetails'])) {
    // receive all input values from the form
    $name = mysqli_real_escape_string($dbConnect, $_POST['name']);
    $contact = mysqli_real_escape_string($dbConnect, $_POST['contact']);
    $address = mysqli_real_escape_string($dbConnect, $_POST['address']);
    $city = mysqli_real_escape_string($dbConnect, $_POST['city']);

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($name)) {
        array_push($errors, "Name is required");
    }
    if (empty($contact)) {
        array_push($errors, "Contact is required");
    }
    if (empty($address)) {
        array_push($errors, "Address is required");
    }
    if (empty($city)) {
        array_push($errors, "City is required");
    }

    // first check the database to make sure
    // a user does not already exist with the same name and/or email
    $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($dbConnect, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password_1); //encrypt the password before saving in the database

        $query = "UPDATE users SET name = '$name', contact = '$contact', address = '$address', city = '$city'";
        mysqli_query($dbConnect, $query);

        $userId = $_SESSION['userDetails']['0']['id'];
        $customerDetailsQuery = "SELECT * FROM users WHERE id='$userId'";
        $customerDetailsQueryresult = mysqli_query($dbConnect, $customerDetailsQuery);
        if (mysqli_num_rows($customerDetailsQueryresult) == 1) {

            // initializing array to store logged in user details
            $userDetails = array();
            while ($row = $customerDetailsQueryresult->fetch_assoc()) {
                // storing values to userDetails variable
                $userDetails[] = $row;
                // setting userDetails variable in a session so it can be accessed across the entire site
                $_SESSION['userDetails'] = $userDetails;
            }
}

        header('location: customerDashboard.php');
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
            <li class="active">
              <a href="/furniture/admin/adminDashboard.php">Account Details</a>
            </li>
            <li>
              <a href="productManagment/addProduct.php">Add Products</a>
            </li>
            <li>
              <a href="productManagment/viewAllProducts.php">Edit Products</a>
            </li>
            <li>
              <a href="orderManagment/viewAllOrders.php">Orders</a>
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
                            <h2>Account Details</h2>
                        </div>

                        <form id="customerDetailsForm" action="#" method="post">
                            <div class="row">
                                <div class="col-11 mb-3">
                                    <input type="text" name="name" class="form-control" id="name" value="<?php echo ucwords($customer_name); ?>" placeholder="Name">
                                </div>
                                <div class="col-11 mb-3">
                                    <input type="email" name="email" class="form-control" id="email" value="<?php echo ucwords($customer_email); ?>" placeholder="Email" disabled>
                                </div>
                                <div class="col-11 mb-3">
                                    <input type="text" name="contact" class="form-control" id="contact" value="<?php echo $customer_contact; ?>" placeholder="Contact">
                                </div>
                                <div class="col-11 mb-3">
                                    <input type="text" name="address" class="form-control" id="address" value="<?php echo ucwords($customer_address); ?>" placeholder="Address">
                                </div>
                                <div class="col-11 mb-3">
                                    <input type="text" name="city" class="form-control" id="city" value="<?php echo ucwords($customer_city); ?>" placeholder="City">
                                </div>

                              <div style="overflow:hidden">
                                <button type="button" onclick="allowEdit()" class="allowEdit btn amado-btn">
                                    Edit
                                </button>
                                <button type="button" onclick="cancelEdit()" class="cancelEdit btn amado-btn">
                                    Cancel
                                </button>
                                <button type="submit" name="editCustomerDetails" class="confirm saveButton btn amado-btn">
                                    Save
                                </button>
                              </div>

                            </div>
                        </form>
                    </div>

  </div>
</div>

    <?php
    include_once '../includes/amado/footer.php';
    ?>

<?php
include_once '../includes/amado/scripts.php';
?>

<script>

$(document).ready(function () {
    $('#customerDetailsForm input').attr('disabled', true);
    $(".cancelEdit").hide();
    $(".saveButton").hide();
});

function allowEdit() {
    $('#customerDetailsForm input').attr('disabled', false);
    $('#customerDetailsForm input[name=email]').attr('disabled', true);
    $(".allowEdit").hide();
    $(".saveButton").show();
    $(".cancelEdit").show();
}

function cancelEdit() {
    $('input').attr('disabled', true);
    $(".allowEdit").show();
    $(".cancelEdit").hide();
    $(".saveButton").hide();
    $('#editForm')[0].reset();
}

</script>

</body>

</html>
