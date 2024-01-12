<?php include('controller/controller.register.php'); ?> 
 
<div class='submitForm'>
	<form action='<?php echo SITEPATH ?>/submit' method='post' enctype="multipart/form-data" >
		<h5 style="color:red;text-align: center;"><?php echo $err; ?></h5>
		<h1>REGISTER</h1>
		
		<?php
		echo $form;
		?>
		
	</form>
</div>