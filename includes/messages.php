<?php
if (isset($_SESSION["successMessage"])) { ?>
<div class="alert alert-success alert-dismissible">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<p><?php echo $_SESSION["successMessage"] ?></p>
</div>
<?php
unset($_SESSION['successMessage']);
}
?>
