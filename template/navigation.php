<nav>
	<div id='logo'><a href="<?php echo SITEPATH ?>/"><img src="<?php echo SITE_PATH_STATIC; ?>/assets/img/logo_burger.svg" /></a></div>
	<ul>
		<?php
		$nav = $GLOBALS['nav'];
		$active = $GLOBALS['active'];

			for($x=0; $x<count($nav); $x++){
				$pageCurr = $nav[$x]['url'];

				if($active==$pageCurr){
					$GLOBALS['page'] = $nav[$x]['name'];
					echo "<li class='active'><a href='".SITEPATH."/".$nav[$x]['url']."'>".$nav[$x]['name']."</a></li>";
				}else{
					echo "<li><a href='".SITEPATH."/".$nav[$x]['url']."'>".$nav[$x]['name']."</a></li>";
				}
			}
		?>
	</ul>
	<div id="menu"><img src="<?php echo SITE_PATH_STATIC; ?>/assets/img/menu.png" style="width:100%;"></div>
	<div id='icon' style='margin-top: 22px;'>
		<a href='https://itunes.apple.com/ca/app/burgerdex/id1372235797?mt=8' target='_blank'>
			<img src="<?php echo SITE_PATH_STATIC; ?>/assets/img/ios_appstore.svg" height="39" />
		</a>
		<a href='https://play.google.com/store/apps/details?id=ca.burgerdex.burgerdex' target='_blank'>
			<img src="<?php echo SITE_PATH_STATIC; ?>/assets/img/android_playstore.png" height="39" />
		</a>
	</div>

	<subnav>
		<div id="openLegend">- View Legend -</div>
		<div class="subnavInner">
		<?php
			echo "<div class='legend'><img src='".SITE_PATH_STATIC."/assets/img/rating.svg' width='20' /> RATING</div>";
			echo "<div class='legend'><img src='".SITE_PATH_STATIC."/assets/img/veggie.svg' width='20' /> VEGGIE</div>";
			echo "<div class='legend'><img src='".SITE_PATH_STATIC."/assets/img/spicy.svg' width='20' /> SPICY</div>";
			echo "<div class='legend'><img src='".SITE_PATH_STATIC."/assets/img/seasonal.svg' width='20' /> LIMITED</div>";
			echo "<div class='legend'><img src='".SITE_PATH_STATIC."/assets/img/available.svg' width='20' /> EXTINCT</div>";
			echo "<div class='legend'><img src='".SITE_PATH_STATIC."/assets/img/hasChallenge.svg' width='20' /> FOOD CHALLENGE</div>";
			echo "<div class='legend'><img src='".SITE_PATH_STATIC."/assets/img/fusion.svg' width='20' /> FUSION</div>";
			echo "<div class='legend'><img src='".SITE_PATH_STATIC."/assets/img/hasMods.svg' width='20' /> MODDED</div>";
		?>
		</div>
	</subnav>
</nav>

<div id='shade'></div>
<section>
