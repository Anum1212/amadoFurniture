<?php

require_once 'connect.php';

// pageIndicator var used to indicate which page the user is on so that that navbar link can be given active class
$pageIndicator = 'account';

// path level to help me adjust asset paths 
$_SESSION['pathLevel'] = '';

$lastURL = 'dashboardRedirector.php';
// setting last url variable in a session so it can be accessed in case i want to redirect to last opened page
$_SESSION['lastURL'] = $lastURL;

// if not logged in goto login page
if (!isset($_SESSION['userDetails']['0']['name'])) {
    header('location: login.php');
}

// if logged in
if (isset($_SESSION['userDetails']['0']['name'])){
    // if user type 0 -> admin
    if ($_SESSION['userDetails']['0']['user_type'] == '0'){
        header('location: admin/adminDashboard.php');
    }
    // if user type 1 -> customer
if ($_SESSION['userDetails']['0']['user_type'] == '1'){
header('location: customer/customerDashboard.php');
}
}


?>
