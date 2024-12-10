<!doctype html>
<html>
<head>
<meta charset="utf-8">
<!--<meta name="viewport" content="width=device-width,initial-scale=1">-->
<meta name="viewport" content="width=1165, user-scalable=no">
<title>One Click Odds</title>
<link rel="shortcut icon" href="<?php echo $base_url ?>/img/fav.png" />
<link href="<?php echo $base_url ?>/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $base_url ?>/css/style.css" rel="stylesheet">
<link href="<?php echo $base_url ?>/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo $base_url ?>/css/testcss.css" rel="stylesheet">
<link href="<?php echo $base_url ?>/css/viewer_styles.css" rel="stylesheet">
<link href="<?php echo $base_url ?>/css/calculator.css" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
.allOddsBestOffersInfo a, .allOddsSortHeader .aOSHC {display: none;}
h1.heading {text-transform: capitalize;padding: 10px !important;clear: both;}
.message-area .icon {top: auto;left: auto;}
.details-left {text-transform: capitalize;}
.row.iframes { margin: 20px auto;padding-bottom: 20px;border-bottom: 5px solid #DDD;}
.content .content {display:none;background-color: #EBEEF0 !important;}
.divCheckWrapper {text-align: right;}
.btn-refresh {margin-right: 5px;}
header h2{color: #ffffff;}
.show-times .venue-details a.venue{color:#ffffff}; 
.scrolled{cursor: pointer;}
#oddsTableContainer .eventTable tbody tr td{z-index:2;position:relative;}
.eventTableHeader a {pointer-events: none;cursor: default;}
.nav li{border-right: 5px solid #000;}
.nav li:first-child {border-left: 5px solid #000;}
</style>
<script src="<?php echo $base_url ?>/jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="<?php echo $base_url ?>/jQueryAssets/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo $base_url ?>/jQueryAssets/packery.pkgd.min.js" type="text/javascript"></script>
<script src="<?php echo $base_url ?>/jQueryAssets/draggabilly.pkgd.min.js" type="text/javascript"></script>
<script src="<?php echo $base_url ?>/jQueryAssets/utils.js" type="text/javascript"></script>
<script src="<?php echo $base_url ?>/jQueryAssets/locoti.js" type="text/javascript"></script>
<!--script src="<?php echo $base_url ?>/jQueryAssets/locoti1.js" type="text/javascript"></script-->
<script src="<?php echo $base_url ?>/jQueryAssets/locoti.min.js" type="text/javascript"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
dg = new Array();
dg[0]=new Image();dg[0].src="<?php echo $base_url ?>/img/clock/dg0.png";
dg[1]=new Image();dg[1].src="<?php echo $base_url ?>/img/clock/dg1.png";
dg[2]=new Image();dg[2].src="<?php echo $base_url ?>/img/clock/dg2.png";
dg[3]=new Image();dg[3].src="<?php echo $base_url ?>/img/clock/dg3.png";
dg[4]=new Image();dg[4].src="<?php echo $base_url ?>/img/clock/dg4.png";
dg[5]=new Image();dg[5].src="<?php echo $base_url ?>/img/clock/dg5.png";
dg[6]=new Image();dg[6].src="<?php echo $base_url ?>/img/clock/dg6.png";
dg[7]=new Image();dg[7].src="<?php echo $base_url ?>/img/clock/dg7.png";
dg[8]=new Image();dg[8].src="<?php echo $base_url ?>/img/clock/dg8.png";
dg[9]=new Image();dg[9].src="<?php echo $base_url ?>/img/clock/dg9.png";

function dotime(){ 
	var offset = '0';
	var nd=new Date();
	var utc = nd.getTime() + (nd.getTimezoneOffset() * 60000);
	var d = new Date(utc + (3600000*offset));
	var hr=d.getHours(),mn=d.getMinutes(),se=d.getSeconds();
	
	document.hr1.src = getSrc(hr,10);
	document.hr2.src = getSrc(hr,1);
	document.mn1.src = getSrc(mn,10);
	document.mn2.src = getSrc(mn,1);
	document.se1.src = getSrc(se,10);
	document.se2.src = getSrc(se,1);
}

function getSrc(digit,index){
	return dg[(Math.floor(digit/index)%10)].src;
}

window.onload=function(){
	var nextTime = new Array();
	var i = 0;
	var offset = '+1';
	var nd=new Date();
	var utc = nd.getTime() + (nd.getTimezoneOffset() * 60000);
	var currentTime = new Date(utc + (3600000*offset)).getTime();

	$('a.race-time').each(function(index, element) {
		var matchTime = new Date($(element).attr('data-time')).getTime();
		
		if(matchTime < currentTime)
		{
			$(element).removeAttr('class');
			$(element).attr('class', 'race-time time results');
		}
		else
		{
			nextTime[i] = matchTime;
			i++;
		}
	});
	nextTime.sort();
	$('a.race-time').each(function(index, element) {
		var matchTime = new Date($(element).attr('data-time')).getTime();
		if(matchTime == nextTime[0])
		{
			$(element).removeAttr('class');
			$(element).attr('class', 'race-time time next-event pulse');
		}
	});
	dotime();
	setInterval(dotime,1000);
}
</script>
<link rel="stylesheet" type="text/css" href="http://static.oddschecker.com/OC/css/compiled/OC/odds/all_odds.css?v=1.0.31">
<link rel="stylesheet" type="text/css" href="http://static.oddschecker.com/OC/css/compiled/OC/beta.css?v=1.0.31">
<style>.allOddsBestOffers{display:none;} .racingEventTableFooter #footer-right{display:none;}</style>
</head>
<body>
<div id="myModal2" class="modal fade" role="dialog">
  <div class="modal-dialog"> 
    
    <!-- Modal content-->
    <div id="single-bet-slip-controller" class="modal-dialog-inner">
      <div class="social-row ng-isolate-scope" bet-type="Single">
        <div class="social ng-scope"></div>
      </div>
      <div class="content-wrapper">
        <h2><p class="alert alert-danger ">ERROR</p></h2>
        <span title="Close" class="inside-close-button close" data-dismiss="modal">×</span>
        <div class="message-area information"><span class="icon"></span>
          <div class="info">
            <div class="info-message">Please select atleast one!!!</div>
          </div>
        </div>
        <p></p>
      </div>
    </div>
  </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog"> 
    
    <!-- Modal content-->
    <div id="single-bet-slip-controller" class="modal-dialog-inner">
      <div class="social-row ng-isolate-scope" bet-type="Single">
        <div class="social ng-scope"></div>
      </div>
      <div class="content-wrapper">
        <h2><span class="head-text">Betslip</span></h2>
        <span title="Close" class="inside-close-button close" data-dismiss="modal">×</span>
        <div class="message-area information"><span class="icon"></span>
          <div class="info">
            <div class="info-message">You cannot bet with this bookmaker directly on OneClickOdds. Click 'bet on bookmaker website'</div>
          </div>
        </div>
        <p></p>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid">
<div class="row bg_c">
  <div class="col-md-12">
    <div class="head_w">
      <table cellpadding="0px" cellspacing="0px">
        <tbody>
          <tr>
            <td><a href="./" class="logo" target="_top" title="Betfair Home" data-gtml="betfair logo" data-gac="Header"></a></td>
            <td><div class="space">
                <div class="sp"></div>
                <div class="sp2"></div>
              </div></td>
            <td class="ls"></td>
            <td class="pdt10"><div class="sp"> </div></td>
            <td><div class="bx1">
                <?php /*<div class="lan">
                                    	<span class="l1"></span>
                                        <span class="l2"></span>
                                    </div>
									*/?>
              </div></td>
          </tr>
        </tbody>
      </table>
    </div>
    <!--head_w ends--> 
  </div>
  <!--col-md-12 ends--> 
</div>
<!--row1 ends-->

<div class="row bg_nav">
  <div class="col-md-12">
    <div class="nav navbar-default sprt_m">
      <div id="">
        <ul>
          <li> <a href="<?php echo $base_url;?>/football" onclick=""><span class="sport-name">Football</span> <span class="i_w nav_bg1 ico"></span></a> </li>
          <li> <a  href="<?php echo $base_url;?>/horse-racing" onclick=""><span class="sport-name">Horse Racing</span> <span class="i_w nav_bg2 ico"></span></a> </li>
          <li> <a href="<?php echo $base_url;?>/tennis1" onclick=""><span class="sport-name">Tennis</span> <span class="i_w nav_bg3 ico"></span></a> </li>
          <li> <a href="<?php echo $base_url;?>/golf" onclick=""><span class="sport-name">Golf</span> <span class="i_w nav_bg5 ico"></span></a> </li>
          <li> <a href="<?php echo $base_url;?>/cycling" onclick=""><span class="sport-name">Cycling</span> <span class="i_w nav_bg6 ico"></span></a> </li>
          <li> <a href="<?php echo $base_url;?>/politics" onclick=""><span class="sport-name">Politics</span> <span class="i_w nav_bg7 ico"></span></a> </li>
          <li> <a href="<?php echo $base_url;?>/FINDIT1" onclick=""><span class="sport-name">Find It1</span> <span class="i_w nav_bg8 ico"></span></a> </li>
          <li> <a href="<?php echo $base_url;?>/find" onclick=""><span class="sport-name">Find It2</span> <span class="i_w nav_bg8 ico"></span></a> </li>
          <li> <a href="<?php echo $base_url;?>/feeds" onclick=""><span class="sport-name">Feeds</span> <span class="i_w nav_bg8 ico"></span></a> </li>
          <li> <a href="<?php echo $base_url;?>/betfair" onclick=""><span class="sport-name">Betfair</span> <span class="i_w nav_bg8 ico"></span></a> </li>
          <li> <a href="<?php echo $base_url;?>/matchbook" onclick=""><span class="sport-name">Matchbook</span> <span class="i_w nav_bg8 ico"></span></a> </li>
        </ul>
        <!--UL ends--> 
      </div>
	  <!-- ends--> 
    </div>
	<div class="pull-right" style="margin-top:-40px;">
			<img src="<?php echo $base_url ?>/img/clock/dg8.png" name="hr1">
	 		<img src="<?php echo $base_url ?>/img/clock/dg8.png" name="hr2">
			<img src="<?php echo $base_url ?>/img/clock/dgc.png">
			<img src="<?php echo $base_url ?>/img/clock/dg8.png" name="mn1">
			<img src="<?php echo $base_url ?>/img/clock/dg8.png" name="mn2">
			<img src="<?php echo $base_url ?>/img/clock/dgc.png">
			<img src="<?php echo $base_url ?>/img/clock/dg8.png" name="se1">
			<img src="<?php echo $base_url ?>/img/clock/dg8.png" name="se2">
		</div>	
    <!--nav ends--> 
  </div>
  <!--col-md-12 ends--> 
</div>
<!--row2 ends--> 

