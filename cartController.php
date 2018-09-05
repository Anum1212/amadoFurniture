<?php

require_once 'connect.php';


// if user not logged in redirect to login
if (!isset($_SESSION['userDetails']['0']['name'])) {
    header('location: login.php');
}

// if user logged in continue
if (isset($_SESSION['userDetails']['0']['name'])) {
    $lastURL = $_SESSION['lastURL'];
    $customer_id = $_SESSION['userDetails']['0']['id'];

    // |----------------| add product to cart |----------------|
    if (isset($_POST['addToCart']) && isset($_GET['product_id'])) {
        $productQuantity = $_POST['quantity'];
        $product_id = $_GET['product_id'];

        $productQuery = "SELECT * FROM products WHERE id = $product_id";
        $productQueryResult = mysqli_query($dbConnect, $productQuery);
        if (mysqli_num_rows($productQueryResult) > 0) {
            while ($product = $productQueryResult->fetch_assoc()) {
                $categoryId = $product['category_id'];
                $productName = $product['name'];
                $productPrice = $product['price'];
            }
        }

        $addToCartQuery = mysqli_query($dbConnect, "INSERT INTO
        cart (customer_id, product_id, product_name, product_price, product_quantity)
        VALUES('$customer_id', '$product_id', '$productName', $productPrice, '$productQuantity')");
        $_SESSION["successMessage"] = $productName ." added!";

        header('location: ' . $lastURL);
    }

    // |----------------| update cart item quantity |----------------|
    if (isset($_POST['updateCart'])) {
        // receive all input values from the form
        $quantityArray = $_POST['quantity'];
        $row_id = $_POST['row_id'];

        foreach ($quantityArray as $key => $quantity) {
            $updateCartQuery = "UPDATE cart SET product_quantity = '$quantity' WHERE id = '$row_id[$key]' AND customer_id = '$customer_id'";
            mysqli_query($dbConnect, $updateCartQuery);
        }
        $_SESSION["successMessage"] = "Cart Updated!";

        header('location: ' . $lastURL);
    }

    // |----------------| delete cart item |----------------|
    if (isset($_GET['row_id'])) {
        $row_id = $_GET['row_id'];

        $deleteCartItemQuery = "DELETE FROM cart WHERE id = '$row_id' AND customer_id = '$customer_id'";
        mysqli_query($dbConnect, $deleteCartItemQuery);
        $_SESSION["successMessage"] = "Item Deleted!";
        header('location: ' . $lastURL);
    }

    // |----------------| checkOut cart |----------------|
    if (isset($_GET['checkOut'])) {

      // get result from cart table
        $cartQuery = "SELECT * FROM cart WHERE customer_id = $customer_id";
        $cartQueryResult = mysqli_query($dbConnect, $cartQuery);

        // calculate order subtotal
        $cartSubtotal = 0;
        for ($i=0; $cart = $cartQueryResult->fetch_assoc(); $i++) {
            $subtotal[] = $cart['product_price']*$cart['product_quantity'];
            $cartSubtotal = $cartSubtotal+$subtotal[$i];
        }
        // add delivery charges to subtotal and get order total
        $total = $cartSubtotal+250;


        // insert details in orders table
        $orderQuery = "INSERT INTO
      orders (order_date, customer_id, cost)
      VALUES (now(), '$customer_id', '$total')";
        mysqli_query($dbConnect, $orderQuery);
        $order_id = mysqli_insert_id($dbConnect);

        // get result from cart table (again)
        $cartQuery = "SELECT * FROM cart WHERE customer_id = $customer_id";
        $cartQueryResult = mysqli_query($dbConnect, $cartQuery);

        // save cart values in variables
        while ($cart = $cartQueryResult->fetch_assoc()) {
            $cartRow_id = $cart['id'];
            $product_id = $cart['product_id'];
            $product_name = $cart['product_name'];
            $product_price = $cart['product_price'];
            $product_quantity = $cart['product_quantity'];
            $product_total = $cart['product_price']*$cart['product_quantity'];

            // insert cart item details in order_items table
            $orderItemQuery = "INSERT INTO
        order_items (order_id, product_id, product_name, product_price, product_quantity, product_total)
        VALUES ('$order_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_total')";
            mysqli_query($dbConnect, $orderItemQuery);

            // delete the item from cart
            $deleteCartItemQuery = "DELETE FROM cart WHERE id = '$cartRow_id' AND customer_id = '$customer_id'";
            mysqli_query($dbConnect, $deleteCartItemQuery);
        }

        header('location: invoice.php?order_id='.$order_id);
    }
}
