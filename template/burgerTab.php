<?php

	$burgerImg = SITEPATH."/".$burger['image'];

	echo "<a href='".SITEPATH."/burger/".makeSEOURL($burger['url'])."'>"; ?><li class='' style='background:linear-gradient(to left, rgba(62,55,44, .3) 0%, rgba(62,55,44, .7) 10%, rgba(62,55,44, 1) 25%, rgba(62,55,44, 1) 50%, rgba(62,55,44, 1) 70%), url(<?php echo $burgerImg; ?>) right 50% / 36% no-repeat'
	onmouseover='this.style.background="linear-gradient(to left, rgba(62,55,44, 0) 0%, rgba(62,55,44, .5) 20%, rgba(62,55,44, .9) 25%, rgba(62,55,44, 1) 30%, rgba(86, 69, 43, 1) 50%), url(<?php echo $burgerImg; ?>) right 50% / 43% no-repeat"'
	onmouseout='this.style.background="linear-gradient(to left, rgba(62,55,44, .3) 0%, rgba(62,55,44, .7) 10%, rgba(62,55,44, 1) 25%, rgba(62,55,44, 1) 50%, rgba(62,55,44, 1) 70%), url(<?php echo $burgerImg; ?>) right 50% / 36% no-repeat"'>

	<?php

	if(isset($showFuse)||isset($numCount)){
		if($numCount=="number"){
			$i=$burger['id'];
			$ID=$i."<div>No.</div>";
			$IDstyle = "";
		}elseif($numCount=="discovered"){
			$ID=date("M j, Y",strtotime($burger['dateCaptured']));
			$IDset = explode(",", $ID);

			$ID = "".$IDset[0]."<br />".$IDset[1]."";
			$IDstyle = "style='padding-top: 0px;height: auto;line-height: 20px;font-size:15px;'";
		}else{
			$ID=$i."<div>#</div>";
			$IDstyle = "";
		}
	}else{
		$ID=$i."<div>#</div>";
		$IDstyle = "";
	}

	echo"<div class='burgerID' ".$IDstyle.">".$ID."</div>"
	."<div class='burgerName'>".$burger['name']."<br /><div>".$burger['kitchen']."</div></div>"
	."<div class='burgerPrice' style='color:#fff;line-height: 40px;'>".$burger['price']."</div>"

	."<div class='burgerBadges'>"
	."<div class='badge burgerRating'><img src='".SITE_PATH_STATIC."/assets/img/rating.svg' width='40' /><div>".$burger['rating']."</div></div>";

	if($burger['seasonal']==1){
		echo "<div class='badge burgerSeasonal'><img src='".SITE_PATH_STATIC."/assets/img/seasonal.svg' width='40' /></div>";
	}
	if($burger['extinct']==1){
		echo "<div class='badge burgerExtinct'><img src='".SITE_PATH_STATIC."/assets/img/available.svg' width='40' /></div>";
	}
	if($burger['spicy']==1){
		echo "<div class='badge burgerSpicy'><img src='".SITE_PATH_STATIC."/assets/img/spicy.svg' width='40' /></div>";
	}
	if($burger['veggie']==1){
		echo "<div class='badge burgerVeggie'><img src='".SITE_PATH_STATIC."/assets/img/veggie.svg' width='40' /></div>";
	}
	if($burger['hasChallenge']==1){
		echo "<div class='badge burgerChallenge'><img src='".SITE_PATH_STATIC."/assets/img/hasChallenge.svg' width='40' /></div>";
	}
	if($burger['fusion']==1){
		echo "<div class='badge burgerFusion'><img src='".SITE_PATH_STATIC."/assets/img/fusion.svg' width='40' /></div>";
	}
	if($burger['hasMods']==1){
		echo "<div class='badge burgerHasMods'><img src='".SITE_PATH_STATIC."/assets/img/hasMods.svg' width='40' /></div>";
	}

	echo"</div>";

	echo "<div class='burgerGo'>></div>"
	."</li></a>";

?>
