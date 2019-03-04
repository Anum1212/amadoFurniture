<?php
require_once 'connect.php';

// path level to help me adjust asset paths 
$_SESSION['pathLevel'] = '';


// initializing variables
$email = "";
$errors = array();
$messages = array();

// LOGIN USER
if (isset($_POST['login_user'])) {
    $email = mysqli_real_escape_string($dbConnect, $_POST['email']);
    $password = mysqli_real_escape_string($dbConnect, $_POST['password']);

    if (empty($email)) {
        array_push($errors, "email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $results = mysqli_query($dbConnect, $query);
        if (mysqli_num_rows($results) == 1) {

            // initializing array to store logged in user details
            $userDetails = array();
            while ($row = $results->fetch_assoc()) {
                // storing values to userDetails variable
                $userDetails[] = $row;
                // setting userDetails variable in a session so it can be accessed across the entire site
                $_SESSION['userDetails'] = $userDetails;
            }
            if ($_SESSION['userDetails']['0']['user_type'] == '0') {
                header('location: admin/adminDashboard.php');
            } else
            if (isset($_SESSION['lastURL'])) {
                header('location:' . $_SESSION['lastURL']);
            } else {
                header('location: customer/customerDashboard.php');
            }

        } else {
            array_push($errors, "Wrong email/password combination");
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
<?php
include_once 'includes/errors.php';
include_once 'includes/messages.php';
?>
                <div class="row">
                    <div class="col-12">
                        <div class="checkout_details_area mt-50 clearfix">

                            <div class="cart-title">
                                <h2>Sign In</h2>
                            </div>

                            <form action="login.php" method="post">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <input type="password" name="password" class="form-control" id="password" placeholder="Password" value="">
                                    </div>

                                    <div class="col-12">
                                        <div class="custom-control d-block mb-2">
                                            <label>Not a member yet? <a href="register.php" class= "text-warning">Sign Up</a></label>
                                        </div>
                                    </div>

                                                                <div class="cart-btn mt-100">
                                <button type="submit" name="login_user" class="btn amado-btn w-100">Sign In</button>
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
