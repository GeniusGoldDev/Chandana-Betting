<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
<?php
// USAGE

include "Includes/config.php";
include "Classess/Crawler.php";
$uri = isset($_GET['q'])?$_GET['q']:'';
$sport_type =  isset($_GET['sport_type'])?$_GET['sport_type']:'';
$match_name =  isset($_GET['match_name'])?$_GET['match_name']:'';
$match_date =  isset($_GET['match_date'])?$_GET['match_date']:'';
$market_type =  isset($_GET['market_type'])?$_GET['market_type']:'';
$uri_array = explode( "/", $uri );
$url = $tmp_odds_url = $odds_url.$_GET['q'];

$url = str_replace("/ongoing", "", $url);
$odds = ((in_array('ongoing', $uri_array))? "In Play":"All Odds");
?>

<?php

	$url_collection = get_url_collection_match_search($sport_type, $match_name, $market_type, $match_date);

	if(!empty($url_collection))
	{
		$result = get_result($url_collection);
		if(empty($result))
		{ ?>
			<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>No Data found!!!</div>	
		 <?php
		}
		else
		{
			$j=0;
			for($i=0;$i<count($result);$i++)
			{
				if(in_array('today-matches', $uri_array))
				{	
					if(date('d-m-Y') != date('d-m-Y', strtotime($result[$i]['date_time']))){	
						$j++; 
						continue;
					}
				}
				?>
				<div style="height: 20px"></div>
				<h1 class="heading"><?php echo $result[$i]['title'] ?> <small><?php echo $result[$i]['date_time'] ?></small></h1>
				<div id="oddsTableContainer">
				<?php 
				if(!empty($result[$i]['data']))
				{ ?>
					<?php echo $result[$i]['data'];?>
					<div class="col-md-4 col-md-offset-8 divCheckWrapper pull-right">
						<button class="IFBet btn btn-info">IFBet</button>
						<button class="checkodds btn btn-info">BET NOW</button>
					 	<button class="uncheckodds btn btn-info">CLEAR BETS</button>
					</div>
					<div class="content"></div>	
				<?php 
				}
				else
				{ ?>
					<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>No Data found!!!</div>	
				<?php
				 } 
			}

			if(count($result) == $j)
			{
				?>
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

<script language="javascript">

var event1 = "";
var event_date_time = "";

$(document).on('click', '.oddcheck', function(){
	var date_time = $(this).parent().parent().parent().parent().parent().prev().find('small').html();
	var d = new Date(date_time);
	
	event_date_time = d.getDate()+'/'+(d.getMonth()+1)+'/'+d.getFullYear()+' '+d.getHours()+':'+d.getMinutes();

	var event = $(this).parent().parent().parent().parent().parent().prev().html();

	var str1 = event.split("</button>");
	var str2 = str1[1];
	var str3 = str2.split("<small>");
	event1 = str3[0];

});

var football='<div class="item w4 h4 nc_main_element" id="nc_standalone_template" style="display: none"><div class="new_calc standalone_nc"><div class="deactivation_icon"><a class="close_icon" href="#">X</a></div><div class="nc_header_text">CALCULATOR</div><div class="new_calc_league_bet_infos"><div><div class="new_calc_league_bet_risk_text ncl_btext">Risk</div><div class="new_calc_league_bet_profit_text ncl_btext">Profit</div><div class="new_calc_league_bet_win_text ncl_btext">Win</div></div><div><div class="new_calc_league_bet_risk_text ncl_btext valuediv"><input size="5" value="100" class="risk_input" onfocus="this.value=this.value;">&pound;<img class="left" src="<?php echo $base_url;?>/img/icons_2/edit.png"></div><div class="new_calc_league_bet_profit_text ncl_btext valuediv"><span class="middle"></span> % </div><div class="new_calc_league_bet_win_text ncl_btext valuediv"><input size="5" value="100" class="win_input">&pound;<img class="right" src="<?php echo $base_url;?>/img/icons_2/edit.png"></div></div></div><div class="nc_table_container"><table class="nc_table"><tr class="table_row_nc title_row small_row"><td class="nc_broker_cell"></td><td class="nc_quote_cell calc_ncq_1 ncq_cursor_element"><div>Back</div></td><td class="nc_quote_cell calc_ncq_2 ncq_cursor_element"><div>Lay</div></td><td class="nc_quote_cell calc_ncq_3 ncq_cursor_element"><div></div></td></tr><tr><td></td><td class="logo1"></td><td class="logo2"></td><td class="logo3"></td></tr><tr class="table_row_nc"><td class="nc_broker_cell">Odds</td><td class="nc_quote_cell ncq_1 ncq_cursor_element"><input value="Err" class="ncqc1_input_odd"></td><td class="nc_quote_cell ncq_2 ncq_cursor_element"><input value="Err" class="ncqc2_input_odd"></td><td class="nc_quote_cell ncq_3 ncq_cursor_element"><input value="Err" class="ncqc3_input_odd"></td></tr><tr class="bet_value_row"><td class="nc_broker_cell">Bets</td><td class="nc_quote_cell ncqc1 ncq_cursor_element"><input value="1" class="ncqc1_input"> &pound;</td><td class="nc_quote_cell ncqc2 ncq_cursor_element"><input value="2" class="ncqc2_input"> &pound;</td><td class="nc_quote_cell ncqc3 ncq_cursor_element"><input value="3" class="ncqc3_input"> &pound;</td></tr></table><div class="batnow_betclear"><button class="betnow btn btn-info">BET NOW</button><button class="clearbets btn btn-info">CLEAR BETS</button></div></div></div></div>';


var horse = '<div class="item w4 h4 nc_main_element" id="nc_standalone_template" style="display: none;width:100%;"><div style="float:left;"><h1 style="color:#fff";>Match Information</h1><div class="deactivation_icon" id="closehide"><a class="close_icon" href="#" style="margin-top:-35px;">X</a></div><div class="eventInfoBox"><table class="match_info"><tbody><tr><td><img src="<?php echo $base_url;?>/img/calculator/date.png"></td><th>Date / Time</th><td id="event_date_time">'+event_date_time+'</td></tr><tr><td><img src="<?php echo $base_url;?>/img/calculator/2.png"></td><th>Event</th><td id="event1">'+event1+'</td></tr></body></table></div><div class="backLayWrapper"><div class="backDetails"><div class="backTitle"> BACK</div><div class="backOutcome"><span id="lblOutcome1" class="jockey"></span></div><div class="backOdds"><span id="lblBackOdds"></span></div><div class="backLiquidity"> &nbsp; </div><div class="backLastUpdate"> </div></div><div class="layDetails"><div class="layTitle"> LAY </div><div class="layOutcome"> <span id="lblOutcome2" class="jockey"></span> </div><div class="layOdds"> <span id="lblLayOdds"></span></div><div class="backLiquidity"> &nbsp; </div><div class="layLastUpdate"> </div></div><div class="backBookieDetails"> <div class="backBookieTitle" id="logo1"> </div><div class="backBookieTitle bookieLink"> <img id="imgBookieDirect" title="This is a direct link straight to the correct market" class="directLink" src="<?php echo $base_url;?>/img/calculator/directlink.png"> <a id="linkBookie1" target="_blank"></a> </div></div><div class="backBookieDetails1"> <div class="backBookieTitle" id="logo2"> </div><div class="backBookieTitle bookieLink"> <img id="imgBookieDirect" title="This is a direct link straight to the correct market" class="directLink" src="<?php echo $base_url;?>/img/calculator/directlink.png"> <a id="linkBookie2" target="_blank"></a> </div></div><div style="width:100%;"><button class="betnow btn btn-info">BET NOW</button><button class="clearbets btn btn-info">CLEAR BETS</button><button id="btn_show_calculator" style="float:right;margin-right:0%;">Show Calculator >></button></div></div></div><div class="new_calc standalone_nc show1" id="show_calculator" style="padding:0px;"><div><div class="nc_header_text">CALCULATOR</div><div class="deactivation_icon"><a class="close_icon" href="#" style="margin-top:-35px;">X</a></div><div class="bookmaker"> <table class="bookmakerTable" cellpadding="0" cellspacing="0"> <tbody><tr> <td class="bookmakerInfoCol"> <img id="Image2" title="Enter the amount that you intend to bet at the bookmaker<br><br>This will be the amount of the FREE BET or the QUALIFYING BET" src="<?php echo $base_url;?>/img/calculator/information.png"> </td><td class="bookmakerLeftCol"> <span class="yellow"><span id="lblBookieName1" class="lblBookieName"></span> <span>STAKE</span></span> </td><td class="bookmakerRightCol"> <span id="txtBookieStake_wrapper" class="riSingle RadInput RadInput_Default" style="width:70px;"><input id="txtBookieStake1" name="txtBookieStake" class="ncqc1_input riTextBox riEnabled" value="" type="text"></span> £ </td></tr><tr> <td class="bookmakerInfoCol"> <img id="imgInfo1" title="This shows the odds that you will back at the Boookmaker<br><br>This field is automatically filled in with the match you found but you can amend if the bookmaker s odds have changed" src="<?php echo $base_url;?>/img/calculator/information.png"></td><td class="bookmakerLeftCol"> <span id="lblBookieName" class="lblBookieName"></span> ODDS </td><td class="bookmakerRightCol"> <span id="txtBookieOdds_wrapper" class="riSingle RadInput RadInput_Default" style="width:70px;"><input id="txtBookieOdds1" name="txtBookieOdds" class="ncqc1_input_odd riTextBox riEnabled" value="" type="text" style="text-align: center;width:70%;margin-right:10%;"></span> </td></tr><tr> <td class="bookmakerInfoCol"> <img id="Image2" title="Enter the amount that you intend to bet at the bookmaker<br><br>This will be the amount of the FREE BET or the QUALIFYING BET" src="<?php echo $base_url;?>/img/calculator/information.png"> </td><td class="bookmakerLeftCol"> <span id="lblBookieName" class="lblBookieName"></span> COMMISSION </td><td class="bookmakerRightCol"> <span id="txtBookieOdds_wrapper" class="riSingle RadInput RadInput_Default" style="width:70px;"><input id="txtBookieComm" name="txtBookieComm" class="riTextBox riEnabled" value="0" type="text" style="text-align: center;width:70%;margin-left: 5%;"></span> % </td></tr></tbody></table> </div><div class="bookmaker"> <table class="bookmakerTable" cellpadding="0" cellspacing="0"> <tbody><tr> <td class="bookmakerInfoCol"> <input id="txtBookieStake2" name="txtBookieStake" class="ncqc2_input riTextBox riEnabled" value="0" type="hidden" style="text-align: center;width:70%;"> </td></tr><tr> <td class="bookmakerInfoCol"> <img id="Image2" title="Enter the amount that you intend to bet at the bookmaker<br><br>This will be the amount of the FREE BET or the QUALIFYING BET" src="<?php echo $base_url;?>/img/calculator/information.png"> </td><td class="bookmakerLeftCol"> <span id="lblBookieName" class="lblBookieName1"></span> ODDS </td><td class="bookmakerRightCol"> <span id="txtBookieOdds_wrapper" class="riSingle RadInput RadInput_Default" style="width:70px;"><input id="txtBookieOdds2" name="txtBookieOdds" class="ncqc2_input_odd riTextBox riEnabled" value="0" type="text" style="text-align: center;width:70%;margin-right:10%;"></span> </td></tr><tr> <td class="bookmakerInfoCol"> <img id="Image2" title="Enter the amount that you intend to bet at the bookmaker<br><br>This will be the amount of the FREE BET or the QUALIFYING BET" src="<?php echo $base_url;?>/img/calculator/information.png"> </td><td class="bookmakerLeftCol"> <span id="lblBookieName" class="lblBookieName1"></span> COMMISSION </td><td class="bookmakerRightCol"> <span id="txtBookieOdds_wrapper" class="riSingle RadInput RadInput_Default" style="width:70px;"><input id="txtLayComm" name="txtLayComm" class="riTextBox riEnabled" value="" type="text" style="text-align: center;width:70%;margin-left: 5%;"></span> % </td></tr></tbody></table> </div><div class="bookmaker_results"> <a id="lnkBookie" class="bookieResultLink" href="#" target="_blank">Go to Betfred</a> <br>Bet <span id="lblSimpleStake" class="lay"></span> at odds of <span id="lblSimpleBackOdds" class="lay"></span> </div><div class="exchange_results"> <a id="lnkExchange" class="exchangeResultLink" href="#" target="_blank">Go to Smarkets</a><br>Lay <span id="lblSimple_layAmount" class="lay"></span> at odds of <span id="lblSimple_layOdds" class="lay"></span> <br><span class="liability_text">your liability will be <span id="lblSimple_liability" class="liability">Comingsoon</span></span> </div><div class="overall_results overall_results_simple"> <div class="hidden"> If the Bookmaker Bet wins your position will be <span id="lblSimple_BookieWin" class="profit">£0.20</span><br><br>If the Exchange Lay wins your position will be <span id="lblSimple_BookieLose" class="profit">£0.19</span><br></div>Your profit will be <span id="lblSimple_Profit" class="profit middle"></span> </div><div class="overall_results"> <table style="margin:10px auto 10px auto;" cellpadding="0" cellspacing="0"> <tbody><tr> <td style="text-align:left;"><i></i></td><td style="padding-right:10px;padding-left:10px;">Bookmaker</td><td style="padding-right:10px;padding-left:10px;">Exchange</td><td></td><td style="padding-right:10px;padding-left:10px;">Total</td></tr><tr> <td style="border-bottom:1px solid darkgrey; text-align:left; background-color: #D7ECFA;padding:7px;">IF BOOKMAKER (BACK) BET WINS</td><td style="border-bottom:1px solid darkgrey; font-weight:300 !important;"> <span id="lblBackWin_Bookie_Profit" class="profit"></span> </td><td style="border-bottom:1px solid darkgrey;"> <span id="lblBackWin_Exchange_Profit" class="loss">-£3.44</span> </td><td style="border-bottom:1px solid darkgrey;">=</td><td style="border-bottom:1px solid darkgrey;"><strong><span id="lblBackWin_Profit" class="profit"></span></strong></td></tr><tr style=""> <td style="text-align:left;background-color: #FDDEE5;padding: 5px;">IF EXCHANGE (LAY) BET WINS</td><td> <span id="lblLayWin_Bookie_Profit" class="loss"></span></td><td> <span id="lblLayWin_Exchange_Profit" class="profit">+£14.05</span></td><td>=</td><td><strong><span id="lblLayWin_Profit" class="profit">£0.05</span></strong></td></tr></tbody></table> </div><div class="new_calc_league_bet_infos"><!--div><div class="new_calc_league_bet_risk_text ncl_btext">Risk</div><div class="new_calc_league_bet_profit_text ncl_btext">Profit</div><div class="new_calc_league_bet_win_text ncl_btext">Win</div></div--><div><div class="new_calc_league_bet_risk_text ncl_btext valuediv"><input type="hidden" size="5" value="100" class="risk_input" onfocus="this.value=this.value;"><img class="left hide" src="<?php echo $base_url;?>/img/icons_2/edit.png"></div><div class="new_calc_league_bet_profit_text ncl_btext valuediv"><span class="middle" style="display:none;"></span> </div><div class="new_calc_league_bet_win_text ncl_btext valuediv"><input type="hidden" size="5" value="100" class="win_input"><img class="right hide" src="<?php echo $base_url;?>/img/icons_2/edit.png"></div></div></div><div class="nc_table_container"><table class="nc_table"><tr class="table_row_nc title_row small_row"><td class="nc_broker_cell"></td><td class="nc_quote_cell calc_ncq_1 ncq_cursor_element"><div></div></td><td class="nc_quote_cell calc_ncq_2 ncq_cursor_element"><div></div></td><td class="nc_quote_cell calc_ncq_3 ncq_cursor_element"><div></div></td></tr><tr class="table_row_nc"><td class="nc_broker_cell"></td><td class="nc_quote_cell ncq_1 ncq_cursor_element"></td><td class="nc_quote_cell ncq_2 ncq_cursor_element"></td><td class="nc_quote_cell ncq_3 ncq_cursor_element"></td></tr><tr class="bet_value_row"><td class="nc_broker_cell"></td><td class="nc_quote_cell ncqc1 ncq_cursor_element"></td><td class="nc_quote_cell ncqc2 ncq_cursor_element"></td><td class="nc_quote_cell ncqc3 ncq_cursor_element"><input type="hidden" value="3" class="ncqc3_input"> &pound;</td></tr></table></div></div></div></div>';

var objEventCurrent;

$(document).ready(function(e) {

	$(".offer-su, .offer-sp, .offer-bog").css('display', 'none');
	if($('.eventTable').length > 0)
	{
			$('#oddsTableContainer').parent('.content').find('h1:first').prepend('<button class="btn-refresh btn btn-info pull-right" onclick="location.reload(false);">Refresh</button>');
	}
	$('.eventTable a.bk3-hover').each(function(index, element) {
       		var fullURL = $(element).attr('href').split('burl=');
			var getClickOne = decodeURIComponent(fullURL[1]);
			$(element).attr('href', getClickOne);
    });
	
	$('.eventTable a.popup').each(function(index, element) {
       		$(element).attr('href', 'javascript:void(0);');
    });
	$('.bk-logo-click').on("click", function(){
		var table = $(this).parents('.eventTable');
		var name = 'a[data-bk="'+$(this).data('bk')+'"]';
		$(table.find(name)[0])[0].click();	
	});
	$('td.bc.bs').each(function(index, element) {
       		$(element).append('<input type="checkbox" class="oddcheck" id="oddcheck_box">');
    });
	$('td.bc.bs').on('click', '.oddcheck', function(){
		if($(this).parents('.eventTable').find('.oddcheck:checked').length > 3)
		{
			return false;
		}
		objEventCurrent = $(this).parents('#oddsTableContainer');
	});
	$('.uncheckodds').on('click', function(){
		var whereObj = $(this).parent().prev('#oddsTableContainer');
		$(whereObj).find('.oddcheck:checked').prop('checked',false);
		var btnParant =  $(this).parent().next('.content');
		btnParant.find('div.iframes').remove();
		btnParant.hide();
		btnParant.removeAttr('style');
	});
	$('.oddcheck').on('click', function(){
		if($(this). prop("checked") != true){
			var whereObj = $(this).parent().parent().parent().parent().parent('#oddsTableContainer');
			var btnParant =  $(whereObj).next().next('.content');
			btnParant.find('div.iframes').remove();
			btnParant.removeAttr('style');
		}
	});
	$('.checkodds').on('click', function(){
		var whereObj = $(this).parent().prev('#oddsTableContainer');
		var btnParant =  $(this).parent().next('.content');
		if($(whereObj).find('.oddcheck:checked').length > 0)
		{
			var i=1;
			var modelContents='';
			$('div.iframes').remove();
			$(whereObj).find('.oddcheck:checked').each(function(index, element) {
				index = $(this).parent().index();
				var obj = $('.eventTableHeader td:eq(' + index + ')').html();
					var bk = $(obj).find('a').data('bk');
				var table = $(this).parents('.eventTable');
				var name = 'a[data-bk="'+bk+'"]';
				var href = $(table.find(name)[0])[0];
				var title = $(this).parents('#oddsTableContainer').prev('h1.heading').clone().children().remove().end().text().split(' v ');
				
				var parentTR = $(this).parents('tr.eventTableRow');
				var iframSource = "<?php echo $base_url.'/loader/betslip.php';?>?bk="+bk+"&mkid="+$(table).data('mid')+"&pid="+$(parentTR).data('bid')+"&cardId=card_34418&bestBookies=,SK,LD,WA,BB,BW,MR,MA";
				
				switch(bk)
				{
				    case 'BF':
				    case 'BB':
				        //window.open(iframSource);
				        var left = (screen.width/2)-(520/2);
                        var top = (screen.height/2)-(300/2);
					var oldWin = window.open(iframSource, bk, 'width=520, height=300, scrollbars=yes, resizable=yes, top=450,left='+left);
					if (window.focus) {oldWin.focus();}
				    break;
				    case 'MA':
				        //window.open(iframSource);
				        var left = (screen.width/2)-(520/2);
                        var top = (screen.height/2)-(300/2);
					var oldWin = window.open(iframSource, bk, 'width=520, height=300, scrollbars=yes, resizable=yes, top=450,left='+left);
					if (window.focus) {oldWin.focus();}
				    break;
					case 'UN':

				        var left = (screen.width/2)-(520/2);
                        var top = (screen.height/2)-(300/2);
				    var oldWin = window.open(iframSource, bk, 'width=520, height=300, scrollbars=yes, resizable=yes, top=450,left='+left);
					if (window.focus) {oldWin.focus();}
				    break;
					case 'BW':

				        var left = (screen.width/2)-(520/2);
                        var top = (screen.height/2)-(300/2);
				    var oldWin = window.open(iframSource, bk, 'width=520, height=300, scrollbars=yes, resizable=yes, top=450,left='+left);
					if (window.focus) {oldWin.focus();}
				    break;
				    case 'WA':
				        $(btnParant).append('<div class="row iframes"><iframe class="'+bk+'_'+i+'" id="myFrame" height="400px" sandbox="allow-forms allow-scripts allow-pointer-lock allow-popups allow-same-origin" src="'+iframSource+'" width="100%" name="myFrame"></div><hr>').hide().fadeIn(5000);
				    break;
				    default:
				        $(btnParant).append('<div class="row iframes"><iframe class="'+bk+'_'+i+'" id="myFrame" height="400px" src="'+iframSource+'" width="100%" name="myFrame"></div><hr>').hide().fadeIn(5000);
				    break;
				}
				i++;
				
			});
			
		}else{
			$('#myModal2').on('show.bs.modal', function (event) {
				  var modal = $(this);
					modal.find('.modal-dialog').addClass('active'); 
					
				});
			$( "#myModal2" ).modal();
		}
	});
	
	$('#packery_base').on('show.bs.modal', function (event) {
		var modal = $(this);
		modal.find('.modal-dialog').addClass('active'); 
	});
    $('#packery_base').on('hidden.bs.modal', function (event) {
		close_nc('calc_standalone_3');
		delete ncObjects['calc_standalone_3'];
		$('#nc_calc_standalone_3').remove();
		standalone_calculator_is_open_3 = false;

		close_nc('calc_standalone_4');
		delete ncObjects['calc_standalone_4'];
		$('#nc_calc_standalone_4').remove();
		standalone_calculator_is_open_4 = false;
	});	
	$('.container-fluid').on('click',function(){
		$("#packery_base").hide();
		$("#packery_base").html('');
		$("#feedback-tab, #feedback-tab1").css("display", "block");
		$("#nc_standalone_template").remove();
		$("#packery_base").css("left", "0%");
				
	});
	$(document).on("click",".close_icon",function(event) {
		event.preventDefault();
        $("#packery_base").hide();
		$("#packery_base").html('');
		$("#feedback-tab, #feedback-tab1").css("display", "block");
		$("#nc_standalone_template").remove();
		$("#feedback").removeAttr("style");
		$("#packery_base").css("left", "0%");
    });
	$("#feedback-tab").on('click', function(){
		$(football).insertAfter( "#packery_base" );
		setTimeout(function(){
		
		}, 1000);

		close_nc('calc_standalone_3');
		delete ncObjects['calc_standalone_3'];
		$('#nc_calc_standalone_3').remove();
		standalone_calculator_is_open_3 = false;
				
		var odd1 = 0;
		var odd2 = 0;
		var odd3 = 0;
		var whereObj = objEventCurrent;
		var i=1;
		$("#feedback").find(".nc_table > tbody > tr > td.logo1").html("");
		$("#feedback").find(".nc_table > tbody > tr > td.logo2").html("");		
		$("#feedback").find(".nc_table > tbody > tr > td.logo3").html("");
		$(whereObj).find('.oddcheck:checked').each(function(index, element) {
			 switch(i)
			 {
				case 1:
					var col = $(this).parent().parent().children().index($(this).parent());
					var logo = $(this).parent().parent().parent().parent().find('thead > .eventTableHeader').find('td').eq(col).attr('data-bk');
					$("#feedback").find(".nc_table > tbody > tr > td.logo1").html("<span class='b0big b"+logo+"0big scrolled' id='"+logo+"_1'></span>");				 	
					odd1 = $(this).parent().data('odig');;
					
				break;
				case 2:
					var col = $(this).parent().parent().children().index($(this).parent());
					var logo = $(this).parent().parent().parent().parent().find('thead > .eventTableHeader').find('td').eq(col).attr('data-bk');
					$("#feedback").find(".nc_table > tbody > tr > td.logo2").html("<span class='b0big b"+logo+"0big scrolled' id='"+logo+"_2'></span>");	
					odd2 = $(this).parent().data('odig');;
					
				 break;
				case 3:
					var col = $(this).parent().parent().children().index($(this).parent());
					var logo = $(this).parent().parent().parent().parent().find('thead > .eventTableHeader').find('td').eq(col).attr('data-bk');
					$("#feedback").find(".nc_table > tbody > tr > td.logo3").html("<span class='b0big b"+logo+"0big scrolled' id='"+logo+"_3'></span>");	
					odd3 = $(this).parent().data('odig');;
					
				 break;
			 	
			 }
			 i++;
		});

		addStandaloneCalculator(3,odd1, odd2, odd3);
		$("#packery_base").css('height', '110%');		
		$("#packery_base").toggle("slide");
		$("#feedback-tab").css("display", "block"); 
		

	});
       $('.IFBet').click(function() { 
		setTimeout(function() {
			$("#feedback-tab1").trigger("click");
		}, 500); 
	});
	
	
	$("#feedback-tab1").on('click', function(){

		$(horse).insertAfter( "#packery_base" );
		setTimeout(function(){
			//do what you need here
		}, 1000);
		close_nc('calc_standalone_4');
		delete ncObjects['calc_standalone_4'];
		$('#nc_calc_standalone_4').remove();
		standalone_calculator_is_open_4 = false;
				
		var odd1 = 0;
		var odd2 = 0;
		var odd3 = 0;
		var whereObj = objEventCurrent;
		var i=1;
		var layName = "";
		$("#feedback").find(".nc_table > tbody > tr > td.logo1").html("");
		$("#feedback").find(".nc_table > tbody > tr > td.logo2").html("");		
		$(whereObj).find('.oddcheck:checked').each(function(index, element) {
			 switch(i)
			 {
				case 1:
					var col = $(this).parent().parent().children().index($(this).parent());
					var logo = $(this).parent().parent().parent().parent().find('thead > .eventTableHeader').find('td').eq(col).attr('data-bk');
					$("#feedback").find(".nc_table > tbody > tr > td.logo1").html("<span class='b0big b"+logo+"0big scrolled' id='"+logo+"_1'></span>");	
					$("#logo1").html("<span class='b0big b"+logo+"0big scrolled' id='"+logo+"_1'></span>");	

					var web_url = $(this).parent().parent().parent().parent().find('thead > .offer-su').find('td').eq(col-1).find('aside').find('a').attr('href');
					$('#linkBookie1').attr('href', web_url);
					
					var bookieName = $(this).parent().parent().parent().parent().find('thead > .eventTableHeader').find('td').eq(col).find('aside').find('a').attr('title');
			 		$(".lblBookieName").text(bookieName);
					$("#linkBookie1").text('Go to ' + bookieName);

					var jockey = $(this).parent().parent().attr('data-bname');
					$(".jockey").text(jockey);
					odd1 = $(this).parent().data('odig');;
					
				break;
				case 2:
					var col = $(this).parent().parent().children().index($(this).parent());
					var logo = $(this).parent().parent().parent().parent().find('thead > .eventTableHeader').find('td').eq(col).attr('data-bk');
					$("#feedback").find(".nc_table > tbody > tr > td.logo2").html("<span  class='b0big b"+logo+"0big scrolled' id='"+logo+"_2'></span>");	
					$("#logo2").html("<span class='b0big b"+logo+"0big scrolled' id='"+logo+"_2'></span>");
					
					var web_url = $(this).parent().parent().parent().parent().find('thead > .offer-su').find('td').eq(col-1).find('aside').find('a').attr('href');
					$('#linkBookie2').attr('href', web_url);
					
					var bookieName = $(this).parent().parent().parent().parent().find('thead > .eventTableHeader').find('td').eq(col).find('aside').find('a').attr('title');
					layName = bookieName;

					$(".lblBookieName1").text(bookieName);
					$("#linkBookie2").text('Go to ' + bookieName);
					odd2 = $(this).parent().data('odig');;
					
				 break;
				case 3:
					var col = $(this).parent().parent().children().index($(this).parent());
					var logo = $(this).parent().parent().parent().parent().find('thead > .eventTableHeader').find('td').eq(col).attr('data-bk');
					$("#feedback").find(".nc_table > tbody > tr > td.logo3").html("<span  class='b0big b"+logo+"0big scrolled' id='"+logo+"_3'></span>");	
					odd3 = $(this).parent().data('odig');;
					
				 break;
				
			 }
			 i++;
		});
		console.log(odd1, odd2, odd3);
		$("#lblBackOdds").text(odd1);
		$("#lblLayOdds").text(odd2);

		addStandaloneCalculator(4,odd1, odd2, odd3);

		$("#packery_base").fadeIn(500);
		$("#packery_base").css('height', '100%');
		$("#feedback-tab").css("display", "block"); 
		$("#feedback").css("top", "5%");
		$("#feedback").css("height", "525px");
 		$("#packery_base").css("left", "110%");
		$("#packery_base").css("width", "100%");
		$("#show_calculator").hide();
		$('#txtBookieStake1').val(100);
		var lay_comm = {BETFAIR:5.00, BETDAQ:5.00, SMARKETS:2.00, MATCHBOOK:1.00};
		if(typeof lay_comm[layName.toUpperCase()] !== 'undefined')
			$('#txtLayComm').val(lay_comm[layName.toUpperCase()]);
		else{
			$('#txtBookieComm').val(1);		
			$('#txtLayComm').val(1.15);
		}
		$("#packery_base").draggable();
		$("#event_date_time").html(event_date_time);
		$("#event1").html(event1);
	});
	
	$(document).on("click","#btn_show_calculator", function(event) {
		event.preventDefault();
		var ncqc_input = document.getElementById('txtBookieStake1');
		updateNCalculatorBetValue(ncqc_input, ncqc_input.value, 1);
		$(this).attr("id", "btn_hide_calculator");
		$("#packery_base").css("left", "20%");
		$("#show_calculator").show(500);
		$(this).html("Hide calculator <<");
		$("#closehide").hide();
			custom_fun();
		setTimeout(function(){
			$("#packery_base").css("width", "88%");		
		}, 500);
		
	});

	$(document).on("click","#btn_hide_calculator", function(event) {
		event.preventDefault();
		$(this).attr("id", "btn_show_calculator");
		$("#show_calculator").hide(500);
		$(this).html("Show calculator >>");
		setTimeout(function(){
			$("#packery_base").css("left", "110%");		
		}, 300);
		$("#packery_base").css("width", "100%");
		$("#closehide").show();
	});

	$(document).on("keyup","#txtBookieStake1, #txtBookieStake2, #txtBookieOdds1, #txtBookieOdds2, #txtLayComm, #txtBookieComm", function(event) {
		event.preventDefault();
		var ncqc_input = document.getElementById('txtBookieStake1');
		updateNCalculatorBetValue(ncqc_input, ncqc_input.value, 1);
		custom_fun();
		
	});
	

	$(document).on("click",".scrolled",function(event) {
		event.preventDefault();
		var whereObj = objEventCurrent;
		var iframe_class = $(this).attr('id');
		var a= $(whereObj).next().next();
				
		if(typeof a.attr('style') == "undefined")
		{
			var btn = $(whereObj).next().find('.checkodds');
			setTimeout(function () {
			   btn.trigger('click');
			}, 500);
		}
		setTimeout(function(){
			$('html,body').animate({
		    	scrollTop: $("iframe."+iframe_class).offset().top},
		    'slow');
		}, 500);
		
    });
	
	$(document).on("click",".betnow",function(event) {
		event.preventDefault();
		var whereObj = objEventCurrent;
		var a= $(whereObj).next().next();
		var btn = $(whereObj).next().find('.checkodds');
		setTimeout(function () {
		   btn.trigger('click');
		}, 500);
		
    });
	$(document).on("click",".clearbets",function(event) {
		event.preventDefault();
		var whereObj = objEventCurrent;
		var a= $(whereObj).next().next();
		var btn = $(whereObj).next().find('.uncheckodds');
		setTimeout(function () {
		   btn.trigger('click');
		}, 500);
		a.removeAttr('style');
		
    });
	
});
</script>