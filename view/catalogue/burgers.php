
<sort>
	<h3>SORT BY: <div id='sort'><?php echo $search; ?></div></h3>
		<ul>
			<li id='sortClose'>CLOSE</li>
			<?php
			$sort = $GLOBALS['sort'];

			for($x=0; $x<count($sort); $x++){
				$pageCurr = $sort[$x]['url'];

				if($sortSet==$pageCurr){
					$GLOBALS['page'] = $sort[$x]['name'];
					echo "<li class='active'><a href='".SITEPATH."/burgers-search-by/".makeSEOURL($sort[$x]['url'])."/1'> ".makeSEOURL($sort[$x]['name'])."</a></li>";
				}else{
					echo "<li><a href='".SITEPATH."/burgers-search-by/".makeSEOURL($sort[$x]['url'])."/1'> ".makeSEOURL($sort[$x]['name'])."</a></li>";
				}
			}
			?>
		</ul>
</sort>

<?php
if(!empty($burgerList)){
	echo "<div class='burgerlist'>";
		if(isset($numCount)&&$numCount=="location"){
			$addressed=array();

			foreach($burgerList as $location){
				$locationTitle = $location['locationTitle'];
				if(!in_array($locationTitle, $addressed)){
					array_push($addressed, $locationTitle);
					echo ucwords($locationTitle)."<br />";

					echo"<ul class='burgerset'>";
						$i=1;
						$ID=1;
						foreach($burgerList as $burger){
							if($burger['locationTitle']==$locationTitle){
								$ID=$i."<div>#</div>";
								include("template/burgerTab.php");
								$i++;
								$ID++;
							}
						}
					echo "</ul><br />";
				}
			}
		}elseif(isset($numCount)&&$numCount=="kitchen"){
			$addressed=array();
			foreach($burgerList as $kitchen){
				$kitchenTitle = $kitchen['kitchenTitle'];
				if(!in_array($kitchenTitle, $addressed)){
				array_push($addressed, $kitchenTitle);
					echo ucwords($kitchenTitle)."<br />";

					echo"<ul class='burgerset'>";
						$i=1;
						$ID=1;
						foreach($burgerList as $burger){
							if($burger['kitchenTitle']==$kitchenTitle){
								$ID=$i."<div>#</div>";
								include("template/burgerTab.php");
								$i++;
								$ID++;
							}
						}
					echo "</ul><br />";
				}
			}
		}else{
			echo"<ul class='burgerset'>";

			if(!isset($page)){
				$i=1;
			}else{
				if($page>1){
					$fk=$page - 1;
					$fk=(string)$fk."1";
					$i=(int)$fk;
				}else{
					$i=1;
				}
			}
				foreach($burgerList as $burger){
					include("template/burgerTab.php");
					$i++;
				}
			echo "</ul>";
		}
	echo"</div>";


	$total_pages = ceil($burgerCount / $limit);
	$pagLink = "<div class='pagination'>";

	if($total_pages>1){
		for ($i=1; $i<=$total_pages; $i++) {
			if($page==$i){
				$pagLink .= "<a href='".SITEPATH."/".$pgType."/".$i."' class='activepg'>".$i."</a>";
			}else{
				$pagLink .= "<a href='".SITEPATH."/".$pgType."/".$i."'>".$i."</a>";
			}
		};
	}
	echo $pagLink ."</div>";

}else{
	echo "<div class='burgerlist nomatch'>No ".$sortSet." Matches...</div>";
}
?>



<script>
	$(document).ready(function(){
	  $('.burgerlist ul li').each(function(i) {
		var $li = $(this);
		setTimeout(function() {
		  $li.addClass('show');
		}, i*150); // delay 100 ms
	  });

	  setTimeout(function(){
		  $($('.pagination a').get().reverse()).each(function(i) {
			var $li = $(this);
			setTimeout(function() {
			  $li.addClass('show');
			}, i*150); // delay 100 ms
		  });
	  },800);
	});
</script>
