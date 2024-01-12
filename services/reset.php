<?php

  require_once(__DIR__. "/../inc/config.php");
  require_once("../template/header.php");
?>

<div class="container-fluid">
  <div class="row">
    <div class="col-sm-3 col-md-3 col-lg-4"></div>
      <div class="col-sm-6 col-md-6 col-lg-4">
          <div class="main-login main-center">
            <?php \Fr\LS::forgotPassword(); ?>
          </div>
      </div>
      <div class="col-sm-3 col-md-3 col-lg-4"></div>
  </div>
</div>

<?php require_once(__DIR__."/../template/footer.php"); ?>
