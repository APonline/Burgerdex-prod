
<?php
	echo "<div class='burger'>"
	."<ul>"
		."<li>"
			."<div class='burgerProfile'>"
				."<a href='".SITEPATH."/".$burger['image']."' data-featherlight=\"image\" title=\"".$burger['name']."\"><div class='burgerImage' style='background-image:url(".SITEPATH."/".$burger['image'].");'></div></a>"
				."<p style='display:none;'>".$burger['name']."</p>"
				."<div class='burgerID' style='float: unset;padding: 15px;margin: 0 20px 20px 0;'>".$burger['id']."<div>No.</div></div>"
				."<div class='burgerName' style='float: initial;font-size: 26px;color: #fff;padding: unset;'>".$burger['name']."</div><br />"
				."<div class='burgerInfo'>DISCOVERED: <span>".date("M j, Y",strtotime($burger['dated']))."</span></div><br />"
				."<div class='burgerInfo'>PRICE: <span>".$burger['price']."</span></div><br />"
				."<div class='burgerInfo'>KITCHEN: <span>".$burger['kitchen']."</span></div><br />"
				."<div class='burgerInfo'>REGION: <span>".$burger['locations']."</span></div><br />"
				."<div class='burgerInfo'>DESCRIPTION: <br /><span>".nl2br($burger['description'])."</span></div><br />"
				."<div class='burgerInfo ingredInfo'>INGREDIENTS: <br /><span><ul class='ingredients'>";
					$ingreds = explode(",",$burger['ingredients']);
					foreach($ingreds as $ing){
						echo "<li>&#x25cf; ".$ing."</li>";
					}
				echo "</ul></span></div><br />"
					."<br /><h3>BADGES</h3><br />"
				."<div class='singleBurgerBadges'>"
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
				$originBurger =$burger['id'];
				echo"</div>";
				/*BURGER FUSION*/
				if($burger['fusion']==1){
					$oldburg = $burger;
					echo"<div class='fusionSet'>"
						."<div class='burgerlist'>"
							."<h3>FUSIBLES</h3>"
							."<ul class='burgerset'>";
							foreach($burger['fused']['fusionBurgers'] as $fusee){
								$burger = $fusee;

								$numCount = "number";
								$showFuse = "show";
								//echo "<li>";
								include("template/burgerTab.php");
							}
							echo"
							</ul>
						</div>"
					."</div>";
					$burger = $oldburg;
				}
				/*BURGER FUSION*/

				/*BURGER MODS*/
				if($burger['hasMods']==1&&$originBurger==$burger['modded']['modId']){
					echo"<div class='modSet'>"
						."<div class='burgerlist'>"
							."<h3>MODS (".$burger['modded']['modCount'].")</h3>"
							."<ul class='burgerset'>";
							$x=1;
						foreach($burger['modded']['mods'] as $modee){
							$burgMod = $modee;

							echo"<div class='burgerName'>".$x.") ".$burgMod['mod']."</div><div style='font-size:12px;'>".date("M-j-Y",strtotime($burgMod['date_modded']))."</div><br />";
							$x++;
						}
						echo"</div>"
					."</div>";
				}
				/*BURGER MODS*/

			echo "</div>"
		."</li>"
	."</ul>"
	."</div>";

	echo "<a class='catalogPgTab prev' href='".SITEPATH."/burger/".makeSEOURL($burger['index']['prev']['url'])."'><div>PREV</div></a>";
	echo "<a class='catalogPgTab next' href='".SITEPATH."/burger/".makeSEOURL($burger['index']['next']['url'])."'><div>NEXT</div></a>";
?>
