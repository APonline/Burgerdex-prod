<loader>
	<div>
		<img src='<?php echo SITE_PATH_STATIC; ?>/assets/img/logo.svg' width='300' />
		<br />
		<img src='<?php echo SITE_PATH_STATIC; ?>/assets/img/burgerload.gif' />
	</div>
</loader>

<script>
$(document).ready(function(){
	setTimeout(function(){
		$('nav ul li').first().addClass('active');
		$('loader').animate({opacity:0},400,function(){
			$('loader').remove();
		});
	},1200);
});
</script>