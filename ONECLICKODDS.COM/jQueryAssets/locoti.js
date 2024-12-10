var packery_base = null;

var timeEnd = 0.5 * 60;
var timer_counter = 0;

var isUpdated = false;
var uniqueUpdate = false;

var sBetsAccoArray = [];

var currentSurebets = null;
var currentActivatedSurebet = null;

var addition_array = Array();

var last_open_surebet_id = null;

var bought_surebets = [];
var agreement_end_timestamp = null;

var pckry;

var credits = 0;
var email = null;
var password = null;
var userId = null;
var isLogged = false;
var isStopped = false;
var hasFullAccess = false;

var highlightingColor = "#aaa";

var standalone_calculator_is_open_2 = false;
var standalone_calculator_is_open_3 = false;
var standalone_calculator_is_open_4 = false;

var ncObjects = [];

var bet_value_complete = 100;
var bet_values = Array();

var earn_money_state = 0;
var get_fp_state = 0;

var social_title = "locoti";
var social_image_url = "";

var sbet_path = "control/ajax_sbets.php";
var login_path = "control/login.php";
var logout_path = "control/logout.php";
var register_path = "control/register.php";
var set_sort_path = "control/set_sort.php";
var newsletter_path = "gimmic_providing/register_email.php";
var broker_icon_path = "images/locoti_bookie_logos/";

var openPaypal = false;

/**
 * 
 */
function setSB(surebet, isEnabled) {

	var list = null;

	isEnabled = isEnabled == undefined ? false : isEnabled;

	var sport_id = surebet.sport_id;

	// RETURN IF THE SUBEBET DOES NOT HAVE THE CORRECT AMOUNT OF SUBBETTYPES
	if (surebet.bettype_structure.amount_of_odds != 3 && surebet.bettype_structure.amount_of_odds != 2)
		return;

	// GETTING THE SUBBETTYPE NAMES
	var bettypeN = surebet.bettype_structure.title;
	var quoteN1 = surebet.bettype_structure.odds[0].title;
	var quoteN2 = surebet.bettype_structure.odds[1].title;
	var quoteN3 = "";

	// bettype 3
	if (surebet.bettype_structure.amount_of_odds == 3)
		quoteN3 = surebet.bettype_structure.odds[2].title;


	// DIREGARDING SUREBETS IF THEY HAVE LESS THAN ONE BROKER ENTRIES
	if (surebet.broker_data.length < 1)
		return;

	var colorCode = "#074e68";

	if(surebet.bettype_id != null && (surebet.bettype_id > 0 || surebet.bettype_id.length > 0) ){
		if (colorAccoArray[surebet.bettype_id] != undefined) {
			colorCode = colorAccoArray[surebet.bettype_id];
			
		}else if (surebet.bettype_id.length > 0){ // check for virtual bettypes
			
			colorCode = "#d9534f";
		}
	}
	
	var max = surebet.max;

	// SETTING THE EVENT ID (IS NEEDED FOR GETTING THE SUREBET TILE IN LATER
	// PROCESSES)
	var sbet_id = surebet.t1_id + "_" + surebet.t2_id + "_" + surebet.expires
			+ "_" + surebet.date + "_" + surebet.bettype_id;

	if(ncObjects[sbet_id]!=null){
		return;
	}
	
	sBetsAccoArray[sbet_id] = surebet;

	if (isLogged && !isEnabled && max < high_max_value)
			for (var i = 0; i < bought_surebets.length; i++) {
				if (sbet_id == bought_surebets[i]) {
					isEnabled = true;
					break;
				}
			}

	// GETTING THE GAME INFORMATIONS
	var teams = (surebet.broker_data[0].t1) + " - "
			+ (surebet.broker_data[0].t2);
	var date = "(" + surebet.expires + " " + surebet.date + ")";
	var sport = surebet.broker_data[0].sport_title;
	var country = surebet.broker_data[0].country_title;
	var league = surebet.broker_data[0].league_title;

	var quoteV1 = surebet.broker_data[0].odd_values[0][1];
	var brokerName1 = surebet.broker_data[0].broker;
	var quoteV2 = surebet.broker_data[0].odd_values[1][1];
	var brokerName2 = surebet.broker_data[0].broker;

	var quoteV3 = "";
	var brokerName3 = "";

	// FOR BETTYPE 3
	if (surebet.bettype_structure.amount_of_odds == 3) {

		quoteV3 = surebet.broker_data[0].odd_values[2][1];
		brokerName3 = surebet.broker_data[0].broker;
	}

	var bn_array = [];
	var in_array = [];

	// SETTING THE SUREBET SUBBETTYPE VALUES OF THE BROKERS
	for (var i = 1; i < surebet.broker_data.length; i++) {

		if (quoteV1 < surebet.broker_data[i].odd_values[0][1]) {
			quoteV1 = surebet.broker_data[i].odd_values[0][1];
			brokerName1 = surebet.broker_data[i].broker;
		}

		if (quoteV2 < surebet.broker_data[i].odd_values[1][1]) {
			quoteV2 = surebet.broker_data[i].odd_values[1][1];
			brokerName2 = surebet.broker_data[i].broker;
		}

		// FOR BETTYPE 3
		if (surebet.bettype_structure.amount_of_odds == 3) {
			if (quoteV3 < surebet.broker_data[i].odd_values[2][1]) {
				quoteV3 = surebet.broker_data[i].odd_values[2][1];
				brokerName3 = surebet.broker_data[i].broker;
			}
		}

	}

	// SETTING THE IMAGE FOR THE SPORT TYPE
	bn_array[0] = brokerName1;
	bn_array[1] = brokerName2;
	in_array[0] = bn_array[0].toLowerCase() + "_w.png";
	in_array[1] = bn_array[1].toLowerCase() + "_w.png";
	quoteV1 = (Math.ceil(quoteV1 * 100) / 100);
	quoteV2 = (Math.ceil(quoteV2 * 100) / 100);

	var imageName1 = broker_icon_path + in_array[0];
	var imageName2 = broker_icon_path + in_array[1];
	var imageName3 = "";

	// FOR BETTYPE 3
	if (surebet.bettype_structure.amount_of_odds == 3) {

		bn_array[2] = brokerName3;
		in_array[2] = bn_array[2].toLowerCase() + "_w.png";
		quoteV3 = (Math.ceil(quoteV3 * 100) / 100);

		imageName3 = broker_icon_path + in_array[2];
	}

	var sportImageName = "images/icons/";
	if (typeof sportImageAccoArray[sport_id] == 'undefined')
		sportImageName = "";
	else
		sportImageName += sportImageAccoArray[sport_id];

	var sbtile_id = -1;

	// CHOSING THE RIGHT TEMPLATE ACCORDING TO THE HIGH OF THE MAX SUREBET VALUE
	if (surebet.bettype_structure.amount_of_odds == 3) {
		if (max < very_low_max_value)
			sbtile_id = "template3";
		else if (max >= very_low_max_value && max < low_max_value)
			sbtile_id = "template2";
		else if (max >= low_max_value)
			sbtile_id = "template1";
		else
			sbtile_id = "template3";
	} else {
		if (max < very_low_max_value)
			sbtile_id = "template3_2";
		else if (max >= very_low_max_value && max < low_max_value)
			sbtile_id = "template2_2";
		else if (max >= low_max_value)
			sbtile_id = "template1_2";
		else
			sbtile_id = "template3_2";
	}

	// DISREGARDING NO SUPPORTED NUMBERS
	if (sbtile_id == -1) {
		return;
	}

	var t = create_initiate_element(sbtile_id, sbet_id);

	t.setAttribute("colorCode", colorCode);

	if (sbtile_id == "template1" || sbtile_id == "template1_2") {

		var t_back;

		if (isLogged) {

			if (sbtile_id == "template1") {

				if (!isEnabled){
					if(max<high_max_value){
						t_back = create_initiate_element("ne_login_backside_size1");						
					}
					else{
						t_back = create_initiate_element("ne_login_backside_size1_high");
					}
				}
				else
					t_back = create_initiate_element("en_login_backside_size1");

			} else if (sbtile_id == "template1_2") {

				
				if (!isEnabled){
					if(max<high_max_value){
						t_back = create_initiate_element("ne_login_backside_size1_2");
						
					}
					else{
						t_back = create_initiate_element("ne_login_backside_size1_2_high");					}
				}
				else
					t_back = create_initiate_element("en_login_backside_size1_2");

			}

		} else {
			t_back = document.getElementById("free_backside").cloneNode(true);
			t_back.style.display = "initial";
		}

		t_back.removeAttribute('id');
		t.appendChild(t_back);

	}

	// SETTING THE GAMEINFOS
	if (sbtile_id == "template1" || sbtile_id == "template1_2") {

		if (isLogged) {
			// THE LARGE TILE
			t.getElementsByClassName("gameinfo_1")[0].textContent = teams + " "
					+ date;
			t.getElementsByClassName("gameinfo_2")[0].textContent = sport
					+ " - " + country + " - " + league;
		}

	} else if (sbtile_id == "template2" || sbtile_id == "template2_2") {

		// THE MIDDLE TILE
		t.getElementsByClassName("gameinfo_teams")[0].textContent = teams;
		t.getElementsByClassName("gameinfo_date")[0].textContent = date;
		t.getElementsByClassName("gameinfo_league")[0].textContent = sport
				+ " - " + country + " - " + league;

		var elem_bn = t.getElementsByClassName("sbe_back")[0]
				.getElementsByClassName("bettypeN")[0];
		if (bettypeN.length > 8)
			elem_bn.style.fontSize = "150%";
		if (bettypeN.length > 12)
			elem_bn.style.fontSize = "120%";

	} else if (sbtile_id == "template3" || sbtile_id == "template3_2") {

		// THE SMALL TILE
		t.getElementsByClassName("gameinfo_teams")[0].textContent = teams;
		t.getElementsByClassName("gameinfo_date")[0].textContent = date;
		t.getElementsByClassName("gameinfo_league")[0].textContent = sport
				+ " - " + country + " - " + league;

	}

	// SETTING BETTYPE NAME
	list = t.getElementsByClassName("bettypeN");
	for (var i = 0; i < list.length; i++)
		list[i].textContent = bettypeN;

	var max_value = (Math.ceil(max * 100) / 100) + "%";

	// SETTING MAX SUREBET VALUE
	list = t.getElementsByClassName("max");
	for (var i = 0; i < list.length; i++)
		list[i].textContent = max_value;
	
	list = t.getElementsByClassName("tile_quote_text");
	for (var i = 0; i < list.length; i++)
		list[i].textContent = max_value;

	if (!(sbtile_id == "template1" || sbtile_id == "template1_2")
			|| (isLogged && isEnabled)) {

		t.getElementsByClassName("qn1")[0].textContent = quoteN1;
		t.getElementsByClassName("qv1")[0].textContent = quoteV1;
		t.getElementsByClassName("qn2")[0].textContent = quoteN2;
		t.getElementsByClassName("qv2")[0].textContent = quoteV2;

		t.getElementsByClassName("bi1")[0].setAttribute("src", imageName1);
		t.getElementsByClassName("bi2")[0].setAttribute("src", imageName2);

		// FOR BETTYPE 3
		if (surebet.bettype_structure.amount_of_odds == 3) {
			t.getElementsByClassName("qn3")[0].textContent = quoteN3;
			t.getElementsByClassName("qv3")[0].textContent = quoteV3;

			t.getElementsByClassName("bi3")[0].setAttribute("src", imageName3);
		}

	}

	list = t.getElementsByClassName("sport_image");
	for (var i = 0; i < list.length; i++)
		list[i].setAttribute("src", sportImageName);

	list = t.getElementsByClassName("surebetBaseElement");
	for (var i = 0; i < list.length; i++) {

		if (sbet_id == last_open_surebet_id)
			list[i].style.background = highlightingColor;
		else
			list[i].style.background = colorCode;

	}

	packery_base.appendChild(t);

	if (sbtile_id == "template1" || sbtile_id == "template1_2") {

		if (isLogged) {

			if (isEnabled) {

				// SETTING THE CALCULATOR ACTIVATION LISTENER
				var activationImage = t.getElementsByClassName("activation_icon")[0];
				activationImage.setAttribute("sbetid", sbet_id);
				activationImage.onclick = function() {
					addCalculator(this.getAttribute("sbetid"), colorCode,
							sportImageName, bettypeN);

				};

			} else {

				t.getElementsByClassName("activation_icon")[0].style.display = "none";
				t.getElementsByClassName("lock_image")[0].style.display = "initial";

			}

		} else {

			// SETTING THE FREE REGISTER BUTTON LISTENER
			var registerButton = t
					.getElementsByClassName("free_register_button")[0];
			registerButton.onclick = function() {
				setSB_gimmic_text_regist_login();
			};

		}
	} else {

		// SETTING THE CALCULATOR ACTIVATION LISTENER
		var activationImage = t.getElementsByClassName("activation_icon")[0];
		activationImage.setAttribute("sbetid", sbet_id);
		activationImage.onclick = function() {
			addCalculator(this.getAttribute("sbetid"), colorCode,
					sportImageName, bettypeN);

		};

	}

	if (isLogged) {

		var list = t.getElementsByClassName("facebook_button");
		for (var i = 0; i < list.length; i++) {

			list[i].setAttribute("sbet_id", sbet_id);
			list[i].setAttribute("social_name", "facebook");
			list[i].setAttribute("team1", surebet.broker_data[0].t1);
			list[i].setAttribute("team2", surebet.broker_data[0].t2);
			list[i].setAttribute("quote", max);
			list[i].onclick = share_social;

		}
		var list = t.getElementsByClassName("google_button");
		for (var i = 0; i < list.length; i++) {

			list[i].setAttribute("sbet_id", sbet_id);
			list[i].setAttribute("social_name", "google");
			list[i].setAttribute("team1", surebet.broker_data[0].t1);
			list[i].setAttribute("team2", surebet.broker_data[0].t2);
			list[i].setAttribute("quote", max);
			list[i].onclick = share_social;

		}
		var list = t.getElementsByClassName("twitter_button");
		for (var i = 0; i < list.length; i++) {

			list[i].setAttribute("sbet_id", sbet_id);
			list[i].setAttribute("social_name", "twitter");
			list[i].setAttribute("team1", surebet.broker_data[0].t1);
			list[i].setAttribute("team2", surebet.broker_data[0].t2);
			list[i].setAttribute("quote", max);
			list[i].onclick = share_social;

		}

	}

	var list = t.getElementsByClassName("tile_button");
	for (var i = 0; i < list.length; i++)
		list[i].style.color = colorCode;

	if (isLogged && !isEnabled) {
		if (sbtile_id == "template1" || sbtile_id == "template1_2") {

			if(max<high_max_value){
				t.getElementsByClassName("buysb_button")[0].setAttribute("sbetid", sbet_id);
				t.getElementsByClassName("buysb_button")[0].onclick = buy_sbet_action;
			}
			else{
				t.getElementsByClassName("buysb_button")[0].innerHTML = "";
			}
			
			t.getElementsByClassName("buyweek_button")[0].setAttribute("sbetid", sbet_id);
			t.getElementsByClassName("buyweek_button")[0].onclick = buy_week_action;
			t.getElementsByClassName("buymonth_button")[0].setAttribute("sbetid", sbet_id);
			t.getElementsByClassName("buymonth_button")[0].onclick = buy_month_action;

		}
	}
	
	setup_packery(t);

}

/**
 * 
 */
function share_social() {

	var sbet_id = this.getAttribute("sbet_id");
	var social_name = this.getAttribute("social_name");
	var team1 = this.getAttribute("team1");
	var team2 = this.getAttribute("team2");
	var quote = this.getAttribute("quote");

	var url = null;

	var social_text = "Catch this surebet: " + team1 + " - " + team2 + " with "
			+ roundToN(quote, 2) + " percent on your invest. locoti.com";

	if (social_name == "facebook")
		url = "https://www.facebook.com/sharer/sharer.php?s=100&p[url]=www.locoti.com&p[images][0]="
				+ social_image_url
				+ "&p[title]="
				+ social_title
				+ "&p[summary]=" + social_text + "";
	else if (social_name == "google")
		url = "https://plus.google.com/share?url=http://www.locoti.com";
	else if (social_name == "twitter")
		url = "https://twitter.com/intent/tweet?text=" + social_text + "&source=webclient";

	if (url != null)
		window.open(url, '_blank');

	$.post("control/shareSocial.php", {
		password : password,
		email : email,
		sbet_id : sbet_id,
		platform : social_name,
		user_id : userId
	}, function(data) {

		var obj = getJsonObject(data);
				
		if (obj.type == "success" && obj.code == 1)
			update_credits(obj.credits);

	});

}

/**
 * 
 * @param sbet_id
 */
function enableSB(sbet_id) {

	var t = document.getElementById(sbet_id);

	t.removeChild(t.getElementsByClassName("sbe_back")[0]);

	var surebet = sBetsAccoArray[sbet_id];

	var colorCode = "#074e68";

	if(surebet.bettype_id>0)
		for (var i = 0; i < colorAccoArray.length; i++) {
			if (colorAccoArray[surebet.bettype_id] != undefined) {
				colorCode = colorAccoArray[surebet.bettype_id];
				break;
			}
		}
	
	var sport_id = surebet.sport_id;
	var sportImageName = "images/icons/";
	if (typeof sportImageAccoArray[sport_id] == 'undefined')
		sportImageName = "";
	else
		sportImageName += sportImageAccoArray[sport_id];

	// GETTING THE SUBBETTYPE NAMES
	var bettypeN = surebet.bettype_structure.title;
	var quoteN1 = surebet.bettype_structure.odds[0].title;
	var quoteN2 = surebet.bettype_structure.odds[1].title;
	var quoteN3 = "";

	var max = surebet.max;

	// bettype 3
	if (surebet.bettype_structure.amount_of_odds == 3)
		quoteN3 = surebet.bettype_structure.odds[2].title;

	// GETTING THE GAME INFORMATIONS
	var teams = (surebet.broker_data[0].t1) + " - "
			+ (surebet.broker_data[0].t2);
	var date = "(" + surebet.expires + " " + surebet.date + ")";
	var sport = surebet.broker_data[0].sport_title;
	var country = surebet.broker_data[0].country_title;
	var league = surebet.broker_data[0].league_title;

	var quoteV1 = surebet.broker_data[0].odd_values[0][1];
	var brokerName1 = surebet.broker_data[0].broker;
	var quoteV2 = surebet.broker_data[0].odd_values[1][1];
	var brokerName2 = surebet.broker_data[0].broker;

	var quoteV3 = "";
	var brokerName3 = "";

	// FOR BETTYPE 3
	if (surebet.bettype_structure.amount_of_odds == 3) {

		quoteV3 = surebet.broker_data[0].odd_values[2][1];
		brokerName3 = surebet.broker_data[0].broker;

	}

	var bn_array = [];
	var in_array = [];

	// SETTING THE SUREBET SUBBETTYPE VALUES OF THE BROKERS
	for (var i = 1; i < surebet.broker_data.length; i++) {

		if (quoteV1 < surebet.broker_data[i].odd_values[0][1]) {

			quoteV1 = surebet.broker_data[i].odd_values[0][1];
			brokerName1 = surebet.broker_data[i].broker;

		}

		if (quoteV2 < surebet.broker_data[i].odd_values[1][1]) {

			quoteV2 = surebet.broker_data[i].odd_values[1][1];
			brokerName2 = surebet.broker_data[i].broker;

		}

		// FOR BETTYPE 3
		if (surebet.bettype_structure.amount_of_odds == 3) {
			if (quoteV3 < surebet.broker_data[i].odd_values[2][1]) {

				quoteV3 = surebet.broker_data[i].odd_values[2][1];
				brokerName3 = surebet.broker_data[i].broker;

			}
		}

	}

	// SETTING THE IMAGE FOR THE SPORT TYPE
	bn_array[0] = brokerName1;
	bn_array[1] = brokerName2;
	in_array[0] = bn_array[0].toLowerCase() + "_w.png";
	in_array[1] = bn_array[1].toLowerCase() + "_w.png";
	quoteV1 = (Math.ceil(quoteV1 * 100) / 100);
	quoteV2 = (Math.ceil(quoteV2 * 100) / 100);

	var imageName1 = broker_icon_path + in_array[0];
	var imageName2 = broker_icon_path + in_array[1];
	var imageName3 = "";

	// FOR BETTYPE 3
	if (surebet.bettype_structure.amount_of_odds == 3) {

		bn_array[2] = brokerName3;
		in_array[2] = bn_array[2].toLowerCase() + "_w.png";
		quoteV3 = (Math.ceil(quoteV3 * 100) / 100);

	}

	var sbtile_id = "template1";

	if (surebet.bettype_structure.amount_of_odds == 2)
		sbtile_id = "template1_2";

	var t_back = null;

	if (sbtile_id == "template1")
		t_back = create_initiate_element("en_login_backside_size1");
	else
		t_back = create_initiate_element("en_login_backside_size1_2");

	t.appendChild(t_back);

	t.getElementsByClassName("gameinfo_1")[0].textContent = teams + " " + date;
	t.getElementsByClassName("gameinfo_2")[0].textContent = sport + " - " + country + " - " + league;

	var list = null;

	// SETTING BETTYPE NAME
	list = t.getElementsByClassName("bettypeN");
	for (var i = 0; i < list.length; i++)
		list[i].textContent = bettypeN;

	// SETTING MAX SUREBET VALUE
	list = t.getElementsByClassName("max");
	for (var i = 0; i < list.length; i++)
		list[i].textContent = (Math.ceil(max * 100) / 100) + "%";

	t.getElementsByClassName("qn1")[0].textContent = quoteN1;
	t.getElementsByClassName("qv1")[0].textContent = quoteV1;
	t.getElementsByClassName("qn2")[0].textContent = quoteN2;
	t.getElementsByClassName("qv2")[0].textContent = quoteV2;

	t.getElementsByClassName("bi1")[0].setAttribute("src", imageName1);
	t.getElementsByClassName("bi2")[0].setAttribute("src", imageName2);

	// FOR BETTYPE 3
	if (surebet.bettype_structure.amount_of_odds == 3) {
		t.getElementsByClassName("qn3")[0].textContent = quoteN3;
		t.getElementsByClassName("qv3")[0].textContent = quoteV3;

		t.getElementsByClassName("bi3")[0].setAttribute("src", imageName3);
	}

	list = t.getElementsByClassName("surebetBaseElement");
	for (var i = 0; i < list.length; i++)
		list[i].style.background = colorCode;

	if (isLogged) {

		var list = t.getElementsByClassName("facebook_button");
		for (var i = 0; i < list.length; i++) {

			list[i].setAttribute("sbet_id", sbet_id);
			list[i].setAttribute("social_name", "facebook");
			list[i].onclick = share_social;

		}
		var list = t.getElementsByClassName("google_button");
		for (var i = 0; i < list.length; i++) {

			list[i].setAttribute("sbet_id", sbet_id);
			list[i].setAttribute("social_name", "google");
			list[i].onclick = share_social;

		}
		var list = t.getElementsByClassName("twitter_button");
		for (var i = 0; i < list.length; i++) {

			list[i].setAttribute("sbet_id", sbet_id);
			list[i].setAttribute("social_name", "twitter");
			list[i].onclick = share_social;

		}

	}

	var list = t.getElementsByClassName("tile_button");
	for (var i = 0; i < list.length; i++)
		list[i].style.color = colorCode;

	t.getElementsByClassName("lock_image")[0].style.display = "none";

	var activationImage = t.getElementsByClassName("activation_icon")[0];
	activationImage.setAttribute("sbetid", sbet_id);
	activationImage.onclick = function() {
		addCalculator(this.getAttribute("sbetid"), colorCode, sportImageName,
				bettypeN);

	};
}

/**
 * 
 * @param data
 * @returns
 */
function getJsonObject(data){
	
	return eval("(" + decode(data.split(marker)[1]) + ")");
	
}

/**
 * 
 */
function buy_sbet_action() {

	var sbet_id = this.getAttribute("sbetid");
	var element = document.getElementById(sbet_id);
	getFirstByClassName(element,"loading_icon").style.display = "initial";
	getFirstByClassName(element,"credit_message").style.display = "none";
	getFirstByClassName(element,"credit_message").textContent = "hello";
	
	$.post("control/buySurebet.php", {
		password : password,
		email : email,
		sbet_id : sbet_id
	}, function(data) {

		var obj = getJsonObject(data);
		var element = document.getElementById(sbet_id);
		
		if (obj.type == "success") {

			bought_surebets.push(obj.sbet_id);
			update_credits(obj.credits);
			enableSB(obj.sbet_id);

		}
		else{
			

			if(obj.code){
				getFirstByClassName(element,"credit_message").textContent = "Not enough Credits! Click here to get more credits!";
				getFirstByClassName(element,"credit_message"). onclick = function(){					
					setSB_paypal();
					setBehind(sbet_id,"paypal_tile");
				};
			}
			else
				getFirstByClassName(element,"credit_message").textContent = "Error";
				
			getFirstByClassName(element,"loading_icon").style.display = "none";
			getFirstByClassName(element,"credit_message").style.display = "initial";
		}

	});
}

/**
 * 
 */
function buy_week_action() {
	
	var sbet_id = this.getAttribute("sbetid");
	var element = document.getElementById(sbet_id);
	getFirstByClassName(element,"loading_icon").style.display = "initial";
	getFirstByClassName(element,"credit_message").style.display = "none";
	getFirstByClassName(element,"credit_message").textContent = "hello";
	
	$.post("control/buyTwoWeeks.php", {
		password : password,
		email : email,
	}, function(data) {

		var obj = getJsonObject(data);
		var element = document.getElementById(sbet_id);
		
		if (obj.type == "success") {

			agreement_end_timestamp = obj.agreement_end_date;
			update_credits(obj.credits);
			uniqueUpdate = true;
		}
		else{
			
			if(obj.code){
				getFirstByClassName(element,"credit_message").textContent = "Not enough Credits! Click here to get more credits!";
				getFirstByClassName(element,"credit_message"). onclick = function(){					
					setSB_paypal();
					setBehind(sbet_id,"paypal_tile");
				};
			}
			else
				getFirstByClassName(element,"credit_message").textContent = "Error";

			getFirstByClassName(element,"loading_icon").style.display = "none";
			getFirstByClassName(element,"credit_message").style.display = "initial";
		}
		
	});
}

/**
 * 
 */
function buy_month_action() {
	
	var sbet_id = this.getAttribute("sbetid");
	var element = document.getElementById(sbet_id);
	getFirstByClassName(element,"loading_icon").style.display = "initial";
	getFirstByClassName(element,"credit_message").style.display = "none";
	getFirstByClassName(element,"credit_message").textContent = "hello";
	
	$.post("control/buyOneMonth.php", {
		password : password,
		email : email,
	}, function(data) {

		var obj = getJsonObject(data);
		var element = document.getElementById(sbet_id);
		
		if (obj.type == "success") {

			agreement_end_timestamp = obj.agreement_end_date;
			update_credits(obj.credits);
			uniqueUpdate = true;
		}
		else{
			
			if(obj.code){
				getFirstByClassName(element,"credit_message").textContent = "Not enough Credits! Click here to get more credits!";
				getFirstByClassName(element,"credit_message"). onclick = function(){					
					setSB_paypal();
					setBehind(sbet_id,"paypal_tile");
				};
			}
			else
				getFirstByClassName(element,"credit_message").textContent = "Error";

			getFirstByClassName(element,"loading_icon").style.display = "none";
			getFirstByClassName(element,"credit_message").style.display = "initial";
		}
		
	});
}

/**
 * 
 * @param credits_temp
 */
function update_credits(credits_temp) {
	credits = credits_temp;
	var t = document.getElementById("user_tile");
	t.getElementsByClassName("account_credits")[0].textContent = credits;
}

function resetRegisterMessages(){
	
	var t = document.getElementById("packery_base");
	var list = t.getElementsByClassName("register_msg");
	
	for(var i=0;i<list.length;i++){
		list.textContent = "";
	}
}

function resetLoginMessages(){
	
	var t = document.getElementById("packery_base");
	var list = t.getElementsByClassName("login_msg");
	
	for(var i=0;i<list.length;i++){
		list.textContent = "";
	}
}

/**
 * ADDING A SUREBET CALCULATOR
 * 
 * @param id
 */
function addCalculator(id, colorCode, sportImage, bettypeN) {

	// IF NC OBJECT EXISTS THEN RETURN
	if (ncObjects[id] != null)
		return;

	var tempSurebets = currentSurebets;
	var array = id.split("_");

	if (array.length != 5)
		return;

	var t1_part = array[0];
	var t2_part = array[1];
	var expires_part = array[2];
	var date_part = array[3];
	var bettype_part = array[4];

	var foundSurebet = null;

	for (var i = 0; i < tempSurebets.length; i++) {

		if (tempSurebets[i].t1_id != t1_part || tempSurebets[i].t2_id != t2_part)
			continue;
		if (tempSurebets[i].expires != expires_part || tempSurebets[i].date != date_part)
			continue;
		if (tempSurebets[i].bettype_id != bettype_part)
			continue;

		foundSurebet = tempSurebets[i];
		break;
	}

	if (foundSurebet == null)
		return;

	var oddArray = [];

	var broker_data = foundSurebet.broker_data;

	for (var i = 0; i < broker_data.length; i++)
		for (var j = 0; j < broker_data[0].odd_values.length; j++)
			oddArray[i * broker_data[0].odd_values.length + j] = broker_data[i].odd_values[j][1];

	var ncObject = {
		oddArray : oddArray,
		odd_amount : broker_data[0].odd_values.length,
		broker_amount : broker_data.length,
		colorCode : colorCode,
		sportImage : sportImage,
		bettypeN : bettypeN
	};

	ncObjects[id] = setSB_nc(id, foundSurebet, ncObject, colorCode);

	updateNCalculator(id);

	var itemElems = pckry.items;

	var num1 = -1;
	var num2 = -1;

	for (var i = 0; i < itemElems.length; i++) {

		var elem = itemElems[i].element;

		if (elem.id == id)
			num1 = i;
		if (elem.id == "nc_" + id)
			num2 = i;

	}

	if (num1 < num2 && num1 > -1 && num2 > -1) {

		var tempItemElement = itemElems[num2];
		for (var i = num2 - 1; i > num1; i--)
			itemElems[i + 1] = itemElems[i];

		itemElems[num1 + 1] = tempItemElement;

	}

	updatePckry();

	var sbt = document.getElementById(id);
	var nct = document.getElementById("nc_" + id);
	var list;

	last_open_surebet_id = id;
	resetTileColor();

}

/**
 * 
 */
function resetTileColor() {

	var surebetTiles = packery_base.getElementsByClassName("sbet_main_element");
	var calculatorTiles = packery_base
			.getElementsByClassName("nc_main_element");

	for (var i = 0; i < surebetTiles.length; i++) {

		var list = surebetTiles[i].getElementsByClassName("surebetBaseElement");
		for (var j = 0; j < list.length; j++) {
			if (surebetTiles[i].getAttribute("id") == last_open_surebet_id) {
				list[j].style.background = highlightingColor;
				continue;
			}
			list[j].style.background = surebetTiles[i]
					.getAttribute("colorCode");
		}
	}
	for (var i = 0; i < calculatorTiles.length; i++) {

		var list = calculatorTiles[i].getElementsByClassName("new_calc");
		for (var j = 0; j < list.length; j++) {
			if (calculatorTiles[i].getAttribute("id") == "nc_"
					+ last_open_surebet_id) {
				list[j].style.background = highlightingColor;
				continue;
			}
			list[j].style.background = calculatorTiles[i]
					.getAttribute("colorCode");
		}
	}

}

/**
 * 
 */
function addStandaloneCalculator(numOdds,odds1,odds2,odds3) {

	if (standalone_calculator_is_open_4 && numOdds == 4){
		return;
	}
	else
	if (standalone_calculator_is_open_3 && numOdds == 3){

		return;
	}
	else
	if (standalone_calculator_is_open_2 && numOdds == 2){
		return;
	}
	
	if (numOdds == 4){
		standalone_calculator_is_open_4 = true;
	}
	else
	if (numOdds == 3){
		standalone_calculator_is_open_3 = true;
	}
	else
	if (numOdds == 2)
	{
		standalone_calculator_is_open_2 = true;
	}
		
	setSB_nc_standalone(numOdds,odds1,odds2,odds3);

	var itemElems = pckry.items;
	var num = -1;

	for (var i = 0; i < itemElems.length; i++) {

		var elem = itemElems[i].element;
		if (elem.id == "open_tile")
			num = i;

	}

	if (num > -1) {

		var tempItemElement = itemElems[itemElems.length - 1];
		for (var i = itemElems.length - 2; i > num; i--)
			itemElems[i + 1] = itemElems[i];
		itemElems[num + 1] = tempItemElement;

	}

	updatePckry();

}

/**
 * 
 */
function setSB_header() {

	var t = create_initiate_element("header_template", "header_tile");

	packery_base.appendChild(t);

	setup_packery(t);

	setMenuListener();

}

/**
 * 
 */
function setSB_paypal() {

	var objId = "paypal_tile";

	if (addition_array[objId] != null)
		return;
	addition_array[objId] = true;

	var t = create_initiate_element("paypal_template", objId);

	packery_base.appendChild(t);

	setup_packery(t);

	t.getElementsByClassName("free_bar_elements")[0].onclick = function() {

		var str = "get_fp";

		if (addition_array[str] != null)
			return;

		addition_array[str] = true;
		get_fp_state = 0;
		if (isLogged)
			get_fp_state = 2;
		setSB_gimmic_rlt(str, get_fp_state, "fp");

		setBehind("fp_tile", str);
		
	};

	t.getElementsByClassName("first_bar_elements")[0].onclick = function() {
		if (!isLogged)
			return;
		open_new_window("50c Credits", "1", "1.99");
	};
	t.getElementsByClassName("second_bar_elements")[0].onclick = function() {
		if (!isLogged)
			return;
		open_new_window("4.000c Credits", "2", "49.00");
	};
	t.getElementsByClassName("third_bar_elements")[0].onclick = function() {
		if (!isLogged)
			return;
		open_new_window("12.000c Credits", "3", "119.00");
	};
	t.getElementsByClassName("fourth_bar_elements")[0].onclick = function() {
		if (!isLogged)
			return;
		open_new_window("30.000c Credits", "4", "249.00");
	};
	t.getElementsByClassName("fifth_bar_elements")[0].onclick = function() {
		if (!isLogged)
			return;
		open_new_window("60.000c Credits", "5", "449.00");
	};

	setDeactivationActionListener(t, objId);

}

/**
 * 
 * @param t
 * @param objId
 */
function setDeactivationActionListener(t, objId) {

	var deactivationImage = t.getElementsByClassName("deactivation_icon")[0];
	deactivationImage.setAttribute("objid", objId);
	deactivationImage.onclick = function() {

		var t = document.getElementById(this.getAttribute("objid"));
		delete addition_array[this.getAttribute("objid")];
		pckry.remove(t);
		updatePckry();

	};

}

/**
 * 
 * @param name
 * @param number
 * @param amount
 */
function open_new_window(name, number, amount) {

	if (userId == null)
		return;

	var f = document.getElementById('paypal_form');
	f.item_name.value = name;
	f.item_number.value = number;
	f.amount.value = amount;
	f.custom.value = userId;
	f.submit();
}

/**
 * 
 */
function setSB_gimmic() {

	var t = create_initiate_element("gimmic_template");
	packery_base.appendChild(t);

	setup_packery(t);
}

/**
 * 
 */
function setSB_faq() {

	var t = create_initiate_element("faq_template","faq_tile");
	
	t.getElementsByClassName("gimmic_text")[0].onclick = function() {

		var url = "http://www.locoti.de/faq/";
		
		if (url != null)
			window.open(url, '_blank');

	};
	
	t.getElementsByClassName("rlt_image")[0].onclick = function() {

		var url = "http://www.locoti.de/faq/";
		
		if (url != null)
			window.open(url, '_blank');

	};
		
	packery_base.appendChild(t);

	setup_packery(t);
}

/**
 * 
 */
function setSB_buyCredits() {
	
	var t = create_initiate_element("buy_credits_template","buy_credits_tile");
		
	t.getElementsByClassName("gimmic_text")[0].onclick = function() {
		buyCreditsFun();
	};
	
	t.getElementsByClassName("rlt_image")[0].onclick = function() {
		buyCreditsFun();
	};
	
	packery_base.appendChild(t);

	setup_packery(t);
}

function buyCreditsFun(){
	if (!isLogged){
		
		openPaypal = true;
		setSB_gimmic_text_regist_login();
				
		return;
	}
	
	setSB_paypal();
	setBehind("buy_credits_tile","paypal_tile");
}

/**
 * 
 */
function setSB_gimmic_flash() {

	var t = create_initiate_element("flash_template");
	packery_base.appendChild(t);

	setup_packery(t);
}

var activatedColor = "#000";
var deactivatedColor = "#888";

/**
 * 
 */
function setSB_gimmic_sort() {
	
	var t = create_initiate_element("sort_buttons_template","sort_tile");
	packery_base.appendChild(t);

	if(sort_by_id == 1){
		t.getElementsByClassName("sort_date")[0].style.backgroundColor = activatedColor;
		t.getElementsByClassName("sort_quote")[0].style.backgroundColor = deactivatedColor;

	}
	else
	if(sort_by_id == 2){
		t.getElementsByClassName("sort_quote")[0].style.backgroundColor = activatedColor;
		t.getElementsByClassName("sort_date")[0].style.backgroundColor = deactivatedColor;

	}
		
	t.getElementsByClassName("sort_date")[0].onclick = function() {
		
		if(sort_by_id == 1){
			return;
		}
		
		sort_by_id = 1;
		
		t.getElementsByClassName("sort_date")[0].style.backgroundColor = activatedColor;
		t.getElementsByClassName("sort_quote")[0].style.backgroundColor = deactivatedColor;
		
		sendSortState();
		
		uniqueUpdate = true;
	};
	
	t.getElementsByClassName("sort_quote")[0].onclick = function() {
		
		if(sort_by_id == 2){
			return;
		}
		
		sort_by_id = 2;
		
		t.getElementsByClassName("sort_quote")[0].style.backgroundColor = activatedColor;
		t.getElementsByClassName("sort_date")[0].style.backgroundColor = deactivatedColor;
		
		sendSortState();
		
		uniqueUpdate = true;
	};
	
	setup_packery(t);
}

function sendSortState(){
	
	$.post(set_sort_path, {
		sort_by_id : sort_by_id,
	}, function(data) {
		
	});
	
}

/**
 * 
 */
function setSB_gimmic_user() {

	var t = create_initiate_element("gimmic_user_info_template", "user_tile");

	t.getElementsByClassName("user_info_1_button")[0].style.display = "initial";
	t.getElementsByClassName("user_info_1_button")[0].onclick = function() {
		setSB_gimmic_text_regist_login();
		updatePckry();
	};

	t.getElementsByClassName("credtr")[0].style.display = "none";
	t.getElementsByClassName("packtr")[0].style.display = "initial";

	t.getElementsByClassName("refresh_icon")[0].onclick = function() {
		location.reload(); 
	};
	
	packery_base.appendChild(t);

	setup_packery(t);
	
}

/**
 * 
 */
function setSB_gimmic_earn_money() {

	var t = create_initiate_element("gimmic_template_earn_money",
			"earn_money_tile");

	t.getElementsByClassName("rlt_image")[0].onclick = function() {

		var str = "earn_money";
		if (addition_array[str] != null)
			return;

		addition_array[str] = true;
		earn_money_state = 0;
		if (isLogged)
			earn_money_state = 2;
		
		setSB_gimmic_rlt(str, earn_money_state, "em");

		setBehind("earn_money_tile", str);

	};

	packery_base.appendChild(t);

	setup_packery(t);

	updatePckry();
}

/**
 * 
 */
function setSB_gimmic_get_fp() {

	var t = create_initiate_element("gimmic_template_get_fp", "fp_tile");

	t.getElementsByClassName("rlt_image")[0].onclick = function() {

		var str = "get_fp";

		if (addition_array[str] != null)
			return;

		addition_array[str] = true;
		get_fp_state = 0;
		if (isLogged)
			get_fp_state = 2;
		setSB_gimmic_rlt(str, get_fp_state, "fp");

		setBehind("fp_tile", str);

	};

	packery_base.appendChild(t);

	setup_packery(t);

	updatePckry();
}

/**
 * 
 * @param str1
 * @param str2
 */
function setBehind(str1, str2) {

	var itemElems = pckry.items;

	var num1 = -1;
	var num2 = -1;

	for (var i = 0; i < itemElems.length; i++) {

		var elem = itemElems[i].element;

		if (elem.id == str1)
			num1 = i;
		if (elem.id == str2)
			num2 = i;

	}

	if (num1 < num2 && num1 > -1 && num2 > -1) {

		var tempItemElement = itemElems[num2];

		for (var i = num2 - 1; i > num1; i--)
			itemElems[i + 1] = itemElems[i];

		itemElems[num1 + 1] = tempItemElement;

	}

	updatePckry();
}

/**
 * 
 */
function setSB_gimmic_rlt(objId, startState, additional_title) {

	var t = create_initiate_element("gimmic_template_rlt_" + additional_title,
			objId);

	packery_base.appendChild(t);

	var l1 = t.getElementsByClassName("layer_one")[0];
	var l2 = t.getElementsByClassName("layer_two")[0];
	var l3 = t.getElementsByClassName("layer_three")[0];

	if (startState == 0) {
		l1.style.display = "initial";
		l2.style.display = "none";
		l3.style.display = "none";
	}
	if (startState == 2) {
		l1.style.display = "none";
		l2.style.display = "none";
		l3.style.display = "initial";
	}

	setDeactivationActionListener(t, objId);

	t.getElementsByClassName("button_regist")[0].onclick = function() {

		do_register_request(t, true)

	};

	t.getElementsByClassName("button_login")[0].onclick = function() {

		do_login_request(t, true);

	};

	var vec = t.getElementsByClassName("copy_button");
	for (var i = 0; i < vec.length; i++) {
		vec[i].textContent = "locoti.com/index.php?aff=USERID";
		vec[i].onclick = function() {

			if (isLogged)
				copy2clipboard("locoti.com/index.php?aff=USERID");

		};
	}

	setListenerForm(t);

	setup_packery(t);

	var vec = packery_base.getElementsByClassName("gimmic_text link_user_text");
	for (var i = 0; i < vec.length; i++)
		vec[i].textContent = "locoti.com/index.php?aff=" + userId;

	updatePckry();
}

/**
 * 
 * @param element
 * @param str
 * @returns
 */
function getFirstByClassName(element,str){
	return element.getElementsByClassName(str)[0];
}

/**
 * 
 * @param element
 * @param execute_addition_fun
 */
function do_register_request(element, execute_addition_fun, make_automated_login) {

	execute_addition_fun = execute_addition_fun == undefined ? false
			: execute_addition_fun;

	make_automated_login = make_automated_login == undefined ? false
			: make_automated_login;
	
	if (isLogged) {

		getFirstByClassName(element,"register_msg").textContent = "You are already registered!";
		
		getFirstByClassName(element,"regist_name").value = "";
		getFirstByClassName(element,"regist_email").value = "";
		getFirstByClassName(element,"regist_password_1").value = "";
		getFirstByClassName(element,"regist_password_2").value = "";
		return;

	}

	var name = getFirstByClassName(element,"regist_name").value;
	var email = getFirstByClassName(element,"regist_email").value;
	var p1 = getFirstByClassName(element,"regist_password_1").value;
	var p2 = getFirstByClassName(element,"regist_password_2").value;

	if (!textRex.test(name)) {

		getFirstByClassName(element,"register_msg").textContent = "Invalid Name";

		getFirstByClassName(element,"regist_name").value ="";
		return;
	}
	if (!emailRex.test(email)) {

		getFirstByClassName(element,"register_msg").textContent = "Invalid Email";

		getFirstByClassName(element,"regist_email").value = "";
		return;
	}
	if (!textRex.test(p1)) {

		getFirstByClassName(element,"register_msg").textContent = "Invalid Password";

		getFirstByClassName(element,"regist_password_1").value = "";
		return;
	}
	if (p1 != p2) {

		getFirstByClassName(element,"register_msg").textContent = "Unequal Password Confirmation";

		getFirstByClassName(element,"regist_password_2").value = "";
		return;
	}
	
	$
			.post(
					register_path,
					{
						name : name,
						password1 : p1,
						password2 : p2,
						email : email
					},
					function(data) {

						var obj = getJsonObject(data);
						
						if (obj.type == "success") {

							getFirstByClassName(element,"register_msg").textContent = "You are registered!";
							
							getFirstByClassName(element,"regist_name").value = "";
							getFirstByClassName(element,"regist_email").value = "";
							getFirstByClassName(element,"regist_password_1").value = "";
							getFirstByClassName(element,"regist_password_2").value = "";

							if (execute_addition_fun) {

								getFirstByClassName(element,"layer_one").style.display = "none";
								getFirstByClassName(element,"layer_two").style.display = "initial";
								getFirstByClassName(element,"layer_three").style.display = "none";

							}

							if(make_automated_login){
								make_login(email, p1);
							}
							
						} else {

							getFirstByClassName(element,"register_msg").textContent = obj.msg;

							getFirstByClassName(element,"regist_name").value = "";
							getFirstByClassName(element,"regist_email").value = "";
							getFirstByClassName(element,"regist_password_1").value = "";
							getFirstByClassName(element,"regist_password_2").value = "";

						}

					});

}

/**
 * 
 */
function do_login_request(element, execute_addition_fun) {

	execute_addition_fun = execute_addition_fun == undefined ? false
			: execute_addition_fun;

	if (isLogged) {

		getFirstByClassName(element,"login_msg").textContent = "You are already logged in!";
		
		getFirstByClassName(element,"regist_name").value = "";
		getFirstByClassName(element,"regist_email").value = "";
		getFirstByClassName(element,"regist_password_1").value = "";
		getFirstByClassName(element,"regist_password_2").value = "";
		return;

	}

	var email_temp = getFirstByClassName(element,"login_email").value;
	var password_temp = getFirstByClassName(element,"login_password").value;

	if (!emailRex.test(email_temp)) {

		getFirstByClassName(element,"login_msg").textContent = "Invalid Email";
		getFirstByClassName(element,"login_email").value = "";
		return;
	}
	if (!textRex.test(password_temp)) {

		getFirstByClassName(element,"login_msg").textContent = "Invalid Password";
		getFirstByClassName(element,"login_password").value = "";
		return;
	}

	email = email_temp;
	password = password_temp;

	$
			.post(
					login_path,
					{
						email : email_temp,
						password : password_temp
					},
					function(data) {

						var obj = getJsonObject(data);

						if (obj.message == "true") {

							getFirstByClassName(element,"login_msg").textContent =  "You are logged in!";

							getFirstByClassName(element,"login_email").value = "";
							getFirstByClassName(element,"login_password").value = "";

							if (execute_addition_fun) {

								getFirstByClassName(element,"layer_one").style.display = "none";
								getFirstByClassName(element,"layer_two").style.display = "none";
								getFirstByClassName(element,"layer_three").style.display = "initial";

							}

							initiate_login(obj);

						} else {

							getFirstByClassName(element,"login_msg").textContent =  obj.message;

							getFirstByClassName(element,"login_email").value = "";
							getFirstByClassName(element,"login_password").value = "";
						}
					});
}

/**
 * 
 * @param email_temp
 * @param password_temp
 */
function make_login(email_temp, password_temp) {

	$.post(login_path, {
		email : email_temp,
		password : password_temp
	}, function(data) {

		var obj = getJsonObject(data);

		if (obj.message == "true")
			initiate_login(obj);			
		
	});
}

/**
 * 
 */
function make_already_login() {

	$.post(login_path, {
		alreadylogged : ""
	}, function(data) {

		var obj = getJsonObject(data);

		if (obj.message == "true")
			initiate_login(obj);

	});
}

/**
 * 
 * @param timestamp_string
 * @returns {String}
 */
function convert_timestamp(timestamp_string) {

	var dateExpires = timestamp_string.split(" ");
	var dateParts = dateExpires[0].split("-");

	return dateParts[2] + "." + dateParts[1] + "." + dateParts[0] + " "
			+ dateExpires[1];

}

/**
 * 
 */
function setSB_gimmic_best_surebet(best_surebet) {

	var element = create_initiate_element("gimmic_best_surebet_template");

	getFirstByClassName(element,"bs_sport").textContent = best_surebet.sport;
	getFirstByClassName(element,"bs_team_1").textContent = best_surebet.t1;
	getFirstByClassName(element,"bs_team_2").textContent = best_surebet.t2;

	var vec = element.getElementsByClassName("bs_quote");
	for (var i = 0; i < vec.length; i++)
		vec[i].textContent = roundToN(best_surebet.quote, 2) + " %";

	getFirstByClassName(element,"bs_date").textContent = convert_timestamp(best_surebet.timestamp);

	packery_base.appendChild(element);
	setup_packery(element);

}

/**
 * 
 */
function setSB_gimmic_text_imprint() {
	setSB_gimmic_text_gen("gimmic_imprint_text_template", "imprint_text_div");
}

/**
 * 
 */
function setSB_gimmic_text_regist_login() {

	setSB_gimmic_text_gen("gimmic_regist_login_text_template",
			"regist_login_text_div");

	var t = document.getElementById("regist_login_text_div");

	setListenerForm(t);

	t.getElementsByClassName("button_regist")[0].onclick = function() {

		do_register_request(t, false, true);

	};

	t.getElementsByClassName("button_login")[0].onclick = function() {

		do_login_request(t);

	};
}

/**
 * 
 */
function initiate_login(obj) {

	var userName = obj.user_name;
	var credits = obj.credits;

	for (var i = 0; i < obj.bought_surebets.length; i++)
		bought_surebets.push(obj.bought_surebets[i]);

	email = obj.email;
	password = obj.password;
	agreement_end_timestamp = obj.agreement_end_timestamp;
	userId = obj.user_id;

	var user_tile = document.getElementById("user_tile");

	user_tile.getElementsByClassName("account_name")[0].textContent = userName;

	var t = user_tile.getElementsByClassName("account_credits")[0];
	t.textContent = credits;
	t.style.textDecoration = "underline";
	t.style.cursor = "pointer";
	t.onclick = function() {
		if (isLogged){
			setSB_paypal();
			setBehind("user_tile","paypal_tile");
		}
	};

	user_tile.getElementsByClassName("credtr")[0].style.display = "initial";
	user_tile.getElementsByClassName("packtr")[0].style.display = "none";

	var button = document.getElementById("user_tile").getElementsByClassName(
			"user_info_1_button")[0];

	button.textContent = "Logout";
	button.onclick = initiate_logout;

	var vec = packery_base.getElementsByClassName("gimmic_text link_user_text");
	for (var i = 0; i < vec.length; i++)
		vec[i].textContent = "locoti.com/index.php?aff=" + userId;

	isLogged = true;
	uniqueUpdate = true;
	isStopped = false;
	
	if (isStopped)
		packery_base.getElementsByClassName("stop_button")[0].textContent = "Start Timer";
	else
		packery_base.getElementsByClassName("stop_button")[0].textContent = "Stop Timer";

	if(openPaypal){
		setSB_paypal();
		setBehind("buy_credits_tile","paypal_tile");
		openPaypal = false;
	}
	
}

/**
 * 
 */
function initiate_logout() {

	agreement_end_timestamp = 0;
	userId = null;
	bought_surebets = [];
	credits = 0;
	email = "";
	hasFullAccess = false;
	isLogged = false;
	uniqueUpdate = true;

	var user_tile = document.getElementById("user_tile");

	user_tile.getElementsByClassName("account_name")[0].textContent = "You";

	var t = user_tile.getElementsByClassName("account_credits")[0];
	t.textContent = 0;
	t.style.textDecoration = "none";
	t.style.cursor = "none";
	t.onclick = function() {

	};

	$.post(logout_path, {
	}, function(data) {

	});
	
	if (isStopped)
		packery_base.getElementsByClassName("stop_button")[0].textContent = "Start Timer";
	else
		packery_base.getElementsByClassName("stop_button")[0].textContent = "Stop Timer";

	user_tile.getElementsByClassName("credtr")[0].style.display = "none";
	user_tile.getElementsByClassName("packtr")[0].style.display = "initial";

	this.textContent = "Register/Login";
	this.onclick = function() {
		setSB_gimmic_text_regist_login();
		updatePckry();
	};

	var vec = packery_base.getElementsByClassName("link_user_text");
	for (var i = 0; i < vec.length; i++)
		vec[i].textContent = "locoti.com/index.php?aff=userId";

}

/**
 * 
 */
function setSB_gimmic_text_aboutus() {
	setSB_gimmic_text_gen("gimmic_aboutus_text_template", "aboutus_text_div");
}

/**
 * 
 */
function setSB_gimmic_text_contact() {

	setSB_gimmic_text_gen("gimmic_contact_text_template", "contact_text_div");

	var t = document.getElementById("contact_text_div");

	t.getElementsByClassName("button")[0].onclick = function() {
		send("contact_text_div");
	}

	setListenerForm(t);

}

/**
 * 
 */
function send(id) {

	var t = document.getElementById(id);
	
	var contact_email_e = t.getElementsByClassName('contact_email')[0];
	
	if (!emailRex.test(contact_email_e.value)) {
		contact_email_e.value = "Invalid Email";
		return;
	}
	
	var contact_message_element = t.getElementsByClassName('contact_message')[0];
		
	var error_text = "Please, type a message!";
	if(contact_message_element.value == "" || contact_message_element.value == error_text){
		contact_message_element.value = error_text;
		return 
	}
	
	var contact_name_element = t.getElementsByClassName('contact_name')[0];
		
	$.post("control/sendEmail.php", {
		contact_name : contact_name_element.value,
		contact_message : contact_message_element.value,
		contact_email : contact_email_e.value
	}, function(data) {

		contact_name_element.value = "";
		contact_message_element.value = "Your Message has been send!";
		contact_email_e.value = "";
		
	});

}

/*
 * 
 */
function setSB_gimmic_text_gen(template_id, objId) {

	if (addition_array[objId] != null)
		return;

	addition_array[objId] = "";

	var t = create_initiate_element(template_id, objId);
	packery_base.appendChild(t);
	setup_packery(t);
	
	var itemElems = pckry.items;

	var num = -1;

	for (var i = 0; i < itemElems.length; i++) {

		var elem = itemElems[i].element;

		if (elem.id == objId)
			num = i;

	}

	if (num > -1 && itemElems.length > 2) {

		var tempItemElement = itemElems[num];

		for (var i = itemElems.length - 2; i > 1; i--)
			itemElems[i + 1] = itemElems[i];

		itemElems[2] = tempItemElement;

	}

	setDeactivationActionListener(t, objId);

	updatePckry();

}

/**
 * 
 */
function setSB_open_calculator() {

	var element = create_initiate_element("open_calculator_template", "open_tile");

	packery_base.appendChild(element);
	setup_packery(element);

}

/**
 * 
 */
function setSB_gimmic_fact(text) {

	var element = create_initiate_element("gimmic_template_fact");

	var list = element.getElementsByClassName("fact_text");
	for (var i = 0; i < list.length; i++)
		list[i].textContent = text;

	packery_base.appendChild(element);
	setup_packery(element);

}

/**
 * 
 */
function setSB_gimmic_news_letter_reg() {

	var element = create_initiate_element("template_newsletter","newsletter_email");

	setListenerForm(element);

	packery_base.appendChild(element);
	setup_packery(element);

}

/**
 * 
 */
function setSB_nc(id, ncSurebet, ncObject, colorCode) {

	var t, t2, t3, t4;

	var div = Math.ceil((ncSurebet.broker_data.length + 2) / 3) - 1;

	var startRisk = 100;

	var length = ( 453 + 151 * div) + "px";

	t = create_initiate_element("nc_template");

	t.getElementsByClassName("new_calc")[0].style.backgroundColor = ncObject["colorCode"];

	t.style.height = length;

	t2 = t.getElementsByClassName("nc_table")[0];
	t3 = t2.firstChild;

	var broker_data = ncSurebet.broker_data;

	t.getElementsByClassName("new_calc_bettype_text nc_header_text")[0].textContent = ncObject.bettypeN;

	var tempText = broker_data[0].t1 + " - " + broker_data[0].t2;
	t.getElementsByClassName("new_calc_team_text nc_header_text")[0].textContent = tempText;
	tempText = "(" + ncSurebet.expires + " " + ncSurebet.date + ")";
	t.getElementsByClassName("new_calc_date_text nc_header_text")[0].textContent = tempText;

	var league_title = "";
	league_title += broker_data[0].sport_title + " - "
	league_title += broker_data[0].country_title + " - "
	league_title += broker_data[0].league_title;

	var league_text_element = t
			.getElementsByClassName("new_calc_league_text nc_header_text")[0];
	league_text_element.textContent = league_title;

	if (league_title.length > 25) {
		var ratio = 100 * (55 / league_title.length);
		var size = parseInt(ratio);
		league_text_element.style.fontSize = size + "%";
	}

	var oddMaxIndex1 = 0;
	var oddMaxIndex2 = 0;
	var oddMaxIndex3 = 0;

	for (var i = 1; i < ncObject.broker_amount; i++) {

		if (ncObject.oddArray[oddMaxIndex1 * ncObject.odd_amount + 0] < ncObject.oddArray[i
				* ncObject.odd_amount + 0])
			oddMaxIndex1 = i;

		if (ncObject.oddArray[oddMaxIndex2 * ncObject.odd_amount + 1] < ncObject.oddArray[i
				* ncObject.odd_amount + 1])
			oddMaxIndex2 = i;

		if (broker_data[i].odd_values.length == 3) {
			if (ncObject.oddArray[oddMaxIndex3 * ncObject.odd_amount + 2] < ncObject.oddArray[i
					* ncObject.odd_amount + 2])
				oddMaxIndex3 = i;
		}
	}

	var textc1 = "risk_input";
	var textc2 = "middle";
	var textc3 = "win_input";

	var tempElement = null;
	var list = null;

	tempElement = t.getElementsByClassName(textc1)[0];

	tempElement.setAttribute("pv", "");
	tempElement.setAttribute("sbetid", id);
	tempElement.onkeydown = onclick_down_event_listener;

	tempElement.onkeyup = function(event) {

		var value = this.value;
		this.value = value.replace(",", ".");

		var risk = parseFloat(value);
		if (!isNaN(risk))
			updateNCalculatorRisk(this, risk);

	}

	tempElement = t.getElementsByClassName(textc3)[0];
	tempElement.setAttribute("pv", "");
	tempElement.setAttribute("sbetid", id);
	tempElement.onkeydown = onclick_down_event_listener;

	tempElement.onkeyup = function(event) {

		var value = this.value;
		this.value = value.replace(",", ".");

		var win = parseFloat(value);
		if (!isNaN(win))
			updateNCalculatorWin(this, win);

	}

	//
	tempElement = t.getElementsByClassName("left")[0];
	tempElement.setAttribute("sbetid", id);
	tempElement.setAttribute("objtitle", "risk_input");
	tempElement.onclick = initiate_onclick_focus_listener;

	//
	tempElement = t.getElementsByClassName("right")[0];
	tempElement.setAttribute("sbetid", id);
	tempElement.setAttribute("objtitle", "win_input");
	tempElement.onclick = initiate_onclick_focus_listener;

	tempElement = t.getElementsByClassName("ncqc1_input")[0];
	tempElement.setAttribute("sbetid", id);
	tempElement.onkeydown = onclick_down_event_listener;

	tempElement.onkeyup = function(event) {

		var value = this.value;
		this.value = value.replace(",", ".");

		var ncqc = parseFloat(value);
		if (!isNaN(ncqc))
			updateNCalculatorBetValue(this, ncqc, 1);

	}

	tempElement = t.getElementsByClassName("ncqc2_input")[0];
	tempElement.setAttribute("sbetid", id);
	tempElement.onkeydown = onclick_down_event_listener;

	tempElement.onkeyup = function(event) {

		var value = this.value;
		this.value = value.replace(",", ".");

		var ncqc = parseFloat(value);
		if (!isNaN(ncqc))
			updateNCalculatorBetValue(this, ncqc, 2);

	}

	tempElement = t.getElementsByClassName("ncqc3_input")[0];

	if (ncObject.odd_amount == 3) {

		tempElement.setAttribute("sbetid", id);

		tempElement.onkeydown = onclick_down_event_listener;

		tempElement.onkeyup = function(event) {

			var value = this.value;
			this.value = value.replace(",", ".");

			var ncqc = parseFloat(value);
			if (!isNaN(ncqc))
				updateNCalculatorBetValue(this, ncqc, 3);

		}

	} else{
		tempElement.value = "";
	}
		
	title_row = create_initiate_element("title_row");
	t2.insertBefore(title_row, t3);
	
	t.getElementsByClassName("oddtitle1")[0].textContent = ncSurebet.bettype_structure.odds[0].title;
	t.getElementsByClassName("oddtitle2")[0].textContent = ncSurebet.bettype_structure.odds[1].title;
	
	if (ncObject.odd_amount == 3) {
		t.getElementsByClassName("oddtitle3")[0].textContent =  ncSurebet.bettype_structure.odds[2].title;;
	} else{
		t.getElementsByClassName("oddtitle3")[0].textContent = "";
	}
	
	ncObject["currentQuote1"] = oddMaxIndex1;
	ncObject["currentQuote2"] = oddMaxIndex2;
	ncObject["currentQuote3"] = oddMaxIndex3;
	ncObject["risk"] = startRisk;
	
	for (var i = 0; i < ncSurebet.broker_data.length; i++) {

		t4 = document.getElementById("table_row_nc").cloneNode(true);

		var ncp_1 = t4.getElementsByClassName("ncq_1")[0];
		var ncp_2 = t4.getElementsByClassName("ncq_2")[0];
		var ncp_3 = t4.getElementsByClassName("ncq_3")[0];

		var ncp_div_1 = t4.getElementsByClassName("nc_div_1")[0];
		var ncp_div_2 = t4.getElementsByClassName("nc_div_2")[0];
		var ncp_div_3 = t4.getElementsByClassName("nc_div_3")[0];

		ncp_div_1.textContent = broker_data[i].odd_values[0][1];
		ncp_div_2.textContent = broker_data[i].odd_values[1][1];

		ncp_1.setAttribute("oddNumber", 1);
		ncp_2.setAttribute("oddNumber", 2);
		ncp_1.setAttribute("brokerNumber", i);
		ncp_2.setAttribute("brokerNumber", i);
		ncp_1.setAttribute("sbetID", id);
		ncp_2.setAttribute("sbetID", id);

		ncp_1.onclick = function() {
			updateNCalculatorOdd(this);
		};
		ncp_2.onclick = function() {
			updateNCalculatorOdd(this);
		};

		if (ncObject.odd_amount == 3) {
			ncp_div_3.textContent = broker_data[i].odd_values[2][1];
			ncp_3.setAttribute("oddNumber", 3);
			ncp_3.setAttribute("brokerNumber", i);
			ncp_3.setAttribute("sbetID", id);
			ncp_3.onclick = function() {
				updateNCalculatorOdd(this);
			};

		} else
			ncp_3.style.display = "none";

		var broker_image_name = broker_icon_path
				+ broker_data[i].broker.toLowerCase() + "_w.png";
			
		var link = brokerLinkAccoArray[broker_data[i].broker.toLowerCase()];
		
		if(link == null)
			link = "http://www.google.com";
		
		t4.getElementsByClassName("nc_image")[0].src = broker_image_name;
		t4.getElementsByClassName("broker_link")[0].href = "http://www.nullrefer.com/?"+link;
		
		t4.removeAttribute('id');
		t2.insertBefore(t4, t3);

	}

	var cq1 = ncObject.oddArray[ncObject["currentQuote1"] * ncObject.odd_amount
			+ 0];
	var cq2 = ncObject.oddArray[ncObject["currentQuote2"] * ncObject.odd_amount
			+ 1];
	var cq3 = -1;

	if (ncObject.odd_amount == 3)
		cq3 = ncObject.oddArray[ncObject["currentQuote3"] * ncObject.odd_amount	+ 2];

	var t2s = t.getElementsByClassName("table_row_nc");

	for (var i = 0; i < t2s.length; i++) {

		var ncp_1 = t2s[i].getElementsByClassName("ncq_1")[0];
		var ncp_2 = t2s[i].getElementsByClassName("ncq_2")[0];
		var ncp_3 = t2s[i].getElementsByClassName("ncq_3")[0];

		var q1 = ncObject.oddArray[i * ncObject.odd_amount + 0];
		var q2 = ncObject.oddArray[i * ncObject.odd_amount + 1];
		var q3 = -1;

		if (ncObject.odd_amount == 3)
			q3 = ncObject.oddArray[i * ncObject.odd_amount + 2];

		ncp_1.style.color = "#fff";
		ncp_2.style.color = "#fff";

		if (!isSurebet(q1, cq2, cq3))
			ncp_1.style.color = "#000";
		if (!isSurebet(cq1, q2, cq3))
			ncp_2.style.color = "#000";

		if (ncObject.odd_amount == 3) {

			ncp_3.style.color = "#fff";

			if (!isSurebet(cq1, cq2, q3))
				ncp_3.style.color = "#000";

		} else
			ncp_3.textContent = "";

	}

	if (ncObject.odd_amount != 3) {
		var valueRow = t.getElementsByClassName("bet_value_row")[0];
		valueRow.getElementsByClassName("ncqc3")[0].style.display = "none";
	}

	var deactivationImage = t.getElementsByClassName("deactivation_icon")[0];
	deactivationImage.setAttribute("sbetid", id);
	deactivationImage.onclick = function() {

		close_nc(this.getAttribute("sbetid"));
		if (last_open_surebet_id == this.getAttribute("sbetid"))
			last_open_surebet_id = null;
		resetTileColor();
		pckry.layout();
	};

	list = t.getElementsByClassName(ncObject.sportImage);
	for (var i = 0; i < list.length; i++)
		list[i].setAttribute("src", sportImageName);

	if (ncObject.odd_amount != 3) {
		list = t.getElementsByClassName("nc_quote_cell");
		for (var i = 0; i < list.length; i++)
			list[i].style.width = "160px";
	}

	t.setAttribute("id", "nc_" + id);
	t.setAttribute("colorCode", colorCode);

	setListenerForm(t);

	packery_base.appendChild(t);

	setup_packery(t);

	return ncObject;
}

/**
 * 
 */
function onclick_down_event_listener(event) {

	return checkInput(event.charCode, event.keyCode, this.value);

}

/**
 * 
 * @param char
 * @param code
 * @param value
 * @returns {Boolean}
 */
function checkInput(char, code, value) {

	// test numbers
	if ((48 <= code && code <= 57) || (96 <= code && code <= 105)) {

		if (value.indexOf(".") == -1) {
			if (value.length > 5)
				return false
		} else {
			if (value.length > 6)
				return false;
		}

		return true;
	}

	// all valid key codes
	if (8 <= code && code <= 46)
		return true;
	if (91 <= code && code <= 93)
		return true;
	if (112 <= code && code <= 123)
		return true;
	if (144 <= code && code <= 145)
		return true;

	// all invalid key codes

	// exception (test period)
	if (code == 190 || code == 188 || code == 110) {
		if (value.indexOf(".") == -1)
			return true
		else
			return false;
	}

	if (65 <= code && code <= 90)
		return false;
	if (106 <= code && code <= 111)
		return false;
	if (186 <= code && code <= 192)
		return false;
	if (219 <= code && code <= 222)
		return false;

	return false;

}

/**
 * 
 */
function setSB_nc_standalone(numOdds,odds1,odds2,odds3) {

	var id = "calc_standalone";

	var textc1 = "risk_input";
	var textc2 = "middle";
	var textc3 = "win_input";

	var tempElement = null;
	var list = null;

	var t = create_initiate_element("nc_standalone_template", "nc_" + id + "_"
			+ numOdds)

	var oddArray = null;
			
	if(numOdds == 4){
		t.setAttribute("colorCode", "#00cc99");
		t.getElementsByClassName("new_calc")[0].style.backgroundColor = "#990000";
		oddArray = Array(odds1, odds2);
		t.getElementsByClassName("nc_header_text")[0].textContent = "Back/Lay-Odds-Calculator";
	}
	else
	if(numOdds == 3){
	
		t.setAttribute("colorCode", "#6fceec");
		t.getElementsByClassName("new_calc")[0].style.backgroundColor = "#6fceec";	
		oddArray = Array(odds1, odds2, odds3);
		t.getElementsByClassName("nc_header_text")[0].textContent = "3-Odds-Calculator";
	}
	else
	{
		t.setAttribute("colorCode", "#00cc99");
		t.getElementsByClassName("new_calc")[0].style.backgroundColor = "#00cc99";
		oddArray = Array(odds1, odds2);
		t.getElementsByClassName("nc_header_text")[0].textContent = "2-Odds-Calculator";
	}
	
	var calc_id = id + "_" + numOdds;
		
	t.getElementsByClassName("left")[0].setAttribute("sbetid", t.id);
	t.getElementsByClassName("left")[0].onclick = function() {

		var id = this.getAttribute("sbetid");
		var t1 = document.getElementById(id);
		var t2 = t1.getElementsByClassName("risk_input")[0];
		t2.focus();

	}

	t.getElementsByClassName("right")[0].setAttribute("sbetid", t.id);
	t.getElementsByClassName("right")[0].onclick = function() {

		var id = this.getAttribute("sbetid");
		var t1 = document.getElementById(id);
		var t2 = t1.getElementsByClassName("win_input")[0];
		t2.focus();

	}

	if (numOdds == 2 || numOdds == 4) {
		t.getElementsByClassName("ncq_3")[0].style.display = "none";
		t.getElementsByClassName("ncqc3")[0].style.display = "none";

		list = t.getElementsByClassName("nc_quote_cell");
		for (var i = 0; i < list.length; i++)
			list[i].style.width = "160px";

	}

	tempElement = t.getElementsByClassName(textc1)[0];

	tempElement.setAttribute("pv", "");
	tempElement.setAttribute("sbetid", calc_id);
	tempElement.onkeydown = onclick_down_event_listener;

	tempElement.onkeyup = function(event) {

		var value = this.value;
		this.value = value.replace(",", ".");

		var risk = parseFloat(value);
		if (!isNaN(risk))
			updateNCalculatorRisk(this, risk);

	}

	tempElement = t.getElementsByClassName(textc3)[0];
	tempElement.setAttribute("pv", "");
	tempElement.setAttribute("sbetid", calc_id);
	tempElement.onkeydown = onclick_down_event_listener;

	tempElement.onkeyup = function(event) {

		var value = this.value;
		this.value = value.replace(",", ".");

		var win = parseFloat(value);
		if (!isNaN(win))
			updateNCalculatorWin(this, win);

	}

	//
	tempElement = t.getElementsByClassName("left")[0];
	tempElement.setAttribute("sbetid", calc_id);
	tempElement.setAttribute("objtitle", "risk_input");
	tempElement.onclick = initiate_onclick_focus_listener;

	//
	tempElement = t.getElementsByClassName("right")[0];
	tempElement.setAttribute("sbetid", calc_id);
	tempElement.setAttribute("objtitle", "win_input");
	tempElement.onclick = initiate_onclick_focus_listener;

	//
	tempElement = t.getElementsByClassName("ncqc1_input")[0];
	tempElement.setAttribute("sbetid", calc_id);
	tempElement.onkeydown = onclick_down_event_listener;

	tempElement.onkeyup = function(event) {

		var value = this.value;
		this.value = value.replace(",", ".");

		var ncqc = parseFloat(value);
		if (!isNaN(ncqc))
			updateNCalculatorBetValue(this, ncqc, 1);

	}

	tempElement = t.getElementsByClassName("ncqc2_input")[0];
	tempElement.setAttribute("sbetid", calc_id);
	tempElement.onkeydown = onclick_down_event_listener;

	tempElement.onkeyup = function(event) {

		var char = event.charCode;
		var code = event.keyCode;
		var value = this.value;

		this.value = value.replace(",", ".");

		var ncqc = parseFloat(value);
		if (!isNaN(ncqc))
			updateNCalculatorBetValue(this, ncqc, 2);

	}

	tempElement = t.getElementsByClassName("ncqc1_input_odd")[0];
	tempElement.setAttribute("sbetid", calc_id);
	tempElement.value = oddArray[0];
	tempElement.onkeydown = onclick_down_event_listener;

	tempElement.onkeyup = function(event) {

		var char = event.charCode;
		var code = event.keyCode;
		var value = this.value;

		this.value = value.replace(",", ".");

		var ncqc = parseFloat(value);
		if (!isNaN(ncqc)) {
			var id = this.getAttribute("sbetid");
			ncObjects[id]["oddArray"][0] = ncqc;
			//if(document.getElementById('txtBookieOdds1') === null)
			updateNCalculator(id);
		}

	}

	tempElement = t.getElementsByClassName("ncqc2_input_odd")[0];
	tempElement.setAttribute("sbetid", calc_id);
	tempElement.value = oddArray[1];
	tempElement.onkeydown = onclick_down_event_listener;

	tempElement.onkeyup = function(event) {

		var char = event.charCode;
		var code = event.keyCode;
		var value = this.value;

		this.value = value.replace(",", ".");

		var ncqc = parseFloat(value);
		if (!isNaN(ncqc)) {
			var id = this.getAttribute("sbetid");
			ncObjects[id]["oddArray"][1] = ncqc;
			//if(document.getElementById('txtBookieOdds2') === null)
			updateNCalculator(id);
		}

	}

	if (numOdds == 3) {

		tempElement = t.getElementsByClassName("ncqc3_input")[0];
		tempElement.setAttribute("sbetid", calc_id);
		tempElement.onkeydown = onclick_down_event_listener;

		tempElement.onkeyup = function(event) {

			var char = event.charCode;
			var code = event.keyCode;
			var value = this.value;

			this.value = value.replace(",", ".");

			var ncqc = parseFloat(value);

			if (!isNaN(ncqc))
				updateNCalculatorBetValue(this, ncqc, 3);

		}

		tempElement = t.getElementsByClassName("ncqc3_input_odd")[0];
		tempElement.setAttribute("sbetid", calc_id);
		tempElement.value = oddArray[2];
		tempElement.onkeydown = onclick_down_event_listener;

		tempElement.onkeyup = function(event) {

			var char = event.charCode;
			var code = event.keyCode;
			var value = this.value;

			this.value = value.replace(",", ".");

			var ncqc = parseFloat(value);
			if (!isNaN(ncqc)) {
				var id = this.getAttribute("sbetid");
				ncObjects[id]["oddArray"][2] = ncqc;
				updateNCalculator(id);
			}

		}

	} else {

		tempElement = t.getElementsByClassName("ncqc3_input")[0];
		tempElement.value = "";

		if (numOdds == 4) {
			tempElement = t.getElementsByClassName("title_row")[0];
			tempElement.style.display = "table-row";
		}
		
	}

	var deactivationImage = t.getElementsByClassName("deactivation_icon")[0];
	deactivationImage.setAttribute("sbetid", id + "_" + numOdds);
	deactivationImage.setAttribute("numOdds", numOdds);
	deactivationImage.onclick = function() {

		close_nc(this.getAttribute("sbetid"));
		
		if (this.getAttribute("numOdds") == 4){
			standalone_calculator_is_open_4 = false;
		}
		else
		if (this.getAttribute("numOdds") == 3){
			standalone_calculator_is_open_3 = false;
		}
		else
		{
			standalone_calculator_is_open_2 = false;
		}

		pckry.layout();

	};

	var ncObject = {
		oddArray : oddArray,
		odd_amount : numOdds,
		risk : 100,
		currentQuote1 : 0,
		currentQuote2 : 0,
		currentQuote3 : 0,
		broker_amount : 1
	};

	ncObjects[id + "_" + numOdds] = ncObject;

	setListenerForm(t);

	packery_base.appendChild(t);
	//setup_packery(t);

	updateNCalculator(id + "_" + numOdds);

}

/**
 * 
 */
function initiate_onclick_focus_listener() {

	var id = this.getAttribute("sbetid");
	var title = this.getAttribute("objtitle");

	var t1 = document.getElementById("nc_" + id);
	var t2 = t1.getElementsByClassName(title)[0];

	t2.focus();

	var value = t2.value;
	t2.value = "";
	t2.value = value;
}

/**
 * 
 * @param id
 */
function close_nc(id) {

	var t = document.getElementById("nc_" + id);
	delete ncObjects[id];
	pckry.remove(t);
	pckry.layout();

}

/**
 * 
 * @param num
 * @param decimal
 * @returns {Number}
 */
function roundToN(num, decimal) {
	num = parseFloat(num);
	return Math.round(num * 100) / 100;
}

/**
 * 
 */
function updateNCalculatorBetValue(element, ncqc_value, num) {

	var id = element.getAttribute("sbetID");
	var ncObject = ncObjects[id];
	ncObject["risk"] = ncqc_value;

	if (num == 1)
		ncObject["risk"] *= ncObject.oddArray[ncObject["currentQuote1"]	* ncObject.odd_amount + 0];
	else if (num == 2)
		ncObject["risk"] *= ncObject.oddArray[ncObject["currentQuote2"]	* ncObject.odd_amount + 1];
	else if (num == 3)
		ncObject["risk"] *= ncObject.oddArray[ncObject["currentQuote3"]	* ncObject.odd_amount + 2];

	ncObject["risk"] /= ncObject["sb_factor"]

	var tempValue = element.value;
	updateNCalculator(id);
	element.value = tempValue;

}

/**
 * 
 */
function updateNCalculatorWin(element, win) {

	var id = element.getAttribute("sbetID");
	var ncObject = ncObjects[id];
	ncObject["risk"] = win / (ncObject["sb_factor"] - 1);

	var tempValue = element.value;
	updateNCalculator(id);
	element.value = tempValue;

}

/**
 * 
 */
function updateNCalculatorRisk(element, risk) {

	var id = element.getAttribute("sbetID");
	var ncObject = ncObjects[id];
	ncObject["risk"] = risk;

	var tempValue = element.value;
	updateNCalculator(id);
	element.value = tempValue;

}

function updateNCalculatorOdd(element) {

	var id = element.getAttribute("sbetID");
	var ncObject = ncObjects[id];

	if (element.getAttribute("oddnumber") == "1")
		ncObject["currentQuote1"] = parseInt(element.getAttribute("brokernumber"));
	else if (element.getAttribute("oddnumber") == "2")
		ncObject["currentQuote2"] = parseInt(element.getAttribute("brokernumber"));
	else if (element.getAttribute("oddnumber") == "3")
		ncObject["currentQuote3"] = parseInt(element.getAttribute("brokernumber"));

	var tempValue = element.value;
	updateNCalculator(id);
	element.value = tempValue;

}

/**
 * 
 * @param q1
 * @param q2
 * @param q3
 * @returns {Boolean}
 */
function isSurebet(q1, q2, q3) {

	var max = 0;

	max += 1 / q1;
	max += 1 / q2;

	if (q3 > 0)
		max += 1 / q3;

	max = 1 - max;

	if (max > 0)
		return true;

	return false;
}

/**
 * 
 * @param id
 */
function updateNCalculator(id) {

	var t = document.getElementById("nc_" + id);
	var t2s = t.getElementsByClassName("table_row_nc");

	var ncObject = ncObjects[id];

	if (id != "calc_standalone_2" && id != "calc_standalone_3" && id != "calc_standalone_4") {
		for (var i = 0; i < t2s.length; i++) {

			var ncp_1 = t2s[i].getElementsByClassName("ncq_1")[0];
			var ncp_2 = t2s[i].getElementsByClassName("ncq_2")[0];
			var ncp_3 = t2s[i].getElementsByClassName("ncq_3")[0];

			var ncp_div_1 = t2s[i].getElementsByClassName("nc_div_1")[0];
			var ncp_div_2 = t2s[i].getElementsByClassName("nc_div_2")[0];
			var ncp_div_3 = t2s[i].getElementsByClassName("nc_div_3")[0];

			ncp_div_1.className = "nc_div_1 unmarked_div";
			ncp_div_2.className = "nc_div_2 unmarked_div";

			if (ncObject["currentQuote1"] == i)
				ncp_div_1.className = "nc_div_1 marked_div";
			if (ncObject["currentQuote2"] == i)
				ncp_div_2.className = "nc_div_2 marked_div";

			if (ncObject.odd_amount == 3) {

				ncp_div_3.className = "nc_div_3 unmarked_div";
				if (ncObject["currentQuote3"] == i)
					ncp_div_3.className = "nc_div_3 marked_div";
			}
		}
	}

	var max = 0;
	var layQuote = 1;
	
	if(id == "calc_standalone_4"){
		//console.log(ncObject);
		layQuote = ncObject.oddArray[ncObject["currentQuote2"] * ncObject.odd_amount + 1];
		layQuote = (1/(layQuote-1))+1;
		
		max += 1 / ncObject.oddArray[ncObject["currentQuote1"] * ncObject.odd_amount + 0];
		max += 1 / layQuote;
		
	}
	else{
//console.log(ncObject);
		max += 1 / ncObject.oddArray[ncObject["currentQuote1"] * ncObject.odd_amount + 0];

		max += 1 / ncObject.oddArray[ncObject["currentQuote2"] * ncObject.odd_amount + 1];
		
		if (ncObject.odd_amount == 3) {
			max += 1 / ncObject.oddArray[ncObject["currentQuote3"] * ncObject.odd_amount + 2];
		}

	}

	max = 1 / max;

	ncObject["sb_factor"] = max;

	var risk = ncObject.risk;
	var win = ncObject.risk * max;

	var textc1 = "risk_input";
	var textc2 = "middle";
	var textc3 = "win_input";

	var textc2_2 = "new_calc_league_bet_profit_text ncl_btext valuediv";
	var textc3_2 = "new_calc_league_bet_win_text ncl_btext valuediv";

	if (max > 1) {
		t.getElementsByClassName(textc2_2)[0].style.color = "#fff";
		t.getElementsByClassName(textc3_2)[0].style.color = "#fff";
	} else {
		t.getElementsByClassName(textc2_2)[0].style.color = "#000";
		t.getElementsByClassName(textc3_2)[0].style.color = "#000";
	}

	t.getElementsByClassName(textc1)[0].value = roundToN(risk, 2);

	t.getElementsByClassName(textc2)[0].textContent = (roundToN(
			(max - 1) * 100, 2));
	t.getElementsByClassName(textc3)[0].value = roundToN(win - risk, 2);

	var value1 = (risk * max);
	var value2 = (risk * max);
	var value3 = (risk * max);

	value1 /= ncObject.oddArray[ncObject["currentQuote1"] * ncObject.odd_amount
			+ 0];
	value2 /= ncObject.oddArray[ncObject["currentQuote2"] * ncObject.odd_amount
			+ 1];

	t.getElementsByClassName("ncqc1_input")[0].value = roundToN(value1, 2);
	// t.getElementsByClassName("ncqc2_input")[0].value = roundToN(value2, 2);
	// Start code by yug
		var bookie_comm = document.getElementById("txtBookieComm");
		var lay_comm = document.getElementById("txtLayComm");
		if(bookie_comm !== null && lay_comm !== null){
			var bookie_comm = bookie_comm.value;
			var lay_comm = lay_comm.value;
			if(bookie_comm == 0 && lay_comm == 0)
			{
				t.getElementsByClassName("ncqc2_input")[0].value = roundToN(value2, 2);
			}
			else
			{	
				var txtBookieStake = document.getElementById("txtBookieStake1").value;
				var txtBookieOdds = document.getElementById("txtBookieOdds1").value;
				var txtExchangeOdds = document.getElementById("txtBookieOdds2").value;
				t.getElementsByClassName("ncqc2_input")[0].value = roundToN(txtBookieStake*(1/(txtExchangeOdds-(lay_comm/100)))/(1/(1+((txtBookieStake*(txtBookieOdds-1)*(1-(bookie_comm/100)))/txtBookieStake))),2)
			}
		}else{
			t.getElementsByClassName("ncqc2_input")[0].value = roundToN(value2, 2);
		}
	// End code by yug
	if (ncObject.odd_amount == 3) {
		value3 /= ncObject.oddArray[ncObject["currentQuote3"]
				* ncObject.odd_amount + 2];
		t.getElementsByClassName("ncqc3_input")[0].value = roundToN(value3, 2);
	} else {
		t.getElementsByClassName("ncqc3_input")[0].value = "";
	}
	
}

/**
 * 
 */
function setSB_gimmic_rating(rating) {

	var element = create_initiate_element("gimmic_template_rating");
	var imageName = broker_icon_path + rating[0] + "_b.png";

	getFirstByClassName(element,"rating_broker_image").src = imageName;
	getFirstByClassName(element,"rating_text_2").textContent = rating[1];

	var img_str = "";
	for (var i = 0; i < rating[2]; i++)
		img_str += '<img class="rating_star_image" src="images/icons_2/star.png">';
	getFirstByClassName(element,"star_container").innerHTML = img_str;

	packery_base.appendChild(element);
	setup_packery(element);

}

/**
 * 
 */
function handleRequest(data) {

	var obj = getJsonObject(data);
		
	timer_counter = 0;
	uniqueUpdate = false;

	var sBets = obj.sbets;
	var facts = obj.facts;
	var rating = obj.rating;
	var best_surebet = obj.best_surebet;
	var date = new Date();
	var time = date.getTime() / 1000;

	hasFullAccess = agreement_end_timestamp > time;

	if (sBets != null) {

		var list = document.getElementsByClassName("delete_object");
		for (var i = 0; i < list.length; i++)
			pckry.remove(list[i]);

		var list = document.getElementsByClassName("sbet_main_element");
		for (var i = 0; i < list.length; i++)
			if(ncObjects[list[i].id]==null)
				pckry.remove(list[i]);
						
		pckry.fit(document.getElementById("buy_credits_tile"), 0, 0);
		pckry.fit(document.getElementById("faq_tile"), 0, 0);
		pckry.fit(document.getElementById("open_tile"), 0, 0);
		pckry.fit(document.getElementById("sort_tile"), 0, 0);
		pckry.fit(document.getElementById("paypal_tile"), 0, 0);
		pckry.fit(document.getElementById("fp_tile"), 0, 0);
		pckry.fit(document.getElementById("earn_money_tile"), 0, 0);
		pckry.fit(document.getElementById("user_tile"), 0, 0);
		pckry.fit(document.getElementById("timer_tile"), 0, 0);
		pckry.fit(document.getElementById("header_tile"), 0, 0);

		var indices_array = getMixedIndices(sBets.length, facts.length, rating.length,
				best_surebet != null);

		currentSurebets = sBets;

		var sort_counter = 0;
		var temp_sort_by_id = sort_by_id;
		
		if( temp_sort_by_id==1 ){
			sort_arr = sortDate(sBets);
		}
		else
		if( temp_sort_by_id==2 ){
			sort_arr = sortQuote(sBets);
		}		
		
		for (var i = 0; i < indices_array.length; i++) {

			if (indices_array[i][0] == 0){
				
				if(temp_sort_by_id==0){
					setSB(sBets[indices_array[i][1]], hasFullAccess);
				}
				else{
					setSB(sBets[sort_arr[sort_counter]], hasFullAccess);
					sort_counter++;	
				}
								
			}				
			else if (indices_array[i][0] == 1){
				setSB_gimmic_fact(facts[indices_array[i][1]]);
			}
			else if (indices_array[i][0] == 2){
				setSB_gimmic_rating(rating[indices_array[i][1]]);
			}
			else if (indices_array[i][0] == 3){
				// deactivated
				// setSB_open_calculator();
			}
			else if (indices_array[i][0] == 4){			
				setSB_gimmic_news_letter_reg();
			}
			else if (indices_array[i][0] == 5){
				setSB_gimmic_best_surebet(best_surebet);
			}

		}

	}

	updatePckry();

	var timeImage = packery_base.getElementsByClassName("timer_image")[0];

	timeImage.src = "images/icons_2/timer_b.png";
	timeImage.style.width = "48px";

	isUpdated = false;

}

/**
 * 
 * @param length
 */
function getMixedIndices(s_length, f_length, r_length, regardBestSurebet) {

	var indices_array = [];

	var j = 0;

	for (var i = 0; i < s_length; i++) {
		indices_array[j] = [ 0, i ];
		j++;
	}
	for (var i = 0; i < f_length; i++) {
		indices_array[j] = [ 1, i ];
		j++;
	}
	for (var i = 0; i < r_length; i++) {
		indices_array[j] = [ 2, i ];
		j++;
	}

	indices_array[j] = [ 3, 0 ];
	j++;
	indices_array[j] = [ 4, 0 ];
	j++;

	if (regardBestSurebet) {
		indices_array[j] = [ 5, 0 ];
		j++;
	}

	for (var i = 0; i < indices_array.length; i++) {

		var rindex = Math.floor(Math.random() * (indices_array.length - i)) + i;
		var tvalue = indices_array[i];

		indices_array[i] = indices_array[rindex];
		indices_array[rindex] = tvalue;

	}

	return indices_array;
}

/**
 * 
 */
function updateHomepage() {

	$.post(sbet_path, {}, function(data) {

		handleRequest(data);

	});

}

/**
 * 
 */
function updateTimer() {

	// IF A UNIQUE UPDATE WAS NOT TRIGGERED AND THE TIMER WAS STOPPED
	if (!uniqueUpdate && isStopped) {
		window.setTimeout("updateTimer()", 1000);
		return;
	}

	// IF THE TIMER WAS NOT STOPPED
	if (!isStopped)
		timer_counter += 1;

	var diff_time = Math.floor(timeEnd - timer_counter);

	var element = document.getElementById('timer_tile');

	// IF TIME REACHES LIMIT OR A UNIQUE UPDATE WAS TRIGGERED
	if (diff_time <= 0 || uniqueUpdate) {

		if (!isUpdated && !isStopped) {

			isUpdated = true;

			var timeImage = packery_base.getElementsByClassName("timer_image")[0];

			timeImage.src = "images/icons_2/combs.gif";
			timeImage.style.width = "80px";

			getFirstByClassName(element,"timeText").textContent = "Please Wait";

			updateHomepage();

		}
		
		// getFirstByClassName(element,"timeText").textContent = "Refresh After
		// Start";

	} else {

		getFirstByClassName(element,"timeText").textContent = diff_time;

	}

	window.setTimeout("updateTimer()", 1000);
}

/**
 * 
 */
function setSB_gimmic_timer() {

	var t = create_initiate_element("gimmic_template_timer", 'timer_tile');
	var list = t.getElementsByClassName("timeText")[0].textContent = "Start";

	packery_base.appendChild(t);
	setup_packery(t);

	window.setTimeout("updateTimer()", 1000);

}

/**
 * 
 * @param t
 */
function setup_packery(t){
	
	pckry.appended(t);
	var itemElems = pckry.getItemElements();
	var elem = itemElems[itemElems.length-1];
	var draggie = new Draggabilly(elem);
	pckry.bindDraggabillyEvents(draggie);

}

/**
 * 
 */
function initiate_element(element, newID) {

	newID = newID == undefined ? null : newID;

	element.style.display = "initial";
	element.removeAttribute('id');

	if (newID != null)
		element.id = newID;
}

/**
 * 
 */
function create_initiate_element(oldID, newID) {

	newID = newID == undefined ? null : newID;

	var element = document.getElementById(oldID).cloneNode(true);
	element.style.display = "initial";
	element.removeAttribute('id');

	if (newID != null)
		element.id = newID;

	return element;
}

/**
 * 
 */
function initPackery() {

	var container = document.querySelector('.packery');
	pckry = new Packery(container, {
		columnWidth : 251,
		rowHeight : 151
	});

	updatePckry();

}

/**
 * 
 */
function setStartScreen() {

	setSB_header();
	setSB_gimmic_timer();
	setSB_gimmic_user();
	setSB_gimmic_earn_money();
	setSB_gimmic_get_fp();
	setSB_gimmic_sort();
	setSB_open_calculator();
	setSB_faq();
	setSB_buyCredits();
		
	setSB_gimmic_news_letter_reg();

	updatePckry();

}

/**
 * 
 */
function setListenerForm(element) {

	var list;

	list = element.getElementsByTagName("input");

	for (var i = 0; i < list.length; i++)
		list[i].onclick = function() {
			this.focus();
			var value = this.value;
			this.value = "";
			this.value = value;

		};

	list = element.getElementsByTagName("textarea");

	for (var i = 0; i < list.length; i++)
		list[i].onclick = function() {
			this.focus();
			var value = this.value;
			this.value = "";
			this.value = value;

		};

}

/**
 * 
 */
function setMenuListener() {

	document.getElementById("loc_text_2_2").onclick = function() {
		setSB_gimmic_text_imprint();
		updatePckry();
	};
	document.getElementById("loc_text_2_0").onclick = function() {
		setSB_gimmic_text_aboutus();
		updatePckry();
	};
	document.getElementById("loc_text_2_1").onclick = function() {
		setSB_gimmic_text_contact();
		updatePckry();
	};
	document.getElementById("loc_text_2_3").onclick = function() {
		setSB_gimmic_text_regist_login();
		updatePckry();
	};

}

/**
 * 
 */
function updatePckry() {

	function orderItems() {
		var itemElems = pckry.getItemElements();
	}

	pckry.on('layoutComplete', orderItems);
	pckry.on('dragItemPositioned', orderItems);

	pckry.layout();
}

/**
 * 
 */
function setUniqueUpdate() {
	uniqueUpdate = true;
}

/**
 * 
 */
function doTimerAction() {

	isStopped = !isStopped;
	var element = packery_base.getElementsByClassName("stop_button")[0];

	if (isStopped)
		element.textContent = "Start Timer";
	else
		element.textContent = "Stop Timer";

}

/**
 * 
 */
function sendNewsLetterReg() {

	var element = document.getElementById("newsletter_email");
	var elem2 = element.getElementsByClassName("newsletter_email_2")[0];
	
	$.post(newsletter_path, {
		email : elem2.value
	}, function(data) {
		
		var obj = getJsonObject(data);	
		var element = document.getElementById("newsletter_email");
		
		element.getElementsByClassName("text")[0].textContent = obj.msg;
		element.getElementsByClassName("newsletter_email_2")[0].value = "";

	});
	
}

/**
 * 
 */
docReady(function() {

	packery_base = document.getElementById("packery_base");

	/*timer_counter = 0;
	uniqueUpdate = true;
	
	if(is_already_logged)
		make_already_login();*/
	
	initPackery();
	//setStartScreen();

});

// Start code by yug
function custom_fun()
{
	var txtBookieStake1 = document.getElementById('txtBookieStake1').value;
	var txtBookieOdds1 = document.getElementById('txtBookieOdds1').value;
	var txtBookieStake2 = document.getElementById('txtBookieStake2').value;
	var txtBookieOdds2 = document.getElementById('txtBookieOdds2').value;
	var liability = (parseFloat(txtBookieOdds2)-1)*parseFloat(txtBookieStake2);
	$("#lblBackWin_Exchange_Profit").html('£-' + liability.toFixed(2));
	$("#lblSimple_liability").html('£' + liability.toFixed(2));
	var total  = (parseFloat(txtBookieStake1) * parseFloat(txtBookieOdds1)) - parseFloat(txtBookieStake1);
	$('#lblBackWin_Bookie_Profit').html('£' + total.toFixed(2));
	
	$("#lblSimpleStake").html('£' + txtBookieStake1);
	$("#lblSimpleBackOdds").html(txtBookieOdds1);
	$("#lblSimple_layAmount").html('£' + txtBookieStake2);
	$("#lblSimple_layOdds").html(txtBookieOdds2);
	var lay_comm = document.getElementById("txtLayComm").value;
	var lay_exchange_profit = txtBookieStake2-((txtBookieStake2*lay_comm)/100);

	$("#lblLayWin_Exchange_Profit").html('£+' + lay_exchange_profit.toFixed(2));

	var back_win_profit = total-liability;
	var lay_win_profit = lay_exchange_profit-txtBookieStake1;

	if(total < liability){
		$("#lblSimple_Profit, #lblBackWin_Profit, #lblLayWin_Profit").attr('class', 'loss');	
		$("#lblBackWin_Profit").html('£'+back_win_profit.toFixed(2));
		$("#lblLayWin_Profit").html('£'+lay_win_profit.toFixed(2));
	}else{
		$("#lblSimple_Profit, #lblBackWin_Profit, #lblLayWin_Profit").attr('class', 'profit');
		$("#lblBackWin_Profit").html('£'+back_win_profit.toFixed(2));
		$("#lblLayWin_Profit").html('£'+lay_win_profit.toFixed(2));
	}
	if(back_win_profit < lay_win_profit){
		$("#lblSimple_Profit").html('£'+back_win_profit.toFixed(2));	
	}else{
		$("#lblSimple_Profit").html('£'+lay_win_profit.toFixed(2));	
	}
	
	
	$("#lblLayWin_Bookie_Profit").html('£-'+txtBookieStake1);
	

}




