<?php

$cleaner = new MrClean();

$data = $_POST;

if(count($data)>0){
	if(isset($data['name'])){$name = $data['name'];}else{$name = null;}
	if(isset($data['kitchen'])){$kitchen = $data['kitchen'];}else{$kitchen = null;}
	if(isset($data['locations'])){$locations = $data['locations'];}else{$locations = null;}
	if(isset($data['rating'])){$rating = $data['rating'];}else{$rating = null;}
	if(isset($data['ingredients'])){$ingredients = $data['ingredients'];}else{$ingredients = null;}
	if(isset($data['description'])){$description = $data['description'];}else{$description = null;}
	if(isset($data['veggie'])){$veggie = 'checked';}else{$veggie = '';}
	if(isset($data['spicy'])){$spicy = 'checked';}else{$spicy = '';}
	if(isset($data['extinct'])){$extinct = 'checked';}else{$extinct = '';}
	if(isset($data['seasonal'])){$seasonal = 'checked';}else{$seasonal = '';}
	if(isset($data['hasChallenge'])){$hasChallenge = 'checked';}else{$hasChallenge = '';}
	if(isset($data['price'])){$price = $data['price'];}else{$price = 0.00;}
	if(isset($data['currency'])){$currency = $data['currency'];}else{$currency = 'CAD $';}
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
	$addedFrom = "desktop";
}else{
	$args= array(
		'name' => "",
		'kitchen' => "",
		'locations' => "",
		'rating' => "",
		'price' => "",
		'currency' => "",
		'ingredients' => "",
		'description' => "",
		'veggie' => "",
		'spicy' => "",
		'extinct' => "",
		'seasonal' => "",
		'hasChallenge' => "",
		'fusion' => "",
		'hasMods' => "",
		'mods' => ""
	);
	$activeIngredients = array();
}

$err='';

if(isset($_POST['name'])){

	$req = array('name','kitchen','locations','rating','price','ingredients','description');

	/*$cleanReq = $cleaner->isRequired($data, $req, 'N/A');

	if($cleanReq['success'] && isset($_FILES)){
		require_once('./model/class.ImageFilter.php');
		$filter = new ImageFilter();
		$score = $filter->GetScore($_FILES['user_image']['tmp_name']);
	}

	if(isset($score))
	{
		if($score >= 50)
		{
			 $err="That image is totally not a Burger!...";
			 $form = getForm($args, $exists = null, $activeIngredients);
		}else{*/

			$req = array('name','kitchen','locations','rating','price','ingredients','description');

			$cleanReq = $cleaner->isRequired($data, $req, 'N/A');
			$cleanPost = $cleanReq['data'];

			if($cleanReq['success'] && isset($_FILES)){
				$addBurger = new Posts();
				$addBurger = $addBurger->addNewBurger($cleanPost,$_FILES,$addedFrom);

				if($addBurger==true){
				?>
					<script>window.location.replace("<?php echo SITEPATH; ?>/burgers");</script>
				<?php
				//$err='submitted';
				//$form = getForm($args, $exists = null, $activeIngredients);
				}else{
					$err='This burger has been documented already.';

					$kitchenTitle = $cleaner->makeSEOURL($kitchen);
					$burgerTitle = $cleaner->makeSEOURL($name);
					$url = $kitchenTitle . "-". $burgerTitle;

					$exists = array(
						'name'=>$data['name'],
						'kitchen'=>$data['kitchen'],
						'url'=>$url
					);
					$form = getForm($args, $exists, $activeIngredients);
				}
			}else{
				$err='There were some required fields missed.';
				$form = getForm($args, $exists = null, $activeIngredients);
			}
		/*}
	}else{
		$err='There were some required fields missed.';
		$form = getForm($args, $exists = null, $activeIngredients);
	}*/
}else{
	$err='';
	$form = getForm($args, $exists = null, $activeIngredients);
}


function getForm($args, $exists = null, $activeIngredients){

$currencies = array('CAD &#36;','USD &#36;','&#163;','&#8364;','&#165;','&#8377;','&#8355;','&#8369;','&#8381;');

	$burgerCall = new Posts();
	$burgerlist = $burgerCall->getBurgers();

	$ingredientlist = $burgerCall->getIngredients();

	$name = $args['name'];
	$kitchen = $args['kitchen'];
	$locations = $args['locations'];
	$rating = $args['rating'];
	$price = $args['price'];
	$currency = $args['currency'];
	$ingredients = $args['ingredients'];
	$description = $args['description'];
	$veggie = $args['veggie'];
	$spicy = $args['spicy'];
	$extinct = $args['extinct'];
	$seasonal = $args['seasonal'];
	$hasChallenge = $args['hasChallenge'];
	$fusion = $args['fusion'];
	$hasMods = $args['hasMods'];
	$mods = $args['mods'];

	$form = "";

		if($exists!=null){
			foreach($burgerlist as $burger){
				if($burger['url']==$exists['url']){
					$form.= "<div class='burgerlist'>
						<ul class='burgerset'>";

					$numCount = "number";
					$showFuse = "show";
					ob_start();
					include("template/burgerTab.php");
					$form .= ob_get_contents();
					ob_end_clean();

					$form.= "</ul>
					</div>";

					$name = "";
					$kitchen = "";
					$locations = "";
					$rating = "";
					$price = "";
					$currency = "";
					$ingredients = "";
					$description = "";
					$veggie = "";
					$spicy = "";
					$extinct = "";
					$seasonal = "";
					$hasChallenge = "";
					$fusion = "";
					$hasMods = "";
					$mods = "";
				}
			}
		}

	$form .= "
	<div>
			<label for='name'>*Name:</label>
			<input type='text' name='name' value='".$name."' placeholder='Whopper' /><br />
		</div>
		<div>
			<label for='kitchen'>*Kitchen:</label>
			<input type='text' name='kitchen' value='".$kitchen."' placeholder='Burger King' /><br />
		</div>
		<div>
			<label for='locations'>*Region:</label>
			<input type='text' name='locations' value='".$locations."' placeholder='(Worldwide, Americas, Ontario, Toronto)' /><br />
		</div>
		<div>
			<label for='image'>*Image:</label>
			<input type='file' name='user_image' accept='image/*' /><br />
		</div>
		<div>
			<label for='rating'>*Rating:</label>
			<input name='rating' type='number' step='0.1' value='".$rating."' min='0.0' max='10.0' placeholder='10.0' /><br />
		</div>
		<div>
			<label for='price'>*Price:</label>
			<input style='float: right;width: 50%;clear: right;display: inline-block;position: relative;' name='price' type='number' step='0.01' min='0.00' max='1000.00' placeholder='5.00' />
			<select name='currency' style='margin: 10px;float: right;display: inline-block;position: relative;'>";
				for($c=0; $c<count($currencies); $c++){
					$form .= "<option>".$currencies[$c]."</option>";
				}
			$form .="
			</select>
		</div>
		<div style='height: auto;display: inline-block;position: relative;'>
			<label for='ingredients'>*Ingredients:</label>
			<input type='hidden' id='ingredients' name='ingredients' value='".$ingredients."' />
			<div class='ingredientList'><div id='ingredientList'>
			";

			foreach($ingredientlist as $ingrendient){
				if(in_array($ingrendient, $activeIngredients)){
					$form .= "<div class='ingred active'>".$ingrendient."</div>";
				}else{
					$form .= "<div class='ingred'>".$ingrendient."</div>";
				}
			}

			$form .="
			</div>
				<div class='clear'></div>
				<br />
				<div class='ingredientList' style='width:100%;'>
					<div class='ingredADD' id='showAddIngredient'>+</div>
					<div class='ingredADD' id='addIngredient'> ADD </div>
					<input type='hidden' id='ingredientToAdd' value='' />
				</div>
			</div>
			<div class='clear'></div>
		</div>
		<div>
			<br />
			<label for='description'>*Description:</label>
			<textarea name='description'>".$description."</textarea><br />
			<br />
		</div>
		<br /><hr /><br />
		<div style='column-count:2;'>
			<div>
				<input type='checkbox' name='veggie' ".$veggie." />
				<label for='veggie'><div class='badge burgerVeggie'><img src='".SITE_PATH_STATIC."/assets/img/veggie.svg' width='20' /></div> Vegetarian</label><br />
			</div>
			<div>
				<input type='checkbox' name='spicy' ".$spicy." />
				<label for='spicy'><div class='badge burgerSpicy'><img src='".SITE_PATH_STATIC."/assets/img/spicy.svg' width='20' /></div> Spicy</label><br />
			</div>
			<div>
				<input type='checkbox' name='extinct' ".$extinct." />
				<label for='extinct'><div class='badge burgerAvailable'><img src='".SITE_PATH_STATIC."/assets/img/available.svg' width='20' /></div> Extinct</label><br />
			</div>
			<div>
			<input type='checkbox' id='fusion' name='fusion' ".$fusion." />
			<label for='fusion'><div class='badge burgerSeasonal'><img src='".SITE_PATH_STATIC."/assets/img/fusion.svg' width='20' /></div> Fusion:</label><br />

			<div id='fusedinput'>
				<select name='fused1'>";
					$form .= "<option value='0'>Undiscovered</option>";
					foreach($burgerlist as $burger){
						$form .= "<option value='".$burger['id']."'>".$burger['kitchen'].": ".$burger['name']."</option>";
					}
				$form .= "
				</select>

				<select name='fused2'>";
					$form .= "<option value='0'>Undiscovered</option>";
					foreach($burgerlist as $burger){
						$form .= "<option value='".$burger['id']."'>".$burger['kitchen'].": ".$burger['name']."</option>";
					}
				$form .= "
				</select>
			</div>
		</div>
		<div>
			<input type='checkbox' id='hasMods' name='hasMods' ".$hasMods." />
			<label for='hasMods'><div class='badge burgerChallenge'><img src='".SITE_PATH_STATIC."/assets/img/hasMods.svg' width='20' /></div> Modified?:</label><br />

			<div id='modinput'>
				<label for='mods'>Mods:</label>
				<input type='text' name='mods' value='".$mods."' /><br />
			</div>
		</div>
			<div>
				<br />
			</div>
		</div>
		<div>
			<div>
				<input type='checkbox' name='seasonal' ".$seasonal." />
				<label for='seasonal'><div class='badge burgerSeasonal'><img src='".SITE_PATH_STATIC."/assets/img/seasonal.svg' width='20' /></div> Seasonal</label><br />
			</div>
			<div>
				<input type='checkbox' name='hasChallenge' ".$hasChallenge." />
				<label for='hasChallenge'><div class='badge burgerChallenge'><img src='".SITE_PATH_STATIC."/assets/img/hasChallenge.svg' width='20' /></div> Food Challenge?</label><br />
			</div>
		</div>

		<br />
		<button type='submit'>Submit</button>";

		return $form;
}

?>
