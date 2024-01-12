<?php
	$content = "This burger was fucking awesome. I also thought\n\nmaybe it could use some help with the cooking.\n\n\nMaybe.\nI could...\n\n\n\nHelp!";

	echo nl2br($content);

	//$content = "This a good Fucking test. As I sit on my ass typing away, I roll with the hottest bitches and I simply don't give a shit.";


	$test = new MrClean();
	//$test1 = $test->badLanguageFix('#');
	$test2 = $test->badLanguage($content, 'judge');
?>

<div class='submitForm' style='line-height: initial;'>
	<?php

	//echo '<pre>' . var_export($test2, true) . '</pre>';

	echo $test2['judgement']."<br /><br />";
	echo "There were ".$test2['fixedCount']." bad words caught...<br />";

	var_dump($test2['wordsFound']);

	echo "<br /><br />";

	echo $test2['original'];

	echo "<br /><br />";

	echo $test2['edited'];
	?>
</div>
