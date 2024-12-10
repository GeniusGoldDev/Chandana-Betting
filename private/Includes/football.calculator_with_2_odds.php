<div id="feedback">
	<div id="packery_base" style='display:none;height:0px;background-color:#000032;' class="packery col-xs-4 col-md-4 panel panel-default"></div>
	<div class="item w4 h4 nc_main_element" id="nc_standalone_template" style="display: none">
			<div class="new_calc standalone_nc">
			<div class="deactivation_icon"><a class="close_icon" href="#">X</a></div>
				<div class="nc_header_text">CALCULATOR</div>
					<div class="new_calc_league_bet_infos">
						<div>
							<div class="new_calc_league_bet_risk_text ncl_btext">Risk</div>
								<div class="new_calc_league_bet_profit_text ncl_btext">Profit</div>
								<div class="new_calc_league_bet_win_text ncl_btext">Win</div>
						</div>
						<div>
							<div class="new_calc_league_bet_risk_text ncl_btext valuediv">
								<input size="5" value="100" class="risk_input" onfocus="this.value = this.value;">&pound;
								<img class="left" src="<?php echo $base_url;?>/img/icons_2/edit.png">
							</div>
							<div class="new_calc_league_bet_profit_text ncl_btext valuediv">
								<span class="middle"></span> %
							</div>
							<div class="new_calc_league_bet_win_text ncl_btext valuediv">
								<input size="5" value="100" class="win_input">&pound;
								<img class="right" src="<?php echo $base_url;?>/img/icons_2/edit.png">
							</div>
						</div>
					</div>
					<div class="nc_table_container">
						<table class="nc_table">
							<tr class="table_row_nc title_row small_row">
								<td class="nc_broker_cell"></td>
								<td class="nc_quote_cell calc_ncq_1 ncq_cursor_element"><div>Back</div></td>
								<td class="nc_quote_cell calc_ncq_2 ncq_cursor_element"><div>Lay</div></td>
								<td class="nc_quote_cell calc_ncq_3 ncq_cursor_element"><div></div></td>
							</tr>
							<tr>
								<td></td><td class="logo1"></td><td class="logo2"></td><td class="logo3"></td>
							</tr>
							<tr class="table_row_nc">
								<td class="nc_broker_cell">Odds</td>
								<td class="nc_quote_cell ncq_1 ncq_cursor_element">
									<input value="Err" class="ncqc1_input_odd">
								</td>
								<td class="nc_quote_cell ncq_2 ncq_cursor_element">
									<input value="Err" class="ncqc2_input_odd">
								</td>
								<td class="nc_quote_cell ncq_3 ncq_cursor_element">
									<input value="Err" class="ncqc3_input_odd">
								</td>
							</tr>
							<tr class="bet_value_row">
								<td class="nc_broker_cell">Bets</td>
								<td class="nc_quote_cell ncqc1 ncq_cursor_element">
									<input value="1" class="ncqc1_input"> &pound;
								</td>
								<td class="nc_quote_cell ncqc2 ncq_cursor_element">
									<input value="2" class="ncqc2_input"> &pound;
								</td>
								<td class="nc_quote_cell ncqc3 ncq_cursor_element">
									<input value="3" class="ncqc3_input"> &pound;
								</td>
							</tr>
						</table>
					</div>
					<div><a href="#" id="two_odds_cal">2-ODDS-CALCULATOR</a></div>
				</div>
		</div>
		<div id="feedback-tab">CALCULATE</div>
</div>


