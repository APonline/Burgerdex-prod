<?php include('controller/user/controller.register.php'); ?>
<div class='submitForm'>
	<form action='<?php echo SITEPATH ?>/register' method='post' enctype="multipart/form-data" >
		<h1 style='text-align: center;letter-spacing: .87em;'>REGISTER</h1>
    <div>
    <?php
    echo $accountBtns;
    ?>

      <div class='form-group'>
  		  <label for='username' class='cols-sm-2 control-label'>Username</label>
  			<input name="username" placeholder="Username" />
  		</div>
      <div class='form-group'>
        <label for='email' class='cols-sm-2 control-label'>Email</label>
  			<input name="email" placeholder="E-Mail" />
  		</div>
      <div class='form-group'>
        <label for='password' class='cols-sm-2 control-label'>Password</label>
  			<input name="pass" type="password" placeholder="Password" />
  		</div>
      <div class='form-group'>
        <label for='retyped_password' class='cols-sm-2 control-label'>Retype Password</label>
  			<input name="retyped_password" type="password" placeholder="Retype Password" />
  		</div>
      <div class='form-group'>
        <label for='name' class='cols-sm-2 control-label'>Name</label>
  			<input name="name" placeholder="Name" />
  		</div>
      <div class='form-group cols-lg-12'>
        <button type='submit' name='submit' class='btn btn-primary btn-lg btn-block login-button'>Register</button>
      </div>

  	</form>
  	<?php
  	if( isset($_POST['submit']) ){
  		$username = $_POST['username'];
  		$email = $_POST['email'];
  		$password = $_POST['pass'];
  		$retyped_password = $_POST['retyped_password'];
  		$name = $_POST['name'];
  		if( $username == "" || $email == "" || $password == '' || $retyped_password == '' || $name == '' ){
  				echo "<h2>Fields Left Blank</h2>", "<p>Some Fields were left blank. Please fill up all fields.</p>";
  		}elseif( !\Fr\LS::validEmail($email) ){
  				echo "<h2>E-Mail Is Not Valid</h2>", "<p>The E-Mail you gave is not valid</p>";
  		}elseif( !ctype_alnum($username) ){
  				echo "<h2>Invalid Username</h2>", "<p>The Username is not valid. Only ALPHANUMERIC characters are allowed and shouldn't exceed 10 characters.</p>";
  		}elseif($password != $retyped_password){
  				echo "<h2>Passwords Don't Match</h2>", "<p>The Passwords you entered didn't match</p>";
  		}else{
  			$createAccount = \Fr\LS::register($username, $password,
  				array(
  					"email" => $email,
  					"name" => $name,
  					"created" => date("Y-m-d H:i:s") // Just for testing
  				)
  			);
  			if($createAccount === "exists"){
  				echo "<label>User Exists.</label>";
  			}elseif($createAccount === true){
  				echo "<label>Success. Created account. <a href='".SITEPATH."/login'>Log In</a></label>";
  			}
  		}
  	}
  	?>
  </div>
</div>
