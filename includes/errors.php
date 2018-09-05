<?php
if (isset($_SESSION["errors"])) {
  if (count($_SESSION["errors"]) > 0): ?>
<div class="alert alert-danger alert-dismissible">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<?php foreach ($_SESSION["errors"] as $error): ?>
<p><?php echo $error; ?></p>
<?php endforeach?>
</div>
<?php
endif;
unset($_SESSION['errors']);
}
?>
