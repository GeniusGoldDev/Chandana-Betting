<script language="javascript">
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
       		$(element).append('<input type="checkbox" class="oddcheck">');
    });
	$('td.bc.bs').on('click', '.oddcheck', function(){
		if($(this).parents('.eventTable').find('.oddcheck:checked').length > 2)
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
				    case 'MA':
				    case 'BB':
				        //window.open(iframSource);
				        var left = (screen.width/2)-(520/2);
                        var top = (screen.height/2)-(300/2);
				    window.open(iframSource, bk, 'width=520,height=300,scrollbars=yes,resizable=yes,top=450, left='+left);
				    break;
				    case 'MF':
				        //window.open(iframSource);
				        var left = (screen.width/2)-(520/2);
                        var top = (screen.height/2)-(300/2);
				    window.open(iframSource, bk, 'width=520,height=300,scrollbars=yes,resizable=yes,top=450, left='+left);
				    break;
					case 'RB':
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
		//alert(this.getAttribute("sbetid"));
		close_nc('calc_standalone_4');
		//var t = document.getElementById("nc_" + id);
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
		$("#feedback").removeAttr("style");
    });
	$("#feedback-tab").on('click', function(){
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
		$("#feedback-tab").css("display", "none"); 
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
			$('#txtLayComm').val(1.15);
			$('#txtBookieComm').val(1);		
		}

		$("#packery_base").draggable();
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

	$(document).on("keyup","#txtBookieStake1, #txtBookieStake2, #txtBookieOdds1, #txtBookieOdds2, #txtLayComm, #txtBookieComm",function(event) {
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
		console.log(whereObj);
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
<div></div><div></div>
<?php
// USAGE
include "Includes/config.php";
include "Classess/Crawler.php";
$uri = isset($_GET['q'])?$_GET['q']:'';
$uri_array = explode( "/", $uri );

$url = $tmp_odds_url = (count($uri_array) > 1) ? $odds_url.$_GET['q'] : $odds_url."horse-racing";
	if(count($uri_array)>1)
	{
		$pos = 	strrpos($uri_array[1], '-');
		$event = substr($uri_array[1], ++$pos);		
		$date = substr($uri_array[1], 0, --$pos);	
		?>
		<h1 class="heading"><?php echo $event .' '. $date . ' ' . $uri_array[2] . ' ' . $uri_array[3] ?> Betting Odds</h1>
		<div id="oddsTableContainer">
		<?php
		echo get_horse_racing($url);
		?>
			<div class="col-md-4 col-md-offset-8 divCheckWrapper pull-right">
				<button class="checkodds btn btn-info">BET NOW</button>
				<button class="uncheckodds btn btn-info">CLEAR BETS</button>
			</div>
			<div class="content"></div>	

		<?php
	}
	else
	{	 
		$raceArr = get_horse_url_collection($url);
		
		foreach($raceArr as $dayKey => $dayValue)	
		{
		?>
		<h1 class="heading">Horse Racing Betting</h1>
		<div class="container">
			<section>
				<div class="module show-times">
					<header>
						<h2><?php echo $dayKey;?></h2>
					</header>
					<div class="race-meets-container">
						<div class="race-meets">
						<?php foreach($dayValue as $venueKey => $venueValue){ ?>
							<div class="race-details">
								<div class="venue-details">
									<p><a class="venue"><?php echo $venueKey ?></a></p>
								</div>
								<div class="all-todays-races">
								<?php foreach($venueValue as $timeKey => $timeValue){ ?>
									<div class="racing-time">
										<a style="padding:0px;margin:4px 0 0 0;" target="_blank" class="<?php echo $timeValue['class'] ?>" data-time="<?php echo $timeValue['data-time'] ?>"  href="<?php echo substr($timeValue['link'], 1) ?>" title="<?php echo $timeValue['title'] ?>">
										<?php echo $timeKey ?></a>
									</div>
								<?php } ?>
								</div>
							</div>
						<?php } ?>
							
						</div>
					</div>
				</div>
			</section>
		</div>
		<?php	
		}
	}
?>
