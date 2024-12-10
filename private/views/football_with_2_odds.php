<?php
// USAGE
include "Includes/config.php";
include "Classess/Crawler.php";
$uri = isset($_GET['q'])?$_GET['q']:'';
$uri_array = explode( "/", $uri );
$url = $tmp_odds_url = (count($uri_array) > 1) ? $odds_url.$_GET['q'] : $odds_url."football";
?>
<script language="javascript">
var objEventCurrent;
$(document).ready(function(e) {
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
       		$(element).append('<input type="checkbox" class="oddcheck">');
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
				        //window.open(iframSource);
				        var left = (screen.width/2)-(520/2);
                        var top = (screen.height/2)-(300/2);
				    window.open(iframSource, bk, 'width=520,height=300,scrollbars=yes,resizable=yes,top=450, left='+left);
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
		$("#feedback-tab").css("display", "block");
				
	});
	$(document).on("click",".close_icon",function(event) {
		event.preventDefault();
        $("#packery_base").hide();
		$("#feedback-tab").css("display", "block");

    });
	$("#feedback-tab").on('click', function(){
		$("#nc_calc_standalone_4").css("display", "none");
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
		$("#packery_base").toggle("slide");
		$("#feedback-tab").css("display", "none"); 
		
	});
	$(document).on("click","#two_odds_cal",function(event) {
	// $("#two_odds_cal").on('click', function(){
		event.preventDefault();
		alert("Open");
		$("#packery_base").hide();
		$("#feedback-tab").css("display", "block");
		$("#nc_calc_standalone_3").css("display", "none");
		close_nc('calc_standalone_4');
		delete ncObjects['calc_standalone_4'];
		$('#nc_calc_standalone_4').remove();
		standalone_calculator_is_open_4 = false;
				
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

		addStandaloneCalculator(4,odd1, odd2, odd3);
		alert("Close");
		$("#packery_base").toggle("slide");
		$("#feedback-tab").css("display", "none"); 
		
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
		}, 1000);
	});

	
});
</script>
	<nav class="navbar navbar-default">
  		<div class="container-fluid">
    		<ul class="nav navbar-nav">
			  	<li <?php echo (in_array('football-coupons', $uri_array)) ? 'class="active"' : '' ?>><a href="<?php echo $base_url ?>/football/football-coupons/major-leagues-cups">Today Matches</a></li>
				<li <?php echo in_array('premier-league', $uri_array) ? 'class="active"' : '' ?>><a href="<?php echo $base_url ?>/football/english/premier-league">Premier League</a></li>
				<li <?php echo in_array('championship', $uri_array) ? 'class="active"' : '' ?>><a href="<?php echo $base_url ?>/football/english/championship">Championship</a></li>
			  	<li <?php echo in_array('league-1', $uri_array) ? 'class="active"' : '' ?>><a href="<?php echo $base_url ?>/football/english/league-1">League 1</a></li> 
			  	<li <?php echo in_array('league-2', $uri_array) ? 'class="active"' : '' ?>><a href="<?php echo $base_url ?>/football/english/league-2">League 2</a></li> 
			  	<li <?php echo in_array('league-cup', $uri_array) ? 'class="active"' : '' ?>><a href="<?php echo $base_url ?>/football/english/league-cup">League Cup</a></li> 
			</ul>
		</div>
	</nav>
<?php 
$url_collection = get_url_collection($url);
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
			<h1 class="heading"><?php echo $result[$i]['title'] ?> <small><?php echo $result[$i]['date_time'] ?></small></h1>
			<div id="oddsTableContainer">
			<?php 
			if(!empty($result[$i]['data']))
			{ ?>
				<?php echo $result[$i]['data'];?>
				<div class="col-md-4 col-md-offset-8 divCheckWrapper pull-right">
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