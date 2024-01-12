<?php

//header('Content-Type: application/json');

  getClasses();

	$cleaner = new MrClean();

	$data = $_POST;

	if(isset($data['name'])){$name = $data['name'];}else{$name = null;}
	if(isset($data['kitchen'])){$kitchen = $data['kitchen'];}else{$kitchen = null;}
	if(isset($data['locations'])){$locations = $data['locations'];}else{$locations = null;}
	if(isset($data['rating'])){$rating = $data['rating'];}else{$rating = null;}
	if(isset($data['ingredients'])){$ingredients = $data['ingredients'];}else{$ingredients = null;}
	if(isset($data['descript'])){$description = $data['descript'];}else{$description = null;}
	if(isset($data['veggie'])){$veggie = 'checked';}else{$veggie = '';}
	if(isset($data['spicy'])){$spicy = 'checked';}else{$spicy = '';}
	if(isset($data['extinct'])){$extinct = 'checked';}else{$extinct = '';}
	if(isset($data['seasonal'])){$seasonal = 'checked';}else{$seasonal = '';}
	if(isset($data['hasChallenge'])){$hasChallenge = 'checked';}else{$hasChallenge = '';}
	if(isset($data['price'])){$price = $data['price'];}else{$price = 0.00;}
	if(isset($data['currency'])){$currency = $data['currency'];}else{$currency = '$';}
	if(isset($data['fusion'])){$fusion = 'checked'; $fused1 = $data['fused1']; $fused2 = $data['fused2'];}else{$fusion = '';  $fused1 = ''; $fused2 = '';}
	if(isset($data['fused1'])&&!isset($data['fusion'])){unset($data['fused1']);}else{$fused1 = $data['fused1'];}
	if(isset($data['fused2'])&&!isset($data['fusion'])){unset($data['fused2']);}else{$fused2 = $data['fused2'];}
	if(isset($data['hasMods'])){$hasMods = 'checked';$mods = $data['mods'];}else{$hasMods = '';$mods = '';}
	if(isset($data['mods'])&&!isset($data['hasMods'])){unset($data['mods']);}else{$mods = $data['mods'];}

	if($ingredients!=null){
		$activeIngredients = array();
		$ingreds = explode(', ', $ingredients);
		foreach($ingreds as $ingred){
			$activeIngredients[] = $ingred;
		}
	}else{
		$activeIngredients = array();
	}

	$args= array(
		'name' => $name,
		'kitchen' => $kitchen,
		'locations' => $locations,
		'rating' => $rating,
		'price' => $price,
		'currency' => $currency,
		'ingredients' => $ingredients,
		'description' => $description,
		'veggie' => $veggie,
		'spicy' => $spicy,
		'extinct' => $extinct,
		'seasonal' => $seasonal,
		'hasChallenge' => $hasChallenge,
		'fusion' => $fusion,
		'hasMods' => $hasMods,
		'mods' => $mods
	);

  if(isset($data['iphone'])){
    $addedFrom = 1;
    unset($data['iphone']);
  }elseif(isset($data['android'])){
    $addedFrom = 2;
    unset($data['android']);
  }else{
    $addedFrom = 0;
  }



unset($data['ratingLbl']);

  $rez= array('error'=>'');
		$req = array('name','kitchen','locations','rating','price','ingredients','descript');

    /*
		$cleanReq = $cleaner->isRequired($data, null, 'N/A');

		if($cleanReq['success'] && isset($_FILES)){
			require_once('./model/class.ImageFilter.php');
			$filter = new ImageFilter();

      if($addedFrom=="android"){
        $score = $filter->GetScore($_FILES['image']['tmp_name']);
      }else{
			  $score = $filter->GetScore($_FILES['user_image']['tmp_name']);
      }
		}

    $result= array('code'=>1,'message'=>"There were some required fields missed.");
		if(isset($score)){
			if($score >= 50){
				 $err="That image is totally not a Burger!...";
				 $form = getForm($args, $exists = null, $activeIngredients);
			}else{*/

				$cleanReq = $cleaner->isRequired($data, $req, 'N/A');
        $t = $cleanReq;
				$cleanPost = $cleanReq['data'];

				if($cleanReq['success'] && isset($_FILES)){

					$addBurger = new Posts();
					$addBurg = $addBurger->addNewBurger($cleanPost,$_FILES,$addedFrom);

          $result= array('code'=>0,'message'=>"Burger was successfully added.");

          //IF already added
					if($addBurg==false){
            $result= array('code'=>2,'message'=>"This burger has been documented already.");
					}

				}else{
          //IF info is missing
					$result= array('code'=>100,'message'=>"There were some required fields missed.");
				}

			//}

		/*}else{
      //If score sucked
			$result= array('code'=>1,'message'=>"There were some issue with your image.");
		}*/

    //WTF fix
    if($addBurg){
      $result= array('code'=>0,'message'=>"Burger was successfully added.");
    }

	$rez['error']=array($result);
	$ee = json_encode($rez);

  echo $ee;
	exit;

function getClasses(){
	include('model/class.mrClean.php');
	include('model/class.posts.php');
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
