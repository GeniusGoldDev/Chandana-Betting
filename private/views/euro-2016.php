<?php
include "Includes/config.php";
include "Classess/Crawler.php";
$url = $tmp_odds_url = $odds_url."euro-2016";
$url_collection = get_url_collection($url);
?>
<?php
if(!empty($url_collection))
{
	$result = get_result($url_collection);
	
	for($i=0;$i<count($result);$i++)
	{ ?>
		<h1 class="heading"><?php echo $result[$i]['title'] ?><small><?php echo $result[$i]['date_time'] ?></small></h1><div id="oddsTableContainer">
		<?php 
		if(!empty($result[$i]['data']))
		{ ?>
			<?php echo $result[$i]['data'];?>
			<div class="col-md-4 col-md-offset-8 divCheckWrapper pull-right">
			    <button class="oddsCalculator btn btn-info">Calculate</button>
				<button class="checkodds btn btn-info">Check</button>
			 	<button class="uncheckodds btn btn-info">Un Checkall</button></div><div class="content">
			</div>	
		<?php 
		}
		else
		{ ?>
			<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>No Data found!!!</div>	
		<?php
		 }	
	}
}	
else
{ ?>
	<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>No Data found!!!</div>
<?php 
}
?>