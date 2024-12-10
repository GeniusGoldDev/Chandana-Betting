<?php
if(!isset($date) || empty($date))
{
	$date = date('d/m/Y');
}else{
	$date = date('d/m/Y', strtotime($date));
}
 ?>
<div id="feedback">
	<div id="packery_base" style='left:20%;display:none;height:0px;background-color:#000032;' class="packery col-xs-4 col-md-4 panel panel-default"></div>
	<div class="item w4 h4 nc_main_element" id="nc_standalone_template" style="display: none;width:100%;">
		
		<div style="float:left;">
			<h1 style="color:#fff";>Match Information</h1>
			<div class="deactivation_icon" id="closehide"><a class="close_icon" href="#" style="margin-top:-35px;">X</a></div>
			<div class="eventInfoBox">
			<table class="match_info">
				<tbody>
					<tr><td><img src="<?php echo $base_url;?>/img/calculator/date.png"></td><th>Date / Time</th><td><?php echo $date . ' ' .  $uri_array[2]; ?></td></tr>
					<tr><td><img src="<?php echo $base_url;?>/img/calculator/1.png"></td><th>Event</th><td><?php echo ucfirst($event). ' '. $uri_array[2]; ?></td></tr>
					<tr><td><img src="<?php echo $base_url;?>/img/calculator/table.jpg"></td><th>Market</th><td><?php echo ucfirst($uri_array[3]); ?></td></tr>
				</body>
			</table>
			</div>
			<div class="backLayWrapper">
                <div class="backDetails">
                    <div class="backTitle">
                        BACK
                    </div>
                    <div class="backOutcome">
                        <span id="lblOutcome1" class="jockey"></span>
                    </div>
                    <div class="backOdds">
                        <span id="lblBackOdds"></span>
                    </div>
                    <div class="backLiquidity">
                        &nbsp;
                    </div>
                    <div class="backLastUpdate">
                        <!--span id="lblBackLastUpdated">Comingsoon mins ago</span-->
                    </div>
                </div>
                <div class="layDetails">
                    <div class="layTitle">
                        LAY
                    </div>
                    <div class="layOutcome">
                         <span id="lblOutcome2" class="jockey"></span>
                    </div>
                    <div class="layOdds">
                        <span id="lblLayOdds"></span>
                    </div>
                    <div class="backLiquidity">
                          &nbsp;
                    </div>
                    <div class="layLastUpdate"> 
						 <!--span id="lblLayLastUpdated">Comingsoon mins ago</span-->
                    </div>
                </div>
				<div class="backBookieDetails">
                    <div class="backBookieTitle" id='logo1'>
                        
                    </div>
					
                    <div class="backBookieTitle bookieLink">
                        <img id="imgBookieDirect" title="This is a direct link straight to the correct market" class="directLink" src="<?php echo $base_url;?>/img/calculator/directlink.png">
                        <a id="linkBookie1" target="_blank"></a>
                    </div>
                </div>
				<div class="backBookieDetails1">
                    <div class="backBookieTitle" id='logo2'>
                        
                    </div>
					
                    <div class="backBookieTitle bookieLink">
                        <img id="imgBookieDirect" title="This is a direct link straight to the correct market" class="directLink" src="<?php echo $base_url;?>/img/calculator/directlink.png">
                        <a id="linkBookie2"  target="_blank"></a>
                    </div>
                </div>
				<div style="width:100%;">
					<button class="betnow btn btn-info">BET NOW</button>
					<button class="clearbets btn btn-info">CLEAR BETS</button>
					<button id="btn_show_calculator" style="float:right;margin-right:0%;">Show Calculator >></button>
				</div>
            </div>
			
		</div>					
		<div class="new_calc standalone_nc show1" id="show_calculator" style="padding:0px;">
			<div>				
				<div class="nc_header_text">CALCULATOR</div>
				<div class="deactivation_icon"><a class="close_icon" href="#" style="margin-top:-35px;">X</a></div>
					<div class="bookmaker">
				        <table class="bookmakerTable" cellpadding="0" cellspacing="0">
				            <tbody>
								<tr>
						            <td class="bookmakerInfoCol">
						                <img id="Image2" title="Enter the amount that you intend to bet at the bookmaker<br /><br />This will be the amount of the FREE BET or the QUALIFYING BET" src="<?php echo $base_url;?>/img/calculator/information.png">
						            </td>
						            <td class="bookmakerLeftCol">
						                <span class="yellow"><span id="lblBookieName1" class="lblBookieName"></span>
						                <span>STAKE</span></span>
						            </td>
						            <td class="bookmakerRightCol">
						               <span id="txtBookieStake_wrapper" class="riSingle RadInput RadInput_Default" style="width:70px;">
	<input id="txtBookieStake1" name="txtBookieStake" class="ncqc1_input riTextBox riEnabled" value="" type="text"></span> £
						            </td>
						        </tr>
						        <tr>
						            <td class="bookmakerInfoCol">
						                <img id="imgInfo1" title="This shows the odds that you will back at the Boookmaker<br /><br />This field is automatically filled in with the match you found but you can amend if the bookmaker's odds have changed" src="<?php echo $base_url;?>/img/calculator/information.png"> 
						            </td>
						            <td class="bookmakerLeftCol">
						                <span id="lblBookieName"  class="lblBookieName"></span>
						                ODDS
						            </td>
						            <td class="bookmakerRightCol">
						                <span id="txtBookieOdds_wrapper" class="riSingle RadInput RadInput_Default" style="width:70px;">
	<input id="txtBookieOdds1" name="txtBookieOdds" class="ncqc1_input_odd riTextBox riEnabled" value="" type="text" style="text-align: center;width:70%;margin-right:10%;"></span>
						            </td>
						        </tr>
								<tr>
						            <td class="bookmakerInfoCol">
						                <img id="Image2" title="Enter the amount that you intend to bet at the bookmaker<br /><br />This will be the amount of the FREE BET or the QUALIFYING BET" src="<?php echo $base_url;?>/img/calculator/information.png">
						            </td>
						            <td class="bookmakerLeftCol">
						                <span id="lblBookieName" class="lblBookieName"></span>
						                COMMISSION
						            </td>
						            <td class="bookmakerRightCol">
						                <span id="txtBookieOdds_wrapper" class="riSingle RadInput RadInput_Default" style="width:70px;">
	<input id="txtBookieComm" name="txtBookieComm" class="riTextBox riEnabled" value="0" type="text" style="text-align: center;width:70%;margin-left: 5%;"></span> %
						            </td>
						        </tr>
				        </tbody>
					</table>
				    </div>
					<div class="bookmaker">
				        <table class="bookmakerTable" cellpadding="0" cellspacing="0">
				            <tbody>
								<tr>
						            <td class="bookmakerInfoCol">
						                <input id="txtBookieStake2" name="txtBookieStake" class="ncqc2_input riTextBox riEnabled" value="0" type="hidden" style="text-align: center;width:70%;">
						            </td>
						        </tr>
						        <tr>
						            <td class="bookmakerInfoCol">
						                <img id="Image2" title="Enter the amount that you intend to bet at the bookmaker<br /><br />This will be the amount of the FREE BET or the QUALIFYING BET" src="<?php echo $base_url;?>/img/calculator/information.png">
						            </td>
						            <td class="bookmakerLeftCol">
						                <span id="lblBookieName" class="lblBookieName1"></span>
						                ODDS
						            </td>
						            <td class="bookmakerRightCol">
						                <span id="txtBookieOdds_wrapper" class="riSingle RadInput RadInput_Default" style="width:70px;">
	<input id="txtBookieOdds2" name="txtBookieOdds" class="ncqc2_input_odd riTextBox riEnabled" value="0" type="text" style="text-align: center;width:70%;margin-right:10%;"></span>
						            </td>
						        </tr>
								<tr>
						            <td class="bookmakerInfoCol">
						                <img id="Image2" title="Enter the amount that you intend to bet at the bookmaker<br /><br />This will be the amount of the FREE BET or the QUALIFYING BET" src="<?php echo $base_url;?>/img/calculator/information.png">
						            </td>
						            <td class="bookmakerLeftCol">
						                <span id="lblBookieName" class="lblBookieName1"></span>
						                COMMISSION
						            </td>
						            <td class="bookmakerRightCol">
						                <span id="txtBookieOdds_wrapper" class="riSingle RadInput RadInput_Default" style="width:70px;">
	<input id="txtLayComm" name="txtLayComm" class="riTextBox riEnabled" value="0" type="text" style="text-align: center;width:70%;margin-left: 5%;"></span> %
						            </td>
						        </tr>
				        </tbody>
					</table>
				    </div>
					<div class="bookmaker_results">
                        <a id="lnkBookie" class="bookieResultLink" href="#" target="_blank">Go to Betfred</a> <br>
                        Bet <span id="lblSimpleStake" class="lay"></span> at odds of <span id="lblSimpleBackOdds" class="lay"></span>
                    </div>
					<div class="exchange_results">
                       <a id="lnkExchange" class="exchangeResultLink" href="#" target="_blank">Go to Smarkets</a><br>
                        Lay <span id="lblSimple_layAmount" class="lay"></span> at odds of <span id="lblSimple_layOdds" class="lay"></span>
                        <br>
                        <span class="liability_text">your liability will be <span id="lblSimple_liability" class="liability">Comingsoon</span></span>
                    </div>
					<div class="overall_results overall_results_simple">
                         <div class="hidden">
 							If the Bookmaker Bet wins your position will be
                            <span id="lblSimple_BookieWin" class="profit">£0.20</span><br>
                            <br>
                            If the Exchange Lay wins your position will be
                            <span id="lblSimple_BookieLose" class="profit">£0.19</span><br>
                         </div>
                         Your profit will be <span id="lblSimple_Profit" class="profit middle"></span> 
                   </div>
					<div class="overall_results">                      
                            <table style="margin:10px auto 10px auto;" cellpadding="0" cellspacing="0">
                                <tbody><tr>
                                    <td style="text-align:left;"><i></i></td>
                                    <td style="padding-right:10px;padding-left:10px;">Bookmaker</td>
                                    <td style="padding-right:10px;padding-left:10px;">Exchange</td>
                                    <td></td>
                                    <td style="padding-right:10px;padding-left:10px;">Total</td>
                                </tr>
                                 <tr>
                                    <td style="border-bottom:1px solid darkgrey; text-align:left; background-color: #D7ECFA;padding:7px;">IF BOOKMAKER (BACK) BET WINS</td>
                                    <td style="border-bottom:1px solid darkgrey; font-weight:300 !important;">
                                        <span id="lblBackWin_Bookie_Profit" class="profit"></span>
                                    </td>
                                    <td style="border-bottom:1px solid darkgrey;">
                                        <span id="lblBackWin_Exchange_Profit" class="loss">-£3.44</span>
                                    </td>
                                    <td style="border-bottom:1px solid darkgrey;">=</td>
                                    <td style="border-bottom:1px solid darkgrey;"><strong><span id="lblBackWin_Profit" class="profit"></span></strong></td>
                                </tr>
                                <tr style="">
                                    <td style="text-align:left;background-color: #FDDEE5;padding: 5px;">IF EXCHANGE (LAY) BET WINS</td>
                                    <td> <span id="lblLayWin_Bookie_Profit" class="loss"></span></td>
                                    <td>
                                        <span id="lblLayWin_Exchange_Profit" class="profit">+£14.05</span></td>
                                    <td>=</td>
                                    <td><strong><span id="lblLayWin_Profit" class="profit">£0.05</span></strong></td>
                                </tr>
                            </tbody>
						</table>                         
                    </div>
					<div class="new_calc_league_bet_infos">
						<div>
							<div class="new_calc_league_bet_risk_text ncl_btext valuediv">
								<input type="hidden" size="5" value="100" class="risk_input" onfocus="this.value = this.value;">
								<img class="left hide" src="<?php echo $base_url;?>/img/icons_2/edit.png">
							</div>
							<div class="new_calc_league_bet_profit_text ncl_btext valuediv">
								<span class="middle" style="display:none;"></span> 
							</div>
							<div class="new_calc_league_bet_win_text ncl_btext valuediv">
								<input type="hidden" size="5" value="100" class="win_input">
								<img class="right hide" src="<?php echo $base_url;?>/img/icons_2/edit.png">
							</div>
						</div>
					</div>
					<div class="nc_table_container">
						<table class="nc_table">
							<tr class="table_row_nc title_row small_row">
								<td class="nc_broker_cell"></td>
								<td class="nc_quote_cell calc_ncq_1 ncq_cursor_element"><div></div></td>
								<td class="nc_quote_cell calc_ncq_2 ncq_cursor_element"><div></div></td>
								<td class="nc_quote_cell calc_ncq_3 ncq_cursor_element"><div></div></td>
							</tr>
							<!--tr>
								<td></td><td class="logo1"></td><td class="logo2"></td><td class="logo3"></td>
							</tr-->
							<tr class="table_row_nc">
								<td class="nc_broker_cell"></td>
								<td class="nc_quote_cell ncq_1 ncq_cursor_element">
									<!--input value="Err" class="ncqc1_input_odd"-->
								</td>
								<td class="nc_quote_cell ncq_2 ncq_cursor_element">
									<!--input value="Err" class="ncqc2_input_odd"-->
								</td>
								<td class="nc_quote_cell ncq_3 ncq_cursor_element">
									<!--input value="Err" class="ncqc3_input_odd"-->
								</td>
							</tr>
							<tr class="bet_value_row">
								<td class="nc_broker_cell"></td>
								<td class="nc_quote_cell ncqc1 ncq_cursor_element">
									<!--input value="1" class="ncqc1_input"> &pound;-->
								</td>
								<td class="nc_quote_cell ncqc2 ncq_cursor_element">
									<!--input value="2" class="ncqc2_input"> &pound;-->
								</td>
								<td class="nc_quote_cell ncqc3 ncq_cursor_element">
									<input type="hidden" value="3" class="ncqc3_input"> &pound;
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div id="feedback-tab">CALCULATOR</div>
	</div>
