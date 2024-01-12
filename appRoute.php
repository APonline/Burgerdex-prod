<?php

/*PAGE VIEWS*/
//Home
$route->add("", function() {
	$siteTitle = "BurgerDex";
	$siteDesc = "A documented catalog of Burgers from all around. Find a selection of burgers of all kinds,
	even see what burgers had existed but are not extinct. There are many patties out there, and now you
	have a way to know where to go and for what to satisfy your burger desires!";

	getClasses();

	$GLOBALS['active'] = "/";
	getHead($siteTitle, $siteDesc);
	//include('view/catalogue/loader.php');

	$search = "number";
	if (isset($page)) { $page = $page; } else { $page=1; };
	$limit = 10;
	$start_from = ($page-1) * $limit;
	$pgType="burgers";

	$burger = new Posts;
	$burgers = $burger->getBurgers($search,$start_from);

	$burgerList= $burgers[0];
	$burgerCount= $burgers[1];

	$sortSet = $search;
	$numCount = $search;

	include('view/catalogue/home.php');
	getFoot();
});
$route->add("/", function() {
	$siteTitle = "BurgerDex";
	$siteDesc = "A documented catalog of Burgers from all around. Find a selection of burgers of all kinds,
	even see what burgers had existed but are not extinct. There are many patties out there, and now you
	have a way to know where to go and for what to satisfy your burger desires!";

	getClasses();

	$GLOBALS['active'] = "burgers";
	getHead($siteTitle, $siteDesc);
	include('view/catalogue/loader.php');

	$search = "number";
	if (isset($page)) { $page = $page; } else { $page=1; };
	$limit = 10;
	$start_from = ($page-1) * $limit;
	$pgType="burgers";

	$burger = new Posts;
	$burgers = $burger->getBurgers($search,$start_from);

	$burgerList= $burgers[0];
	$burgerCount= $burgers[1];

	$sortSet = $search;
	$numCount = $search;

	include('view/catalogue/burgers.php');
	getFoot();
});
$route->add("/home", function() {
	$siteTitle = "BurgerDex";
	$siteDesc = "A documented catalog of Burgers from all around. Find a selection of burgers of all kinds,
	even see what burgers had existed but are not extinct. There are many patties out there, and now you
	have a way to know where to go and for what to satisfy your burger desires!";

	getClasses();

	$GLOBALS['active'] = "burgers";
	getHead($siteTitle, $siteDesc);
	include('view/catalogue/loader.php');

	$search = "number";
	if (isset($page)) { $page = $page; } else { $page=1; };
	$limit = 10;
	$start_from = ($page-1) * $limit;
	$pgType="burgers";

	$burger = new Posts;
	$burgers = $burger->getBurgers($search,$start_from);

	$burgerList= $burgers[0];
	$burgerCount= $burgers[1];

	$sortSet = $search;
	$numCount = $search;

	include('view/catalogue/burgers.php');
	getFoot();
});
//Burgers
$route->add("/burgers", function() {
	$siteTitle = "BurgerDex";
	$siteDesc = "A documented catalog of Burgers from all around. Find a selection of burgers of all kinds,
	even see what burgers had existed but are not extinct. There are many patties out there, and now you
	have a way to know where to go and for what to satisfy your burger desires!";

	getClasses();

	$GLOBALS['active'] = "burgers";
	getHead($siteTitle, $siteDesc);

	$search = "number";

	if (isset($page)) { $page = $page; } else { $page=1; };
	$limit = 10;
	$start_from = ($page-1) * $limit;
	$pgType="burgers";

	$burger = new Posts;
	$burgers = $burger->getBurgers($search,$start_from);

	$burgerList= $burgers[0];
	$burgerCount= $burgers[1];

	$sortSet = $search;
	$numCount = $search;

	include('view/catalogue/burgers.php');
	getFoot();
});
$route->add("/burger", function() {
	$siteTitle = "BurgerDex";
	$siteDesc = "A documented catalog of Burgers from all around. Find a selection of burgers of all kinds,
	even see what burgers had existed but are not extinct. There are many patties out there, and now you
	have a way to know where to go and for what to satisfy your burger desires!";

	getClasses();

	$GLOBALS['active'] = "burgers";
	getHead($siteTitle, $siteDesc);

	$search = "number";

	if (isset($page)) { $page = $page; } else { $page=1; };
	$limit = 10;
	$start_from = ($page-1) * $limit;
	$pgType="burgers";

	$burger = new Posts;
	$burgers = $burger->getBurgers($search,$start_from);

	$burgerList= $burgers[0];
	$burgerCount= $burgers[1];

	$sortSet = $search;
	$numCount = $search;

	include('view/catalogue/burgers.php');
	getFoot();
});
//Burgers
$route->add("/burgers/.+", function($page) {
	$siteTitle = "BurgerDex";
	$siteDesc = "A documented catalog of Burgers from all around. Find a selection of burgers of all kinds,
	even see what burgers had existed but are not extinct. There are many patties out there, and now you
	have a way to know where to go and for what to satisfy your burger desires!";

	getClasses();

	$GLOBALS['active'] = "burgers";
	getHead($siteTitle, $siteDesc);

	$search = "number";
	if (isset($page)) { $page = $page; } else { $page=1; };
	$limit = 10;
	$start_from = ($page-1) * $limit;
	$pgType="burgers";

	$burger = new Posts;
	$burgers = $burger->getBurgers($search,$start_from);

	$burgerList= $burgers[0];
	$burgerCount= $burgers[1];

	$sortSet = $search;
	$numCount = $search;

	include('view/catalogue/burgers.php');
	getFoot();
});
//Burgers By X
$route->add("/burgers-search-by/.+/.+", function($search,$page) {
	$siteTitle = "BurgerDex - ".$search."";
	$siteDesc = "A documented catalog of Burgers from all around. Find a selection of burgers of all kinds,
	even see what burgers had existed but are not extinct. There are many patties out there, and now you
	have a way to know where to go and for what to satisfy your burger desires!";

	getClasses();

	$GLOBALS['active'] = "burgers";
	getHead($siteTitle, $siteDesc);

	if (isset($page)) { $page = $page; } else { $page=1; };
	$limit = 10;
	$start_from = ($page-1) * $limit;
	$pgType="burgers-search-by/".makeSEOURL($search)."";

	$burger = new Posts;
	$burgers = $burger->getBurgers($search,$start_from);

	//var_dump($burgers);

	$burgerList= $burgers[0];
	$burgerCount= $burgers[1];

	$sortSet = $search;
	if($search=="number"||$search=="discovered"||$search=="location"||$search=="kitchen"){
		$numCount = $search;
	}

	include('view/catalogue/burgers.php');
	getFoot();
});

//Burger
$route->add("/burger/.+", function($url) {
	getClasses();

	$burger = new Posts;
	$burger = $burger->getBurger($url, null);

	//var_dump(json_encode($burger));die();

	$siteTitle = "BurgerDex - ".$burger['name']."";
	$siteDesc = "".$burger['description']."";

	$GLOBALS['active'] = "burgers";

	if($burger!=null){
		getHead($siteTitle, $siteDesc);
		include('view/catalogue/burger.php');
		getFoot();
	}else{
		header("Location: http://burgerdex.ca");
	}
});

//About
$route->add("/submit", function() {
	$siteTitle = "BurgerDex - Submit";
	$siteDesc = "A documented catalog of Burgers from all around. Find a selection of burgers of all kinds,
	even see what burgers had existed but are not extinct. There are many patties out there, and now you
	have a way to know where to go and for what to satisfy your burger desires!";

	getClasses();

	$GLOBALS['active'] = "submit";
	getHead($siteTitle, $siteDesc);

	include('view/submit/submit.php');
	getFoot();
});

$route->add("/reset-password", function() {
	$siteTitle = "BurgerDex - Reset Password";
	$siteDesc = "A documented catalog of Burgers from all around. Find a selection of burgers of all kinds,
	even see what burgers had existed but are not extinct. There are many patties out there, and now you
	have a way to know where to go and for what to satisfy your burger desires!";


	getClasses();

	getHead($siteTitle, $siteDesc);

	include('view/user/user.reset.php');
	getFoot();
});
$route->add("/register", function() {
	$siteTitle = "BurgerDex - Register";
	$siteDesc = "A documented catalog of Burgers from all around. Find a selection of burgers of all kinds,
	even see what burgers had existed but are not extinct. There are many patties out there, and now you
	have a way to know where to go and for what to satisfy your burger desires!";


	getClasses();

	getHead($siteTitle, $siteDesc);

	include('view/user/user.register.php');
	getFoot();
});
$route->add("/login", function() {
	$siteTitle = "BurgerDex - Login";
	$siteDesc = "A documented catalog of Burgers from all around. Find a selection of burgers of all kinds,
	even see what burgers had existed but are not extinct. There are many patties out there, and now you
	have a way to know where to go and for what to satisfy your burger desires!";

	include('controller/user/controller.login.php');
	getClasses();

	getHead($siteTitle, $siteDesc);

	include('template/login.php');
	getFoot();
});
$route->add("/account", function() {
	$siteTitle = "BurgerDex - Account";
	$siteDesc = "A documented catalog of Burgers from all around. Find a selection of burgers of all kinds,
	even see what burgers had existed but are not extinct. There are many patties out there, and now you
	have a way to know where to go and for what to satisfy your burger desires!";

	$GLOBALS['active'] = "account";
	getClasses($siteTitle, $siteDesc);

	getHead($siteTitle, $siteDesc);

	include('view/user/user.account.php');
	getFoot();
});
$route->add("/logout", function() {
	$siteTitle = "BurgerDex";
	$siteDesc = "A documented catalog of Burgers from all around. Find a selection of burgers of all kinds,
	even see what burgers had existed but are not extinct. There are many patties out there, and now you
	have a way to know where to go and for what to satisfy your burger desires!";

	getClasses();

	getHead($siteTitle, $siteDesc);

	include('view/user/user.logout.php');
	getFoot();
});

$route->add("/test", function() {
	getClasses();

	getHead();

	include('view/test.php');
	getFoot();
});

$route->add("/email", function() {
	//getClasses();

	//getHead();

	include('template/newBurgerEmail.php');
	//getFoot();
});
/*PAGE VIEWS*/







/*CONTROLS*/
//Add
$route->add("/submit/add/", function() {
	getClasses();

	$addBurger = new Posts;
	$addBurger = $addBurger->addNewBurger($_POST,$_FILES);

	if($addBurger==1){
		header('Location: '.SITEPATH.'/burgers');
	}else{
		$siteTitle = "BurgerDex";
		$siteDesc = "A documented catalog of Burgers from all around. Find a selection of burgers of all kinds,
		even see what burgers had existed but are not extinct. There are many patties out there, and now you
		have a way to know where to go and for what to satisfy your burger desires!";

		$active=$u;
		$GLOBALS['active'] = "submit";
		getHead($siteTitle, $siteDesc);

		include('view/catalogue/submit.php');

		getFoot();
	}
});
/*CONTROLS*/


$route->submit();

function getHead($siteTitle = null, $siteDesc = null){
	define("siteTitle", $siteTitle);
	define("siteDesc", $siteDesc);

	include("template/header.php");
	include('template/navigation.php');

	return;
}
function getClasses(){
	//include('model/class.user.php');
	include('model/class.mrClean.php');
	include('model/class.posts.php');
	return;
}
function getFoot(){
	include("template/footer.php");
	return;
}

function makeSEOURL($toURL){
	//Lower case everything
	$toURL = strtolower($toURL);
	//Make alphanumeric (removes all other characters)
	$toURL = preg_replace("/[^a-z0-9_\s-]/", "", $toURL);
	//Clean up multiple dashes or whitespaces
	$toURL = preg_replace("/[\s-]+/", " ", $toURL);
	//Convert whitespaces and underscore to dash
	$toURL = preg_replace("/[\s_]/", "-", $toURL);
	return $toURL;
}

function undoSEOURL($toName){
	$toName = str_replace('-', ' ', $toName);
	$toName = preg_replace('/(?<!\s)-(?!\s)/', ' ', $toName);
	$toName = ucwords($toName);
	return $toName;
}


?>
