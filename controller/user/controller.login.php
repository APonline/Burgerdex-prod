<?php

/*
 * Only the config show be required at this level. Everything else should be below our isset and post checks.
 */
//require "./inc/config.php";

if(isset($_POST['action_login'])){

  $identification = $_POST['login'];
  $password = $_POST['password'];

  if($identification == "" || $password == ""){

    $msg = array("Error", "Username / Password is incorrect.");

  }else{

    $login = \Fr\LS::login($identification, $password, isset($_POST['remember_me']), true);
//var_dump($login);
    if($login === false){

      $msg = array("Error", "Username / Password is incorrect.");

    }else if(is_array($login) && $login['status'] == "blocked"){

      $msg = array("Error", "Too many login attempts. You can attempt to login after ". $login['minutes'] ." minutes (". $login['seconds'] ." seconds)");
      $enable = "disabled";

    }
  }
}

$accountBtns="<div>
	<ul>
		<li><a href='".SITEPATH."/register'>REGISTER</a></li>
	</ul>
	</div>";
$form="";
$enable = "";
$problem = "";
if(isset($msg)) $problem = "<h5 style='color:red;text-align: center;'>{$msg[0]}: {$msg[1]}</h5>";

$form = "
  <div class='form-group'>
    <label for='username' class='cols-sm-2 control-label'>Username</label>
    <input type='text' name='login' class='form-control inputField' placeholder='Username OR Email' required autofocus>
  </div>
  <div class='form-group'>
    <label for='password' class='cols-sm-2 control-label'>Password</label>
    <input type='password' name='password' class='form-control inputField' id='password' placeholder='Password' required>
  </div>
  ".$problem."
  <div class='form-group cols-lg-12'>
    <button type='submit' name='action_login' class='btn btn-primary btn-lg btn-block login-button'".$enable.">Sign in</button>
    <input type='checkbox' value='remember-me' id='remember_me' name='remember_me'>
    <label for='remember_me' class='cols-sm-2 control-label'>Remember me</label>
    <a href='reset-password' class='need-help cols-sm-2 pull-right' style='float: right;'>Forgot Password?</a>
  </div>
  ";

?>
