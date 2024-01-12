<?php

ini_set("display_errors", "on");

$nav = array();
	//site nav
	$navSite = array();
	$navSite[] = array("name"=>"Catalogue","url"=>"burgers");
	//$navSite[] = array("name"=>"submit","url"=>"submit");
	//$navSite[] = array("name"=>"account","url"=>"account");
	//$navSite[] = array("name"=>"logout","url"=>"logout");

$GLOBALS['nav'] = $navSite;

$sort = array();
	//site nav
	$sortSite = array();
	$sortSite[] = array("name"=>"Featured","url"=>"featured");
	$sortSite[] = array("name"=>"No.","url"=>"number");
	$sortSite[] = array("name"=>"Discovered","url"=>"discovered");
	$sortSite[] = array("name"=>"Rating","url"=>"rating");
	$sortSite[] = array("name"=>"Vegetarian","url"=>"vegetarian");
	$sortSite[] = array("name"=>"Spicy","url"=>"spicy");
	$sortSite[] = array("name"=>"Seasonal","url"=>"seasonal");
	$sortSite[] = array("name"=>"Extinct","url"=>"extinct");
	$sortSite[] = array("name"=>"Challenge","url"=>"challenge");
	$sortSite[] = array("name"=>"Price Hi","url"=>"price-hi");
	$sortSite[] = array("name"=>"Price LO","url"=>"price-lo");
	$sortSite[] = array("name"=>"Fusion","url"=>"fusion");
	$sortSite[] = array("name"=>"Modded","url"=>"modded");
	$sortSite[] = array("name"=>"Location","url"=>"location");
	$sortSite[] = array("name"=>"Kitchen","url"=>"kitchen");

$GLOBALS['sort'] = $sortSite;


require_once("model/class.route.php");
$route = new Route();
if(isset($_REQUEST['uri'])){
	$u = $_REQUEST['uri'];
}else{
	$u = "/home";
}
$GLOBALS['active'] = $u;

$sitePath = 'https://' . $_SERVER['HTTP_HOST'] . "";
//$sitePath = 'http://' . $_SERVER['HTTP_HOST'] . "/Burgerdex/dev/web/web.Burgerdex";
$siteRouteDir = "";
$sitePathStatic = 'https://static.burgerdex.ca';
//echo $sitePath;die();
define("SITEPATH", $sitePath);
define("SITE_PATH_STATIC", $sitePathStatic);

include('model/LS.php');

if($GLOBALS['active']=="login"||$GLOBALS['active']=="account"){
	$nologinPath = "";
}else{
	$nologinPath = $GLOBALS['active'];
}

	\Fr\LS::config(array(
	  "db" => array(
	    "host" => "mysql.andrewphillips.online",
	    "port" => 3306,
	    "username" => "apanemia",
	    "password" => "milkmilk1",
	    "name" => "burgerdex",
	    "table" => "users"
	  ),
	  "features" => array(
	    "auto_init" => true
	  ),
	  "pages" => array(
	    "no_login" => array(
	      "/",
			$siteRouteDir . "/test",
		  $siteRouteDir . "/home",
		  $siteRouteDir . "/burger",
		  $siteRouteDir . "/burgers",
		  $siteRouteDir . "/submit",
		  $siteRouteDir . "/register",
		  $siteRouteDir . "/".$nologinPath."",
	      $siteRouteDir . "/reset-password",
	      $siteRouteDir . "/logout"
	    ),
	    "everyone" => array(
	      "/",
			$siteRouteDir . "/test",
		  $siteRouteDir . "/home",
		  $siteRouteDir . "/burger",
		  $siteRouteDir . "/burgers",
		  $siteRouteDir . "/submit",
		  $siteRouteDir . "/register",
		  $siteRouteDir . "/".$nologinPath."",
	      $siteRouteDir . "/reset-password",
	      $siteRouteDir . "/logout"
	    ),
	    "login_page" => $siteRouteDir . "/login",
	    "home_page" =>  $siteRouteDir . "/account"
	  )
	));

if($GLOBALS['active']=="logout"){
	\Fr\LS::logout();
}else{
	require_once("appRoute.php");
}
?>
