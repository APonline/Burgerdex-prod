<?php

class Posts
{
	public $conn;

	public function __construct(){
		require_once("class.database.php");
		$db = new DatabaseConnection;
		$this->conn = $db->ConnectDB();
	}


	public function seoUrl($string){
		//Lower case everything
		$string = strtolower($string);
		//Make alphanumeric (removes all other characters)
		$string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
		//Clean up multiple dashes or whitespaces
		$string = preg_replace("/[\s-]+/", " ", $string);
		//Convert whitespaces and underscore to dash
		$string = preg_replace("/[\s_]/", "-", $string);
		return $string;
	}

	public function getBurgers($search = null, $start_from = null, $page = null){
  		try{
  			$limit = 50;
  			$originSearch = $search;

			//ADMIN GET ALL CATEGORY
			if($search==null){
				$queryInfo = "SELECT * FROM burgers ORDER BY id ASC";
				$burger = $this->conn->prepare($queryInfo);
				$burger->bindParam(":url", $url, PDO::PARAM_STR);
			}else{
				$displayTags = $search;
				switch($search){
					case 'home':
						$search="WHERE active = '1'";
						$select="*";
					break;
					case 'featured':
						$search="WHERE featured ='1' || rating > 9.0 && active = 1 ORDER BY date_captured DESC, rating DESC, featuredOrder ASC";
						$select="*";
						$limiter="WHERE featured ='1' || rating > 9.0 && active = 1 ORDER BY date_captured DESC, rating DESC, featuredOrder ASC";
						$start_from=0;
						$limit=5;
					break;
					case 'number':
						$search="WHERE active = '1' ORDER BY id DESC";
						$select="*";
						$limiter="WHERE active = '1' ORDER BY id DESC";
					break;
					case 'discovered':
						$search="WHERE active = '1' ORDER BY date_captured DESC";
						$select="*";
						$limiter="WHERE active = '1' ORDER BY date_captured DESC";
					break;
					case 'rating':
						$search="WHERE active = '1' ORDER BY rating DESC";
						$select="*";
						$limiter="WHERE active = '1' ORDER BY rating DESC";
					break;
					case 'vegetarian':
						$search="WHERE veggie ='1' && active = '1' ORDER BY veggie ASC";
						$select="*";
						$limiter="WHERE veggie ='1' && active = '1' ORDER BY veggie ASC";
					break;
					case 'spicy':
						$search="WHERE spicy ='1' && active = '1' ORDER BY spicy ASC";
						$select="*";
						$limiter="WHERE spicy ='1' && active = '1' ORDER BY spicy ASC";
					break;
					case 'seasonal':
						$search="WHERE seasonal ='1' && active = '1' ORDER BY seasonal ASC";
						$select="*";
						$limiter="WHERE seasonal ='1' && active = '1' ORDER BY seasonal ASC";
					break;
					case 'extinct':
						$search="WHERE extinct ='1' && active = '1' ORDER BY extinct ASC";
						$select="*";
						$limiter="WHERE extinct ='1' && active = '1' ORDER BY extinct ASC";
					break;
					case 'challenge':
						$search="WHERE hasChallenge ='1' && active = '1' ORDER BY hasChallenge ASC";
						$select="*";
						$limiter="WHERE hasChallenge ='1' && active = '1' ORDER BY hasChallenge ASC";
					break;
					case 'price-hi':
						$search="WHERE active = '1' ORDER BY price DESC";
						$select="*";
						$limiter="WHERE active = '1' ORDER BY price DESC";
					break;
					case 'price-low':
						$search="WHERE active = '1' ORDER BY price ASC";
						$select="*";
						$limiter="WHERE active = '1' ORDER BY price ASC";
					break;
					case 'fusion':
						$search="WHERE fusion ='1' && active = '1' ORDER BY fusion ASC";
						$select="*";
						$limiter="WHERE fusion ='1' && active = '1' ORDER BY fusion ASC";
					break;
					case 'modded':
						$search="WHERE hasMods ='1' && active = '1' ORDER BY hasMods ASC";
						$select="*";
						$limiter="WHERE hasMods ='1' && active = '1' ORDER BY hasMods ASC";
					break;
					case 'location':
						$search="WHERE active = '1' GROUP BY SUBSTRING(locations, 0, 2), burgerId ORDER BY 'locationTitle', locations ASC";
						$select="*, locations as locationTitle";
						$limiter=null;
					break;
					case 'kitchen':
						$search="WHERE active = '1' GROUP BY SUBSTRING(kitchen, 0, 2), id ORDER BY 'kitchenTitle', kitchen ASC";
						$select="*, kitchen as kitchenTitle";
						$limiter=null;
					break;
					default:
						$search=null;
						$select="*";
						$limiter=null;
					break;
				}

				$queryInfo = "SELECT $select FROM burgers $search LIMIT $start_from, $limit";
				$burger = $this->conn->prepare($queryInfo);
			}
			$burger->setFetchMode(PDO::FETCH_ASSOC);
			$burger->execute();
			$burger = $burger->fetchAll();

			if(empty($burger)){
				return;
			}

			$burgerList= array();

				$queryInfo = "SELECT COUNT(id) as 'count' FROM burgers $limiter";
				$burgerC = $this->conn->prepare($queryInfo);
				$burgerC->setFetchMode(PDO::FETCH_ASSOC);
				$burgerC->execute();
				$burgerC = $burgerC->fetchAll();
				$burgerCount=$burgerC[0]['count'];

			//Page interval to get count #
			if(!isset($page)){
				$x=1;
			}else{
				if((int)$page>1){
					$fk=(int)$page - 1;
					$fk=($fk * $limit) + 1;
					$x=(int)$fk;
				}else{
					$x=1;
				}
			}

			$burgerPages = $burgerCount / $limit;
			if(strpos( $burgerPages, "." ) !== false){
				$burgerPages = floor($burgerPages);
				$burgerPages = $burgerPages + 1;
			}

			if($originSearch=="location"||$originSearch=="kitchen"){
				$K="kitchenTitle";
				$L="locationTitle";
			}else{
				$K="kitchen";
				$L="locations";
			}

			//$x=1;
			for($i=0; $i<count($burger); $i++){

				switch($displayTags){
					case 'home':
						$dispTag="No.";
						$dispText=(string)$burger[$i]['id'];
					break;
					case 'featured':
						$dispTag="#";
						$dispText=(string)$x;
					break;
					case 'number':
						$dispTag="No.";
						$dispText=(string)$burger[$i]['id'];
					break;
					case 'discovered':
						$dispTag=date("M",strtotime($burger[$i]['date_captured']));
						$dispText= date("j",strtotime($burger[$i]['date_captured']));
					break;
					case 'rating':
						$dispTag="#";
						$dispText=(string)$x;
					break;
					case 'vegetarian':
						$dispTag="#";
						$dispText=(string)$x;
					break;
					case 'spicy':
						$dispTag="#";
						$dispText=(string)$x;
					break;
					case 'seasonal':
						$dispTag="#";
						$dispText=(string)$x;
					break;
					case 'extinct':
						$dispTag="#";
						$dispText=(string)$x;
					break;
					case 'challenge':
						$dispTag="#";
						$dispText=(string)$x;
					break;
					case 'price-hi':
						$dispTag="#";
						$dispText=(string)$x;
					break;
					case 'price-low':
						$dispTag="#";
						$dispText=(string)$x;
					break;
					case 'fusion':
						$dispTag="#";
						$dispText=(string)$x;
					break;
					case 'modded':
						$dispTag="#";
						$dispText=(string)$x;
					break;
					case 'location':
						$dispTag="#";
						$dispText=(string)$x;
					break;
					case 'kitchen':
						$dispTag="#";
						$dispText=(string)$x;
					break;
					default:
						$dispTag="oops";
						$dispText=(string)"yo this man";
					break;
				}
				$x++;

				$burgerInfo = array(
					'displayTag' => $dispTag,
					'displayText' => $dispText,
					'id' => (int)$burger[$i]['id'],
					'name' => $burger[$i]['name'],
					'kitchenTitle' => $burger[$i][$K],
					'kitchen' => $burger[$i]['kitchen'],
					'locationTitle' => $burger[$i][$L],
					'locations' => $burger[$i]['locations'],
					'image' => $burger[$i]['image'],
					'rating' => $burger[$i]['rating'],
					'price' => $burger[$i]['currency'].$burger[$i]['price'],
					'year' => date("Y",strtotime($burger[$i]['date_captured'])),
					'dateCaptured' => $burger[$i]['date_captured']
				);

				$burgerList[] = $burgerInfo;
			}

			if($search!=null){

				$burgers = array($burgerList,$burgerCount,$burgerPages);
				return $burgers;
			}else{
				return $burgerList;
			}

		}catch(PDOException $e){
			echo $e->getMessage();
		}
  	}
  	public function getBurger($url = null, $id = null){
  		try{
			if($id==null&&$url!=null){
				$queryInfo = "SELECT * FROM burgers WHERE url = :url && active = 1";
				$burger = $this->conn->prepare($queryInfo);
				$burger->setFetchMode(PDO::FETCH_ASSOC);
				$burger->bindParam(":url", $url, PDO::PARAM_STR);
			}else{
				$queryInfo = "SELECT * FROM burgers WHERE id = :id && active = 1 ORDER BY id ASC";
				$burger = $this->conn->prepare($queryInfo);
				$burger->setFetchMode(PDO::FETCH_ASSOC);
				$burger->bindParam(":id", $id, PDO::PARAM_INT);
			}
			$burger->execute();
			$burger = $burger->fetchAll();

			if(empty($burger)&&$id!=0){
				return;
			}elseif(empty($burger)&&isset($id)&&$id==0||isset($url)&&$url=="mystery-mystery"){
				$i=0;
				$burgerInfo = array(
					'id' => '?',
					'displayTag' => "No.",
					'displayText' => "?",
					'index' => '',
					'name' => '???',
					'url' => 'mystery-mystery',
					'kitchen' => '???',
					'locations' => '???',
					'image' => "uploads/0/mystery.jpg",
					'rating' => '?',
					'price' => '$??.??',
					'fusion' => 0,
					'ingredients' => "???, ???, ???, ???",
					'description' => "This burger is a mystery and has yet to be discovered. The Burger is out there...",
					'veggie' => 0,
					'spicy' => 0,
					'extinct' => 0,
					'seasonal' => 0,
					'hasChallenge' => 0,
					'hasMods' => 0,
					'dated' => "0000-00-00 00:00:00",
					'fused'=> null,
					'modded'=> null
				);
			}else{
				$i=0;
				$burgerInfo = array(
					'id' => (int)$burger[$i]['id'],
					'displayTag' => "No.",
					'displayText' => $burger[$i]['id'],
					'index' => $this->getBurgerPos($burger[$i]['id']),
					'name' => $burger[$i]['name'],
					'url' => $burger[$i]['url'],
					'kitchen' => $burger[$i]['kitchen'],
					'locations' => $burger[$i]['locations'],
					'image' => $burger[$i]['image'],
					'rating' => $burger[$i]['rating'],
					'price' => $burger[$i]['currency'].$burger[$i]['price'],
					'fusion' => (int)$burger[$i]['fusion'],
					'ingredients' => $burger[$i]['ingredients'],
					'description' => $burger[$i]['description'],
					'veggie' => (int)$burger[$i]['veggie'],
					'spicy' => (int)$burger[$i]['spicy'],
					'extinct' => (int)$burger[$i]['extinct'],
					'seasonal' => (int)$burger[$i]['seasonal'],
					'hasChallenge' => (int)$burger[$i]['hasChallenge'],
					'hasMods' => (int)$burger[$i]['hasMods'],
					'dated' => $burger[$i]['date_captured'],
					'fused'=> $this->getBurgerFusions($burger[$i]['id']),
					'modded'=> $this->getBurgerMods($burger[$i]['id'])
				);
			}

			$burgerInfoList[] = $burgerInfo;
			return $burgerInfoList;

		}catch(PDOException $e){
			echo $e->getMessage();
		}
  	}
  	public function getBurgerSummary($url = null, $id = null){
  		try{
			if($id==null&&$url!=null){
				$queryInfo = "SELECT * FROM burgers WHERE url = :url && active = 1";
				$burger = $this->conn->prepare($queryInfo);
				$burger->setFetchMode(PDO::FETCH_ASSOC);
				$burger->bindParam(":url", $url, PDO::PARAM_STR);
			}else{
				$queryInfo = "SELECT * FROM burgers WHERE id = :id && active = 1 ORDER BY id ASC";
				$burger = $this->conn->prepare($queryInfo);
				$burger->setFetchMode(PDO::FETCH_ASSOC);
				$burger->bindParam(":id", $id, PDO::PARAM_INT);
			}
			$burger->execute();
			$burger = $burger->fetchAll();

			if(empty($burger)&&$id!=0){
				return;
			}elseif(empty($burger)&&isset($id)&&$id==0||isset($url)&&$url=="mystery-mystery"){
				$i=0;
				$burgerInfo = array(
					'id' => '?',
					'displayTag' => "No.",
					'displayText' => "?",
					'name' => '???',
					'kitchen' => '???',
					'locations' => '???',
					'image' => "uploads/0/mystery.jpg",
					'rating' => '?',
					'price' => '$??.??',
					'dated' => "0000-00-00 00:00:00"
				);
			}else{
				$i=0;
				$burgerInfo = array(
					'id' => (int)$burger[$i]['id'],
					'displayTag' => "No.",
					'displayText' => $burger[$i]['id'],
					'name' => $burger[$i]['name'],
					'url' => $burger[$i]['url'],
					'kitchen' => $burger[$i]['kitchen'],
					'locations' => $burger[$i]['locations'],
					'image' => $burger[$i]['image'],
					'rating' => $burger[$i]['rating'],
					'price' => $burger[$i]['currency'].$burger[$i]['price'],
					'year' => date("Y",strtotime($burger[$i]['date_captured'])),
					'dated' => $burger[$i]['date_captured']
				);
			}

			return $burgerInfo;

		}catch(PDOException $e){
			echo $e->getMessage();
		}
  	}
  	public function getBurgerFusions($mainBurger){
  		try{
			$queryInfo = "SELECT * FROM burgerFusions WHERE fusedBurgerId = :mainBurger";
			$fusions = $this->conn->prepare($queryInfo);
			$fusions->setFetchMode(PDO::FETCH_ASSOC);
			$fusions->bindParam(":mainBurger", $mainBurger, PDO::PARAM_INT);
			$fusions->execute();
			$fusions = $fusions->fetchAll();

			if(empty($fusions)){
				return $fusionBurgers = array();
			}

			$fusionBurgers = array();

			foreach($fusions as $fusion){
				(int)$id=$fusion['burgerId'];
				$burger = $this->getBurgerSummary(null, $id);

				$fusionBurgers[] = $burger;
			}

			$fusionMixers=$fusionBurgers;
			return $fusionMixers;

		}catch(PDOException $e){
			echo $e->getMessage();
		}
  	}
		public function getBurgerMods($mainBurger){
  		try{

			$queryInfo = "SELECT * FROM burgerMods WHERE modBurgerId = :mainBurger";
			$mods = $this->conn->prepare($queryInfo);
			$mods->setFetchMode(PDO::FETCH_ASSOC);
			$mods->bindParam(":mainBurger", $mainBurger, PDO::PARAM_INT);
			$mods->execute();
			$mods = $mods->fetchAll();

			if(empty($mods)){
				return;
			}

			$modMixers = array(
				'modId'=>$mods[0]['modBurgerId'],
				'modCount'=>count($mods),
				'mods'=>''
			);
			$modBurgers = array();

			foreach($mods as $mod){
				$extra = array(
					'mod'=>$mod['modded'],
					'date_modded'=>$mod['date_modded']
				);

				$modBurgers[] = $extra;
			}

			$modMixers['mods'] = $modBurgers;
			return $modMixers;

		}catch(PDOException $e){
			echo $e->getMessage();
		}
  	}
  	public function getBurgerPos($mainBurger){
  		try{

				$queryInfo = "SELECT * FROM burgers WHERE id = :mainBurger
				union all
					(SELECT * FROM burgers WHERE id < :mainBurger && active = 1 ORDER BY id DESC limit 1)
				union all
					(SELECT * FROM burgers WHERE id > :mainBurger && active = 1 ORDER BY id ASC limit 1) ";

				$pos = $this->conn->prepare($queryInfo);
				$pos->setFetchMode(PDO::FETCH_ASSOC);
				$pos->bindParam(":mainBurger", $mainBurger, PDO::PARAM_INT);
				$pos->execute();
				$pos = $pos->fetchAll();

				if(empty($pos)){
					return;
				}
				$posBurgers = array(
					'prev'=>'',
					'next'=>''
				);

				$directionCount=0;
				foreach($pos as $p){
					if($directionCount>0){
						$extra = array(
							'id'=>$p['id']
						);

						if($directionCount>1){
							$posBurgers['next'] = $extra;
						}else{
							if(count($pos)==3){
								$posBurgers['prev'] = $extra;
							}elseif((int)$mainBurger==1){
								$dud = array(
									'id'=>''
								);
								$posBurgers['prev'] = $dud;
								$posBurgers['next'] = $extra;
							}else{
								$dud = array(
									'id'=>''
								);
								$posBurgers['prev'] = $extra;
								$posBurgers['next'] = $dud;
							}
						}
					}
					$directionCount++;
				}

				$posBurger[] = $posBurgers;
				return $posBurger;

			}catch(PDOException $e){
				echo $e->getMessage();
			}
  	}
  	public function getIngredients(){
  		try{

				$queryInfo = "SELECT * FROM burgerIngredients ORDER BY ordering DESC, value ASC";

				$ingredients = $this->conn->prepare($queryInfo);
				$ingredients->setFetchMode(PDO::FETCH_ASSOC);
				$ingredients->execute();
				$ingredients = $ingredients->fetchAll();

				if(empty($ingredients)){
					return;
				}
				$ingredientList = array();

				foreach($ingredients as $i=> $ingred){
					$ingredientList[] = $ingred['value'];
				}

				return $ingredientList;

			}catch(PDOException $e){
				echo $e->getMessage();
			}
  	}
  	public function updateIngredientCount($ingredient){
  		try{

				$queryInfo = "UPDATE burgerIngredients SET ordering = (ordering + 1) WHERE value = :value";

				$ingred = $this->conn->prepare($queryInfo);
				$ingred->bindParam(":value", $ingredient, PDO::PARAM_STR);
				$ingred->execute();

				if(empty($ingred)){
					return;
				}

				return;

			}catch(PDOException $e){
				return;
			}
  	}

  	public function checkBurger($name, $kitchen, $url){
  		try{
				$queryInfo = "SELECT * FROM burgers WHERE url LIKE CONCAT(:url, '%') ORDER BY id ASC LIMIT 1";
				$burger = $this->conn->prepare($queryInfo);
				$burger->setFetchMode(PDO::FETCH_ASSOC);
				//$burger->bindParam(":name", $name, PDO::PARAM_STR);
				//$burger->bindParam(":kitchen", $kitchen, PDO::PARAM_STR);
				$burger->bindParam(":url", $url, PDO::PARAM_STR);
				$burger->execute();
				$burger = $burger->fetchAll();

				if(empty($burger)){
					return "new";
				}else{
					return $burger[0]['burgerId'];
				}
			}catch(PDOException $e){
				echo $e->getMessage();
			}
  	}
	public function addNewBurger($data, $_FILE, $addedFrom){

			if(isset($data['name'])){$name = $data['name'];}else{$name = null;}
			if(isset($data['kitchen'])){$kitchen = $data['kitchen'];}else{$kitchen = null;}
			if(isset($data['locations'])){$locations = $data['locations'];}else{$locations = null;}
			if(isset($data['rating'])){$rating = $data['rating'];}else{$rating = null;}
			if(isset($data['ingredients'])){$ingredients = $data['ingredients'];}else{$ingredients = null;}
			$ingredients = rtrim($ingredients, ', ');

			$ingred = $ingredients;

			$addingIngreds = array();
			$ingred = explode(", ", $ingred);
			foreach($ingred as $i=> $ing){
				if($i==0){
					$addingIngreds[] = " ".$ing;
				}else{
					$addingIngreds[] = $ing;
				}
			}

			foreach($addingIngreds as $ingredToAdd){
				$addIngred = $this->updateIngredientCount($ingredToAdd);
			}

			if(isset($data['descript'])){$description = $data['descript'];}else{$description = null;}
			if(isset($data['veggie'])&&$data['veggie']=="1 "){$veggie = 1;}else{$veggie = 0;}
			if(isset($data['spicy'])&&$data['spicy']=="1 "){$spicy = 1;}else{$spicy = 0;}
			if(isset($data['extinct'])&&$data['extinct']=="1 "){$extinct = 1;}else{$extinct = 0;}
			if(isset($data['seasonal'])&&$data['seasonal']=="1 "){$seasonal = 1;}else{$seasonal = 0;}
			if(isset($data['hasChallenge'])&&$data['hasChallenge']=="1 "){$hasChallenge = 1;}else{$hasChallenge = 0;}
			if(isset($data['currency'])){$currency = $data['currency'];}else{$currency = 'CAD $';}
			if(isset($data['price'])){$price = $data['price'];}else{$price = 0.00;}
			if(isset($data['fusion'])&&$data['fusion']=="1 "){$fusion = 1;}else{$fusion = 0;}
			if(isset($data['fused1'])){$fused1 = $data['fused1'];}else{$fused1 = '';}
			if(isset($data['fused2'])){$fused2 = $data['fused2'];}else{$fused2 = '';}
			if(isset($data['hasMods'])&&$data['hasMods']=="1 "){$hasMods = 1;}else{$hasMods = 0;}
			if(isset($data['mods'])){$mods = $data['mods'];}else{$mods = '';}

			if(isset($data['deviceName'])){$dName = $data['deviceName'];}else{$dName = "";}
			if(isset($data['deviceType'])){$dType = $data['deviceType'];}else{$dType = "";}

			$kitchenTitle = $this->seoUrl($kitchen);
			$burgerTitle = $this->seoUrl($name);
			$url = $kitchenTitle . $burgerTitle;
			$url = rtrim($url, '-');
			$checkBurg = $this->checkBurger($name, $kitchen, $url);

				if($addedFrom==2){
					$imgFile = $_FILE['image']['name'];
					$tmp_dir = $_FILE['image']['tmp_name'];
					$imgSize = $_FILE['image']['size'];
					$imgType = $_FILE['image']['type'];
				}else{
					$imgFile = $_FILE['user_image']['name'];
					$tmp_dir = $_FILE['user_image']['tmp_name'];
					$imgSize = $_FILE['user_image']['size'];
					$imgType = $_FILE['user_image']['type'];
				}


				$upload_dir = "../uploads/0/";
				$thumb_upload_dir = "../uploads/0/thumbs/"; // upload directory
				$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
				$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
				$userpic = rand(1000,1000000).".jpg";

					if($imgSize < 5000000){


						$this->makeThumbnail($tmp_dir,1400, 1400, $upload_dir.$userpic, $imgType,"image",$userpic);
						$this->makeThumbnail($tmp_dir,350, 350, $thumb_upload_dir.$userpic, $imgType,"thumb",$userpic);


					}else{
						$errMSG = "Pardon, but your file is too large.";
					}

				//fix phone meta for rotated image
				$this->image_fix_orientation($upload_dir.$userpic);

				$mrT = trim($data['timezone']);
				try{
					if(isset($data['timezone'])){
						date_default_timezone_set("".$mrT."");
					}else{
						date_default_timezone_set("America/Toronto");
					}
					$startDate = date("Y-m-d h:i:s");

					if($checkBurg=="new"){
						$burgerId = 0;
						$extraEntry = 0;
					}else{
						$burgerId = $checkBurg;
						$extraEntry = 1;
					}

$queryInfo = "INSERT INTO burgers(burgerId, name, url, kitchen, locations, image, rating, currency, price, fusion, ingredients, description, veggie, spicy, extinct, seasonal, hasChallenge, hasMods, date_captured, added_from, device_name, device_type, extra_entry)VALUES(:burgerId, :name, :url, :kitchen, :locations, :image, :rating, :currency, :price, :fusion, :ingredients, :description, :veggie, :spicy, :extinct, :seasonal, :hasChallenge, :hasMods, :date_captured, :added_from, :device_name, :device_type, :extra_entry)";
					$statement = $this->conn->prepare($queryInfo);

					$statement->execute(array(
						"burgerId" => $burgerId,
						"name" => trim($name),
						"url" => $url,
						"kitchen" => trim($kitchen),
						"locations" => trim($locations),
						"image" => "uploads/0/".$userpic,
						"rating" => $rating,
						"currency" => $currency,
						"price" => $price,
						"fusion" => $fusion,
						"ingredients" => $ingredients,
						"description" => $description,
						"veggie" => $veggie,
						"spicy" => $spicy,
						"extinct" => $extinct,
						"seasonal" => $seasonal,
						"hasChallenge" => $hasChallenge,
						"hasMods" => $hasMods,
						"date_captured" => $startDate,
						"added_from" => $addedFrom,
						"device_name" => $dName,
						"device_type" => $dType,
						"extra_entry" => $extraEntry
					));

					$lastID = $this->conn->lastInsertId();

					if($hasMods==1){
						$modAdded = $this->addMod($lastID,$mods);
					}

					if($fusion==1){
						$fused = array();
							$fused[] = $fused1;
							$fused[] = $fused2;
						$fusionAdded = $this->addFusion($lastID, $fused);
					}

					$args = array(
						'kitchen' => trim($kitchen),
						"locations" => trim($locations),
						"ingredients" => $ingredients,
						"description" => trim($description)
					);

					$this->mailNewBurger($lastID, $name, "uploads/0/".$userpic, $args);
					return true;
					exit;

				}catch(PDOException $e){
					exit;
				}
  	}

		public function mailNewBurger($lastID, $name, $pic, $args){
			$toAddress = "andrewgphillips74@gmail.com, matthewjsullivan7@gmail.com";
			$to = $toAddress;

			$from = "submit@burgerdex.ca";
			$headers = "From: " . $from . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

			$subject = "New Burger Submission YAY!";
			$message = "<style>
									.body {
							    	background-image: url(https://static.burgerdex.ca/assets/img/burger.png);
							    	background-size: 100%;
							    	background-position: 50% 0;
							    	background-repeat: no-repeat;
							    	background-color: #130502;
							    	width: 100%;
							    	height: auto;
							    	position: relative;
							    	display: block;
									}
									.activate {
									    outline: none;
									    border: none;
									    border-radius: 5px;
									    font-family: 'Oswald', sans-serif;
									    font-weight: 700;
									    color: #4f4432;
									    display: block;
									    float: right;
									    font-size: 20px;
									    height: 32px;
									    text-align: center;
									    position: relative;
									    line-height: 30px;
									    padding: 0px 14px;
									    cursor: pointer;
									    background-image: linear-gradient(to right, rgb(221, 173, 102) ,rgb(237, 211, 117));
									    background-position-x: initial;
									    background-position-y: initial;
									    background-size: initial;
									    background-repeat-x: initial;
									    background-repeat-y: initial;
									    background-attachment: initial;
									    background-origin: initial;
									    background-clip: initial;
									    background-color: initial;
											width: 100%;
											height: 50px;
											text-transform: uppercase;
											margin: 0 0 60px 0;
									}
									bold{
										font-weight:bold;
										font-size:20px;
									}
									</style>";
			$message .= "<div class='body' style='text-align:center;padding:20px 0;color:#fff;background-image: url(https://static.burgerdex.ca/assets/img/burger.png);background-size: 100%;background-position: 50% 0;background-repeat: no-repeat;background-color: #130502;width: 100%;height: auto;position: relative;display: block;'>";
			$message .= "<img width='200px' src='https://static.burgerdex.ca/assets/img/logo_email.png' /><br /><br />";
			$message .= "<img width='200px' style='border:1px solid #fff;' src='https://burgerdex.ca/".$pic."' /><br />";
			$message .= "<h1 style='font-weight:bold;font-size:20px;'>".$name."</h1><p style='color:#fff;'><br />Has been added and ready for approval!<br /><br /><br /></p>";
			$message .= "<ul style='list-style-type:none;width:300px;display:block;position:relative;margin:0 auto;text-align:left;'><li>kitchen: ".$args['kitchen']."</li><li>location: ".$args['locations']."</li><li>description: ".$args['description']."</li></ul>";
			$message .= "<h4>Ingredients:</h4>";
			$message .= "<ul style='width:300px;isplay:block;position:relative;margin:0 auto;text-align:left;'>";

			$ingys = explode(",", $args['ingredients']);

			foreach($ingys as $ingg){
				$message .= "<li>".$ingg."</li>";
			}
			$message .= "</ul><br /><p></p>";
			$message .= "<p style='outline: none;border: none;border-radius: 5px;font-weight: 700;color: #4f4432;display: block;float: right;font-size: 20px;height: 32px;text-align: center;position: relative;line-height: 30px;padding: 0px 14px;cursor: pointer;background-image: linear-gradient(to right, rgb(221, 173, 102) ,rgb(237, 211, 117));background-position-x: initial;background-position-y: initial;background-size: initial;background-repeat-x: initial;background-repeat-y: initial;background-attachment: initial;background-origin: initial;background-clip: initial;background-color: initial;width: 100%;height: 50px;text-transform: uppercase;margin: 0 0 10px 0;'>
			<a style='outline: none;border: none;border-radius: 5px;font-weight: 700;color: #4f4432;display: block;float: right;font-size: 20px;height: 32px;text-align: center;position: relative;line-height: 30px;padding: 0px 14px;cursor: pointer;background-image: linear-gradient(to right, rgb(221, 173, 102) ,rgb(237, 211, 117));background-position-x: initial;background-position-y: initial;background-size: initial;background-repeat-x: initial;background-repeat-y: initial;background-attachment: initial;background-origin: initial;background-clip: initial;background-color: initial;width: calc(100% - 28px);height: 50px;text-transform: uppercase;margin: 0 0 60px 0;text-decoration:none;line-height:48px;' class='activate' href='https://app.burgerdex.ca/services/activate.php?id=".$lastID."'>Activate!</a></p>";
			$message .= "<br /><p style='outline: none;border: none;border-radius: 5px;font-weight: 700;color: #4f4432;display: block;float: right;font-size: 20px;height: 32px;text-align: center;position: relative;line-height: 30px;padding: 0px 14px;cursor: pointer;background-image: linear-gradient(to right, rgb(221, 173, 102) ,rgb(237, 211, 117));background-position-x: initial;background-position-y: initial;background-size: initial;background-repeat-x: initial;background-repeat-y: initial;background-attachment: initial;background-origin: initial;background-clip: initial;background-color: initial;width: 100%;height: 50px;text-transform: uppercase;margin: 0 0 60px 0;'>
			<a style='outline: none;border: none;border-radius: 5px;font-weight: 700;color: #4f4432;display: block;float: right;font-size: 20px;height: 32px;text-align: center;position: relative;line-height: 30px;padding: 0px 14px;cursor: pointer;background-image: linear-gradient(to right, rgb(221, 173, 102) ,rgb(237, 211, 117));background-position-x: initial;background-position-y: initial;background-size: initial;background-repeat-x: initial;background-repeat-y: initial;background-attachment: initial;background-origin: initial;background-clip: initial;background-color: initial;width: calc(100% - 28px);height: 50px;text-transform: uppercase;margin: 0 0 60px 0;text-decoration:none;line-height:48px;' class='activate' href='https://app.burgerdex.ca/services/delete.php?id=".$lastID."'>DELETE</a></p>";
			$message .= "</div>";

			mail($to,$subject,$message,$headers);
		}
  	public function addMod($lastID,$modded){
  		try{
				$startDate = date("Y-m-d h:i:s");

				$queryInfo = "INSERT INTO burgerMods(modBurgerId, modded, date_modded)VALUES(:modBurgerId, :modded, :date_modded)";

				$statement = $this->conn->prepare($queryInfo);
				$statement->execute(array(
					"modBurgerId" => $lastID,
					"modded" => $modded,
					"date_modded" => $startDate
				));

				return;

			}catch(PDOException $e){
				return;
			}
  	}
  	public function addFusion($lastID,$fused){
  		try{
	  			foreach($fused as $fusion){
					$queryInfo = "INSERT INTO burgerFusions(fusedBurgerId, burgerId)VALUES(:fusedBurgerId, :burgerId)";

					$statement = $this->conn->prepare($queryInfo);
					$statement->execute(array(
						"fusedBurgerId" => $lastID,
						"burgerId" => $fusion
					));
				}
				return;
			}catch(PDOException $e){
				return;
			}
  	}

	/*image*/

	public function getExtension($str) {
		 $i = strrpos($str,".");
		 if (!$i) { return ""; }

		 $l = strlen($str) - $i;
		 $ext = substr($str,$i+1,$l);
		 return $ext;
	}
	public function image_fix_orientation($path){
		$ext = $this->getExtension($path);
		if($ext=='PNG'||$ext=='png'||$ext=='GIF'||$ext=='gif'){
			return;
		}else{
			$image = imagecreatefromjpeg($path);
		}

		$exif = exif_read_data($path);

		if (empty($exif['Orientation']))
		{
			return false;
		}

		switch ($exif['Orientation'])
		{
			case 3:
				$image = imagerotate($image, 180, 0);
				break;
			case 6:
				$image = imagerotate($image, - 90, 0);
				break;
			case 8:
				$image = imagerotate($image, 90, 0);
				break;
		}

		imagejpeg($image, $path);

		return true;
	}
	/*image*/

	public function activateBurger($id){
		try{

			$queryInfo = "UPDATE burgers SET active = 1 WHERE id = :value";

			$ingred = $this->conn->prepare($queryInfo);
			$ingred->bindParam(":value", $id, PDO::PARAM_STR);
			$ingred->execute();

			return;

		}catch(PDOException $e){
			return;
		}
	}



	public function makeThumbnail($sourcefile,$max_width, $max_height, $endfile, $type, $picType, $userpic){
		switch($type){
			case "image/png":
				$img = imagecreatefrompng($sourcefile);
			break;
			case "image/jpeg":
				$img = imagecreatefromjpeg($sourcefile);
			break;
			case "image/jpg":
				$img = imagecreatefromjpeg($sourcefile);
			break;
			case "image/gif":
				$img = imagecreatefromgif($sourcefile);
			break;
		}

		$width = imagesx($img);
		$height = imagesy($img);

		if($width > $height){
			if($width < $max_width){
				$newwidth = $width;
			}else{
				$newwidth = $max_width;
				$divisor = $width / $newwidth;
				$newheight = floor( $height / $divisor);
			}
		}else{
			if($height < $max_height){
				$newheight = $height;
			}else{
				$newheight = $max_height;
				$divisor = $height / $newheight;
				$newwidth = floor( $width / $divisor);
			}
		}

		$tmpimg = imagecreatetruecolor($newwidth, $newheight);

		imagealphablending($tmpimg, false);
		imagesavealpha($tmpimg, true);

		imagecopyresampled($tmpimg, $img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

		switch($type){
			case "image/png":
				imagepng($tmpimg, $endfile, 0);
			break;
			case "image/jpeg":
				imagejpeg($tmpimg, $endfile, 75);
			break;
			case "image/jpg":
				imagejpeg($tmpimg, $endfile, 75);
			break;
			case "image/gif":
				imagegif($tmpimg, $endfile, 0);
			break;
		}

		imagedestroy($tmpimg);
		imagedestroy($img);


		$url = $tmpimg;
		$data = json_decode(file_get_contents('http://api.rest7.com/v1/jpeg_optim.php?url=' . $url . '&encoding=baseline'));

		if (@$data->success !== 1)
		{
		    // die('Failed');
		}
		$image = file_get_contents($data->file);

		if($picType=="thumb"){
			file_put_contents('uploads/0/thumbs/'.$userpic, $image);
		}else{
			file_put_contents('uploads/0/'.$userpic, $image);
		}
	}
}

?>
