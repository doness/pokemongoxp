<?php 
$current_level 		= intval($_GET['clvl']);
$current_xp 			= intval($_GET['cxp']);
$xp_earned 				=	intval($_GET['xpe']);

if($current_level == "" || $current_xp == "" || $xp_earned == ""){
	echo '<p>Hmm, looks like you forgot to type in something. Try filling out the form again.</p><a href="/">Back</a>';
	exit();
}

include_once($_SERVER["DOCUMENT_ROOT"] . "/levels.php");
$levels_count = count($levels)-1;
if($current_level >= $levels_count){
	echo "<p>Wow there, you're a high level pokemon trainer. Unfortunately we only have data for levels up to $levels_count</p><a href=\"/\">Back</a>";
	exit();
}


?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Pokemon GO XP Calculator Results</title>

	<link rel="stylesheet" type="text/css" href="/css/style.css">

	<script type="text/javascript" src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>

</head>
<body>

	<div class="results_main_header">
		<?php echo "<p>A level <b>$current_level</b>, with <b>$current_xp</b> XP, earning <b>$xp_earned</b> XP per 5 minutes would take this long per level.</p>";?>
		<a style="margin:15px 0px;display:block; float:left;" href="/">Back to calculator</a>
		<a style="margin:15px 0px;display:block; float:right;" href="/rawdata">Raw Data</a>
		<div style="clear:both;"></div>
	</div>

	<div class="results_ul_header">
		<div class="first">Lvl</div>
		<div class="second">Time to reach level</div> 
		<div style="clear:both;"></div>
	</div>

	<ul class="results_ul">
	<?php
	$minutes = 0;
	$hours = 0;
	$accumulative_xp = 0;

	for ($i=$current_level+1; $i <= $levels_count; $i++) { 
		$minutes = 0;//reset minutes
		$hours = 0;//reset hours

		$a_level 					= $levels[$i]['level'];
		$accumulative_xp 	= $levels[$i]['xp_req'] + $accumulative_xp;
		$total_xp_req 		= $levels[$i]['total_xp_req'];
		$unlocked_items 	= $levels[$i]['unlocked_items'];
		$rewards 					= $levels[$i]['rewards'];
		// echo "$a_level $accumulative_xp $total_xp_req $unlocked_items $rewards <br>";

		$xp_gap = $accumulative_xp-$current_xp;


		while($xp_gap >= 1){
			$xp_gap = $xp_gap - $xp_earned;
			$minutes = $minutes+5;
		}

		while($minutes >= 60){
			$hours = $hours+1;
			$minutes = $minutes - 60;
		}
		if($hours == 0){$hours = "";
		}elseif($hours > 1){$hours = $hours." hours ";
		}else{$hours = $hours." hour ";}

		if($minutes == 0){$minutes = "";
		}elseif($minutes > 1){$minutes = $minutes." minutes";
		}else{$minutes = $minutes." minute";}

		echo 
		'<li>
			<div class="first">'.$a_level.'</div>
			<div class="second">'.$hours.$minutes.'</div>
			<div class="three highlightoff"><div class="redButton">Rewards</div></div>
			<div style="clear:both;"></div>
			<div class="rewards" style="display:none;">'.$rewards.'</div>
		</li>';
	} 

	?>
	</ul>
	<br>
	<p class="made_by">Made by Trevor Wood - <a href="https://twitter.com/frogg616">Twitter</a></p>




	<script type="text/javascript">
		$('.redButton').on('click',function(){
			$(this).parent().parent().find(".rewards").slideToggle('fast');
		});
	</script>



<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-71263008-2', 'auto');
  ga('send', 'pageview');

</script>





</body>
</html>