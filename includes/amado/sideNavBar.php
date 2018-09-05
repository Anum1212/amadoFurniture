<!-- Mobile Nav (max width 767px)-->
        <div class="mobile-nav">
            <!-- Navbar Brand -->
            <div class="amado-navbar-brand">
                <a href="index.php"><img src="/amadoFurniture/myAssets/amado/img/core-img/logo.png" alt=""></a>
            </div>
            <!-- Navbar Toggler -->
            <div class="amado-navbar-toggler">
                <span></span><span></span><span></span>
            </div>
        </div>

        <!-- Header Area Start -->
        <header class="header-area clearfix">
            <!-- Close Icon -->
            <div class="nav-close">
                <i class="fa fa-close" aria-hidden="true"></i>
            </div>
            <!-- Logo -->
            <div class="logo">
                <a href="index.php"><img src="/amadoFurniture/myAssets/amado/img/core-img/logo.png" alt=""></a>
            </div>
            <!-- Amado Nav -->
            <nav class="amado-nav">
                <ul>
                    <li <?php if (isset($pageIndicator) && strpos($pageIndicator, 'index') !== false) {
    echo 'class="active"';
}
?>><a href="/amadoFurniture/index.php">Home</a></li>
                    <li <?php if (isset($pageIndicator) && strpos($pageIndicator, 'search') !== false) {
    echo 'class="active"';
}
?>><a href="#" class="search-nav">Search</a></li>
                    <li <?php if (isset($pageIndicator) && strpos($pageIndicator, 'account') !== false) {
    echo 'class="active"';
}
?>><a href="/amadoFurniture/dashboardRedirector.php">Account</a></li>
                    <!-- show cart nav item if user type is customer -->
                    <?php if (isset($_SESSION['userDetails']['0']['user_type' == '1'])) {?>
                        <li <?php if (isset($pageIndicator) && strpos($pageIndicator, 'cart') !== false) {
    echo 'class="active"';
}
    ?>><a href="/amadoFurniture/cart.php">Cart</a></li> <?php }?>
                        <!-- show logout nav item if user is logged in -->
                    <?php if (isset($_SESSION['userDetails']['0']['name'])) {
    if (isset($_GET['logout'])) {
        session_unset();
        session_destroy();
        header("location: /amadoFurniture/index.php");
    }
    ?>
                        <li> <a href="/amadoFurniture/index.php?logout='1'" style="color: red;">logout</a> </li>
                    <?php }?>
                </ul>
            </nav>
        </header>
        <!-- Header Area End -->
