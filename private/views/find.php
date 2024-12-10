<?php
// USAGE

include "Includes/config.php";
include "Classess/Crawler.php";
$uri = isset($_GET['q'])?$_GET['q']:'';
$uri_array = explode( "/", $uri );
?>
<div id="myModal" class="modal_find" style="width: 500px;height: 560px;">
	<div class="modal-content">
		<form id="search_form" action="<?php echo $base_url ?>/search_result" method="get">
		<br>
	    <div style="color: white">
	    	<span class="close close_icon">&times;</span>
	    	<h2 style="margin-left: 160px;">Find the Matches</h2>
	    </div>
		<br>
	    <div class="modal-header form-group" style="height: 215px;">
	      <h3>Sport : </h3>
	      <br>
	      <select class="form-control" id="sport_type" name="sport_type">
	        <option>Football</option>
	        <option>Horse Racing</option>
	        <option>Tennis</option>
	        <option>Golf</option>
	        <option>Cycling</option>
	        <option>Basketball</option>
	        <option>Boxing</option>
	      </select>
	      <br><br>
	      <h3>Match Name : </h3>
	      <br>
	      <input type="text" id="match_name" name="match_name" placeholder="Enter match name" style="width: 419px;">
	      <br>
	    </div>
	    <br>
	    <br>
	    <div class="modal-body form-group">
	      <h3 for="market_type">Market : </h3>
	      <br>
	      <select class="form-control" id="market_type" name="market_type">
	        <option>Winner</option>
	        <option>Total Goals Over Under</option>
	        <option>Half Time Full Time</option>
	        <option>Half Time</option>
	        <option>Both Teams To Score</option>
	        <option>Correct Score</option>
	        <option>Double Chance</option>
	        <option>Asian Handicap</option>
	        <option>Handicaps</option>
	        <option>Half Time Score</option>
	      </select>
	      <br>
	      <br>
	      <h3 for="date">Date :<input type="date" id="match_date" name="match_date"></h3>
	      <!-- <h3 for="date">Date :<datepicker type="grid" id="match_date" name="match_date"/></h3> -->
	      <br>
	    </div>
	    <div>
	    	<input type="submit" value="Serach" class="btn search_btn" style="margin-right: 215px;">
	    </div>
	</form>
	</div>
	</div>
<script language="javascript">
$(document).ready(function () {
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var isFirefox = typeof InstallTrigger !== 'undefined';
	if (isFirefox) {
		var today = (month)+"/"+(day)+"/"+now.getFullYear();
	}
	var isChrome = !!window.chrome && !!window.chrome.webstore;
	if (isChrome) {
		var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
	}
	$('#match_date').val(today);
	select_sport();

})

var times = 1;

$('.close').on('click', function(){
	$('.modal-content').css("display", "none");
});

$('#sport_type').on('click', function(){
	select_sport();
});

function select_sport() {
	if (times){
		var select = $('#sport_type');
		console.log(select[0].value);
		times = -1;
		if(select[0].value == "Football"){
			$('#market_type').empty();
			var text = '<option>Winner</option><option>Total Goals Over Under</option><option>Half Time Full Time</option><option>Half Time</option><option>Both Teams To Score</option><option>Correct Score</option><option>Double Chance</option><option>Asian Handicap</option><option>Handicaps</option><option>Half Time Score</option>';
			$('#market_type').append(text);
			$('#search_form').attr('action', '<?php echo $base_url ?>/search_result');
		}
		else if (select[0].value == "Tennis") {
			$('#market_type').empty();
			var text = '<option>Winner</option><option>Games Handicap</option><option>Set Betting</option><option>Total Sets</option>';
			$('#market_type').append(text);
			$('#search_form').attr('action', '<?php echo $base_url ?>/search_result');
		}
		else{
			$('#market_type').empty();
			$('#search_form').attr('action', '#');
		}
	}
	times++;
}

if ( $('#match_date')[0].type != 'date' ) {$('#match_date').datepicker();}
</script>