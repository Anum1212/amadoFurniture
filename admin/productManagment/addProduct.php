<?php
require_once '../../connect.php';

$lastURL = '/furniture/admin/productManagment/addProduct.php';
// setting last url variable in a session so it can be accessed in case i want to redirect to last opened page
$_SESSION['lastURL'] = $lastURL;

// if not logged in goto login page
if (!isset($_SESSION['userDetails']['0']['name']) || $_SESSION['userDetails']['0']['user_type'] !== '0') {
    header('location: /furniture/login.php');
}

// if logged in
if (isset($_SESSION['userDetails']['0']['name']) && $_SESSION['userDetails']['0']['user_type'] == '0') {
// initializing variables
$category = "";
$brand = "";
$name = "";
$price = "";
$quantity = "";
$description = "";
$errors = array();

$categoryQuery = "SELECT * FROM categories WHERE category_status = 1";
$categoryQueryResult = mysqli_query($dbConnect, $categoryQuery);

// Add Product
if (isset($_POST['add_product'])) {
    // receive all input values from the form
    $category = trim(mysqli_real_escape_string($dbConnect, $_POST['productCategory'])," ");
    $brand = trim(strtolower(mysqli_real_escape_string($dbConnect, $_POST['brand'])), " ");
    $name = trim(strtolower(mysqli_real_escape_string($dbConnect, $_POST['name'])), " ");
    $price = trim(mysqli_real_escape_string($dbConnect, $_POST['price'])," ");
    $quantity = trim(mysqli_real_escape_string($dbConnect, $_POST['quantity'])," ");
    $description = trim(strtolower(mysqli_real_escape_string($dbConnect, $_POST['description'])), " ");

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($category)) {
        array_push($errors, "Product Category is required");
    }
    if (empty($brand)) {
        array_push($errors, "Brand is required");
    }
    if (empty($name)) {
        array_push($errors, "Name is required");
    }
    if (empty($price)) {
        array_push($errors, "Price is required");
    }
    if (empty($quantity)) {
        array_push($errors, "Quantity is required");
    }
    if (empty($description)) {
        array_push($errors, "Description is required");
    }

    if (count($errors) == 0) {
      $brandExploded = explode(" ", $brand);
      $nameExploded = explode(" ", $name);
      $brand_soundexExplodedArray = [];
      $name_soundexExplodedArray = [];
      for($i=0; $i<count($brandExploded); $i++)
      $brand_soundexExplodedArray[] = soundex ( $brandExploded[$i] );
      for($i=0; $i<count($nameExploded); $i++)
      $name_soundexExplodedArray[] = soundex ( $nameExploded[$i] );

      $brand_soundex = implode(" ", $brand_soundexExplodedArray);
      $name_soundex = implode(" ", $name_soundexExplodedArray);

        // Add product if there are no errors in the form
        $addProductQuery = "INSERT INTO products (category_id, brand, brand_soundex, name, name_soundex,description, price, quantity)
                    VALUES('$category', '$brand', '$brand_soundex', '$name', '$name_soundex', '$description', '$price', '$quantity')";
        mysqli_query($dbConnect, $addProductQuery);
        $insertedProductId = mysqli_insert_id($dbConnect);

        $target_dir = "../../myAssets/images/productImages/";
        for ($i = 0; $i < 4; $i++) {
            // creating $randomGenerator variable and concatinating with uploaded file name so each file name is unique
            $randomGenerator = time()."-".rand(1000, 9999)."-";
            $target_file = $target_dir . $randomGenerator . basename($_FILES["imageFile" . $i]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $check = getimagesize($_FILES["imageFile" . $i]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                array_push($errors, "File is not an image.");
                $uploadOk = 0;
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                array_push($errors, "Sorry, file already exists.");
                $uploadOk = 0;
            }
            // Check file size
            if ($_FILES["imageFile" . $i]["size"] > 5000000) {
                array_push($errors, "Sorry, your file is too large.");
                $uploadOk = 0;
            }
            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif") {
                array_push($errors, "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                array_push($errors, "Sorry, your file was not uploaded.");
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["imageFile" . $i]["tmp_name"], $target_file)) {

// Add product image file names into table
                    // save file name in a variable
                    $imageName = $randomGenerator . $_FILES['imageFile' . $i]['name'];
                    $addImageQuery = "INSERT INTO product_images (product_id, image_name, image_number)
                    VALUES ('$insertedProductId', '$imageName', '$i')";
                    mysqli_query($dbConnect, $addImageQuery);
                } else {
                    array_push($errors, "Sorry, there was an error uploading your file.");
                }
            }
        }

        header('location: viewAllProducts.php');
    }
    $_SESSION["errors"] = $errors;
}
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
<!-- imageUpload css   -->
<link rel="stylesheet" href="../../myAssets/css/imageUpload.css">
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
              <a href="/furniture/admin/adminDashboard.php">Account Details</a>
            </li>
            <li class="active">
              <a href="addProduct.php">Add Products</a>
            </li>
            <li>
              <a href="viewAllProducts.php">Edit Products</a>
            </li>
            <li>
              <a href="../orderManagment/viewAllOrders.php">Orders</a>
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
                            <h2>Add Product</h2>
                        </div>

                        <form action="addProduct.php" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-11 mb-3" style="overflow-x: visible !important">
                                  <select id="productCategory" name="productCategory">

                                    <?php while ($category = $categoryQueryResult->fetch_assoc()) {
                              ?>
                                    <option value="<?php echo $category['id']?>">
                                      <?php echo $category['name'] ?> </option>
                                    <?php
                          }?>

                                  </select>
                                </div>
                                <div class="col-11 mb-3">
                                    <input type="text" class="form-control" name="brand" id="brand" placeholder = "Enter Brand">
                                </div>
                                <div class="col-11 mb-3">
                                    <input type="text" class="form-control" name="name" id="name" placeholder = "Enter Name">
                                </div>
                                <div class="col-11 mb-3">
                                    <input type="number" class="form-control" name="price" id="price" placeholder = "Enter Price">
                                </div>
                                <div class="col-11 mb-3">
                                    <input type="number" class="form-control" name="quantity" id="quantity" placeholder = "Enter Quantity">
                                </div>
                                <div class="col-11 mb-3">
                                    <textarea class="form-control" name="description" id="description" rows="3" placeholder = "Enter Product Description"></textarea>
                                </div>
                                <div class="col-11 mb-3">
                                  <label>Upload Product Images</label>
                                  <div class="row">
                                    <?php for ($i=0; $i<4; $i++) {
                                    ?>
                                    <div class="form-group col-md-5">
                                      <div class="input-group">
                                        <span class="input-group-btn">
                                          <span class="btn btn-default btn-file<?php echo $i ?> btn-file-style">
                                            Browse…
                                            <input type="file" name="imageFile<?php echo $i ?>" id="imgInp<?php echo $i ?>" onclick="imageUpload(<?php echo $i ?>)">
                                          </span>
                                        </span>
                                        <input type="text" class="form-control" readonly>
                                      </div>

                                      <!-- image preview div -->
                                      <br>
                                      <img id='img-upload<?php echo $i ?>' />
                                      <br>

                                    </div>
                                    <?php
                                } ?>
                                  </div>
                                </div>

                              <div style="overflow:hidden">
                                <button type="submit" name="add_product" class="confirm btn amado-btn">
                                    Save
                                </button>
                              </div>

                            </div>
                        </form>
                    </div>

  </div>
</div>

    <?php
    include_once '../../includes/amado/footer.php';
    ?>

<?php
include_once '../../includes/amado/scripts.php';
?>

<!-- imageUpload js -->
<script src="../../myAssets/js/imageUpload.js"></script>
</body>

</html>
