<?php
require_once '../../connect.php';

// if not logged in goto login page
if (!isset($_SESSION['userDetails']['0']['name']) || $_SESSION['userDetails']['0']['user_type'] !== '0') {
    header('location: /amadoFurniture/login.php');
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
if (isset($_GET['product_id'])) {
    $categoryQuery = "SELECT * FROM categories WHERE category_status = 1";
    $categoryQueryResult = mysqli_query($dbConnect, $categoryQuery);

    $product_id = $_GET['product_id'];
    $productQuery = "SELECT * FROM products WHERE id = $product_id";
    $productQueryResult = mysqli_query($dbConnect, $productQuery);

    $imageQuery = "SELECT * FROM product_images WHERE product_id = $product_id";
    $imageQueryResult = mysqli_query($dbConnect, $imageQuery);

$lastURL = '/amadoFurniture/admin/productManagment/editProduct.php?product_id='. $product_id;
// setting last url variable in a session so it can be accessed in case i want to redirect to last opened page
$_SESSION['lastURL'] = $lastURL;

}
?>
<?php
// Edit Product
if (isset($_POST['edit_product'])) {

    // receive all input values from the form
    $category = trim(mysqli_real_escape_string($dbConnect, $_POST['productCategory'])," ");
    $brand = trim(strtolower(mysqli_real_escape_string($dbConnect, $_POST['brand'])), " ");
    $name = trim(strtolower(mysqli_real_escape_string($dbConnect, $_POST['name'])), " ");
    $price = trim(mysqli_real_escape_string($dbConnect, $_POST['price'])," ");
    $quantity = trim(mysqli_real_escape_string($dbConnect, $_POST['quantity'])," ");
    $description = trim(strtolower(mysqli_real_escape_string($dbConnect, $_POST['description'])), " ");

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($category)) {array_push($errors, "Product Category is required");}
    if (empty($brand)) {array_push($errors, "Brand is required");}
    if (empty($name)) {array_push($errors, "Name is required");}
    if (empty($price)) {array_push($errors, "Price is required");}
    if (empty($quantity)) {array_push($errors, "Quantity is required");}
    if (empty($description)) {array_push($errors, "Description is required");}

    // Add product if there are no errors in the form
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
        // update product query
        $editProductQuery = "UPDATE products SET category_id = '$category', brand = '$brand', brand_soundex = '$brand_soundex', name = '$name', name_soundex = '$name_soundex', description = '$description', price = '$price', quantity = '$quantity' WHERE id = '$product_id'";
        mysqli_query($dbConnect, $editProductQuery);

        // upload difrectory path
        $target_dir = "../../myAssets/images/productImages/";
        $deleteFileName = [];
        while ($imageFileNames = mysqli_fetch_assoc($imageQueryResult)) {
            $deleteFileName[] = $imageFileNames;
        }

        for ($i = 0; $i < 4; $i++) {

            // check if file was uploaded in any file input
            if (file_exists($_FILES["imageFile" . $i]['tmp_name']) || is_uploaded_file($_FILES["imageFile" . $i]['tmp_name'])) {

                // creating $randomGenerator variable and concatinating with uploaded file name so each file name is unique
                $randomGenerator = time() . "-" . rand(1000, 9999) . "-";
                $target_file = $target_dir . $randomGenerator . basename($_FILES["imageFile" . $i]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // check size
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
                        $updateImageQuery = "UPDATE product_images SET image_name = '$imageName' WHERE product_id = '$product_id' AND image_number = '$i'";
                        mysqli_query($dbConnect, $updateImageQuery);
                        unlink($target_dir . $deleteFileName[$i]['image_name']); //delete it
                    } else {
                        array_push($errors, "Sorry, there was an error uploading your file.");
                    }
                }
            }
            header('location: editProduct.php?product_id=' . $product_id);
        }
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
              <a href="/amadoFurniture/admin/adminDashboard.php">Account Details</a>
            </li>
            <li class="active">
              <a href="addProduct.php">Add Product</a>
            </li>
            <li>
              <a href="viewAllProducts.php">Edit Products</a>
            </li>
            <li>
              <a href="#">Orders</a>
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

                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">
                              <?php if(mysqli_num_rows($productQueryResult)>0) {
                                  while($product = $productQueryResult->fetch_assoc()){
                                  ?>
                                <div class="col-11 mb-3" style="overflow-x: visible !important">
                                  <select id="productCategory" name="productCategory">

                                    <?php while ($category = $categoryQueryResult->fetch_assoc()) {?>
                                    <option <?php if($product['category_id']==$category[ 'id']) echo 'selected="selected"'; ?> value="<?php echo $category['id']?>"><?php echo $category['name'] ?> </option>
                                    <?php } ?>

                                  </select>
                                </div>
                                <div class="col-11 mb-3">
                                    <input type="text" class="form-control" value="<?php echo $product['brand'] ?>" name="brand" id="brand" placeholder = "Enter Brand">
                                </div>
                                <div class="col-11 mb-3">
                                    <input type="text" class="form-control" value="<?php echo $product['name'] ?>" name="name" id="name" placeholder = "Enter Name">
                                </div>
                                <div class="col-11 mb-3">
                                    <input type="number" class="form-control" value="<?php echo $product['price'] ?>" name="price" id="price" placeholder = "Enter Price">
                                </div>
                                <div class="col-11 mb-3">
                                    <input type="number" class="form-control" value="<?php echo $product['quantity'] ?>" name="quantity" id="quantity" placeholder = "Enter Quantity">
                                </div>
                                <div class="col-11 mb-3">
                                    <textarea class="form-control" name="description" id="description" placeholder = "Enter Product Description" rows="3"><?php echo $product['description'] ?></textarea>
                                </div>
                                <div class="col-11 mb-3">
                                  <label>Upload Product Images</label>
                                    <div class="row">
                                    <?php
                                    // $i = 0;
                                    if(mysqli_num_rows($imageQueryResult)>0) {
                                      // while($productImage = $imageQueryResult->fetch_assoc()){
                                        for($i=0; $productImage = $imageQueryResult->fetch_assoc(); $i++){
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
                                        <img id='img-upload<?php echo $i ?>' src="../../myAssets/images/productImages/<?php if ($i == $productImage['image_number']) echo $productImage['image_name']?>" style="width: 25vw; height: 25vh"/>
                                        <br>

                                      </div>
                                      <?php
                                      // }
                                      // $i++;
                                      }
                                    }
                                    ?>
                                    </div>
                                </div>
                                <?php
                                }
                              }
                              ?>
                              <div style="overflow:hidden">
                                <button type="submit" name="edit_product" class="confirm btn amado-btn">
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
