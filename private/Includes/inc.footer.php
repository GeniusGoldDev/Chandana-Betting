<div class="row bgw pszin" style="background-color:#0B1422;">
        	<div class="col-md-12 col-sm-12 col-xs-12">
            	<div class="row bgb">
                	<div class="col-md-12 col-sm-12 col-xs-12">
                    	<div class="footer">
                        	<a class="logoo" href="#"><img src="<?php echo $base_url ?>/img/ssc-banners-sprite-ed78c6351e2c26a8d4394e299cf073c8.png" class="img-responsive"></a>
                            <span class="rg-text">Please Gamble Responsibly</span>
                            <a href="#" class="details" data-gtml="Responsible Gambling Details" target="_blank">More details</a>
                        </div>
                        <!--footer ends-->
                    </div>
                    <!--col-md-12 ends-->
                </div>
                <!--row1 ends-->
                <div class="row">
                	<div class="col-md-12">
                    	<div class="fcc">
                        	<a href="./" class="btfc" target="_top" title="Betfair Home" data-gtml="betfairHome"></a>
                            <sup><span class="ssc-ftpl" tabindex="0" data-tooltip="ssc-tr-2">© ®</span></sup>
                        </div>
                        <!--fcc ends-->
                        
                    </div>
                    <!--col-md-12 ends-->
                </div>
                <!--row2 ends-->
            </div>
            <!--col-md-12 ends-->
        </div>
</div>
<!-- Calculator start -->
<?php if(in_array('football', $uri_array)){
include "Includes/football.calculator.php";
} ?>
<?php if(in_array('FINDIT1', $uri_array)){
include "Includes/football.calculator.php";
} ?>
<?php if(in_array('search_result', $uri_array)){
include "Includes/football.calculator.php";
} ?>
<?php if(in_array('horse-racing', $uri_array) && count($uri_array) > 1){
	include "Includes/horse.calculator.php";
} ?>
 
<!-- Calculator end -->
</body>
</html>
