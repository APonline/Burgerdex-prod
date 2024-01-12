<?php

$details = \Fr\LS::getUser();

$user = new User();
$userID =$details['id'];
$userData = $user->getUserInfo($details['id']);
$userData = json_decode($userData, true);

$form = "";

if($userData['profile_img']=="default.png"){
	$imgSrc="users/0/thumb/default.png";
}else{
	$imgSrc="users/".$userID."/thumb/".$userData['profile_img']."";
}
$form.= "<div>Profile Img: <img src='".$imgSrc."' /></div><br />";
$form.= "<div>Username: ".$userData['username']."</div><br />";
$form.= "<div>Email: ".$userData['email']."</div><br />";
$form.= "<div>Name: ".$userData['name']."</div><br />";
$form.= "<div>Member Since: ".$userData['created_string']."</div><br />";


$data = $_POST;



?>
