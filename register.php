<?php
require_once 'connect.php';

// initializing variables
$name = "";
$email = "";
$contact = "";
$address = "";
$city = "";
$errors = array();

// REGISTER USER
if (isset($_POST['register_user'])) {
    // receive all input values from the form
    $name = trim(strtolower(mysqli_real_escape_string($dbConnect, $_POST['name'])), " ");
    $email = trim(strtolower(mysqli_real_escape_string($dbConnect, $_POST['email'])), " ");
    $contact = trim(strtolower(mysqli_real_escape_string($dbConnect, $_POST['contact'])), " ");
    $address = trim(strtolower(mysqli_real_escape_string($dbConnect, $_POST['address'])), " ");
    $city = trim(strtolower(mysqli_real_escape_string($dbConnect, $_POST['city'])), " ");
    $password_1 = trim(mysqli_real_escape_string($dbConnect, $_POST['password_1']), " ");
    $password_2 = trim(mysqli_real_escape_string($dbConnect, $_POST['password_2']), " ");

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($name)) {
        array_push($errors, "Name is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
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
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }
    // first check the database to make sure
    // a user does not already exist with the same name and/or email
    $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($dbConnect, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists

        if ($user['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password_1); //encrypt the password before saving in the database

        $query = "INSERT INTO users (name, email, contact, address, city, password)
  			  VALUES('$name', '$email', '$contact', '$address', '$city', '$password')";
        mysqli_query($dbConnect, $query);
        $_SESSION["successMessage"] = "Registration Successful!";
        header('location: login.php');
    }
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


        <div class="cart-table-area section-padding-100">
            <div class="container-fluid">
                                   <div class="container-fluid">
            <?php
include_once 'includes/errors.php';
include_once 'includes/messages.php';
?>
                <div class="row">
                    <div class="col-12">
                        <div class="checkout_details_area mt-50 clearfix">

                            <div class="cart-title">
                                <h2>Sign Up</h2>
                            </div>

                            <form action="#" method="post">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <input type="text" name="name" class="form-control" id="name" value="<?php echo $name; ?>" placeholder="Name">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <input type="email" name="email" class="form-control" id="email" value="<?php echo $email; ?>" placeholder="Email">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <input type="text" name="contact" class="form-control" id="contact" value="<?php echo $contact; ?>" placeholder="Contact">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <input type="text" name="address" class="form-control" id="address" value="<?php echo $address; ?>" placeholder="Address">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <input type="text" name="city" class="form-control" id="city" value="<?php echo $city; ?>" placeholder="City">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <input type="password" name="password_1" class="form-control" id="password" placeholder="Password">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <input type="password" name="password_2" class="form-control" id="password" placeholder="Re-enter Password">
                                    </div>

                                    <div class="col-12">
                                        <div class="custom-control d-block mb-2">
                                            <label>Already a member? <a href="login.php" class= "text-warning">Sign Up</a></label>
                                        </div>
                                    </div>

                                                                <div class="cart-btn mt-100">
                                <button type="submit" name="register_user" class="btn amado-btn w-100">Sign Up</button>
                            </div>

                                </div>
                            </form>
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
