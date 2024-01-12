<?php

if(isset($_SESSION)==null){
  $err="";
  $pgTitle="ACCOUNT";
  $accountBtns="<div>
    <ul>
      <li><a href='".SITEPATH."/login'>LOGIN</a></li>
      <li><a href='".SITEPATH."/register'>REGISTER</a></li>
    </ul>
    </div>";
  $form="";

}else{
  include('controller/user/controller.account.php');
  $err="";
  $pgTitle="ACCOUNT";
  $accountBtns="<div>
    <ul>
      <li><a href='".SITEPATH."/passport'>PASSPORT</a></li>
      <li><a href='".SITEPATH."/logout'>LOGOUT</a></li>
    </ul>
    </div>";
}

?>

<div class='submitForm'>
	<form action='<?php echo SITEPATH ?>/account' method='post' enctype="multipart/form-data" >
		<h5 style="color:red;text-align: center;"><?php echo $err; ?></h5>
		<h1><?php echo $pgTitle; ?></h1>

    <div>
    <?php
    echo $accountBtns;
    ?>

		<?php
		echo $form;
		?>
  </div>
	</form>
</div>
