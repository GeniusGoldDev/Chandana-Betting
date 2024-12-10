
var marker = "@@@@@@@@@@@@@@@@@@@@@@@";

var sportImageAccoArray = [];

sportImageAccoArray[1] = "fussball.png";
sportImageAccoArray[2] = "nascar.png";
sportImageAccoArray[3] = "baseball.png";
sportImageAccoArray[4] = "rugby_league.png";
sportImageAccoArray[8] = "tischtennis.png";

sportImageAccoArray[11] = "snooker.png";
sportImageAccoArray[12] = "boxen.png";
sportImageAccoArray[13] = "football.png";
sportImageAccoArray[14] = "radsport.png";
sportImageAccoArray[15] = "volleyball.png";

sportImageAccoArray[16] = "handball.png";
sportImageAccoArray[17] = "eishockey.png";
sportImageAccoArray[18] = "basketball.png";
sportImageAccoArray[19] = "tennis.png";
sportImageAccoArray[23] = "handball.png";

sportImageAccoArray[25] = "cricket.png";
sportImageAccoArray[27] = "dart.png";
sportImageAccoArray[28] = "golf.png";
sportImageAccoArray[29] = "volleyball_beach.png";
sportImageAccoArray[31] = "pool.png";

sportImageAccoArray[38] = "ski_alpine.png";
sportImageAccoArray[40] = "formel_1.png";
sportImageAccoArray[44] = "biathlon.png";
sportImageAccoArray[7900] = "olympia.png";
sportImageAccoArray[7901] = "schach.png";

sportImageAccoArray[8025] = "pferderennen.png";
sportImageAccoArray[8024] = "poker.png";
sportImageAccoArray[8020] = "politik.png";
sportImageAccoArray[8030] = "pool.png";



var brokerLinkAccoArray = [];

brokerLinkAccoArray["tipico"] = "https://www.tipico.de/de/online-sportwetten/";
brokerLinkAccoArray["bet3000"] = "https://www.bet3000.com/de/html/home.html";
brokerLinkAccoArray["betcity"] = "http://betcityru.com/";
brokerLinkAccoArray["cashpoint"] = "https://www.cashpoint.de/de/site/index.html";
brokerLinkAccoArray["betathome"] = "https://www.bet-at-home.com/de";

brokerLinkAccoArray["pinnaclesports"] = "http://www.pinnaclesports.com/";
brokerLinkAccoArray["interwetten"] = "https://www.interwetten.com/de/sportwetten/default.aspx";
brokerLinkAccoArray["nordicbet"] = "https://www.nordicbet.com/";
brokerLinkAccoArray["betclic"] = "https://de.betclic.com/";
brokerLinkAccoArray["ladbrokes"] = "http://www.ladbrokes.com/home/de";

brokerLinkAccoArray["marathonbet"] = "https://mobile.marathonbet.com/en_EN/topLevelCategories/a-z";
brokerLinkAccoArray["gamebookers"] = "https://m.gamebookers.com/de/Sports/Main";



var colorAccoArray = [];

//Double Chance
colorAccoArray[10] = "#00cc99";

// 3Way
colorAccoArray[11] = "#6fceec";

// Draw no bet
colorAccoArray[17] = "#074e68";

// Winner First Halftime
colorAccoArray[7] = "#5c007a";

// 2Way
colorAccoArray[1169] = "#00cc99";

// Over Under
colorAccoArray[9] = "#cc0099";
colorAccoArray[25] = "#cc0099";
colorAccoArray[26] = "#cc0099";
colorAccoArray[27] = "#cc0099";
colorAccoArray[145] = "#cc0099";
colorAccoArray[5366] = "#cc0099";

// Handicap
colorAccoArray[4] = "#ffcc00";
colorAccoArray[5] = "#ffcc00";
colorAccoArray[6] = "#ffcc00";
colorAccoArray[40] = "#ffcc00";
colorAccoArray[3126] = "#ffcc00";
colorAccoArray[5883] = "#ffcc00";
colorAccoArray[221610] = "#ffcc00";
colorAccoArray[221614] = "#ffcc00";

// Virtual Bettypes
colorAccoArray['v1'] = "#FFD67B";
colorAccoArray['v2'] = "#FFD67B";
colorAccoArray['v3'] = "#FFD67B";

var high_max_value = 10.0;
var low_max_value = 1.0;
var very_low_max_value = 1.0;



var textRex = /^[A-Za-z0-9 _]*[A-Za-z0-9][A-Za-z0-9 _]*$/;
var emailRex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;



/**
 * 
 * @param sBets
 * @returns {Array}
 */
function sortDate(sBets) {

	var arr = [];

	for (var i = 0; i < sBets.length; i++)
		arr[i] = i;

	var tempDateExpires1;
	var tempDateExpires2;
	var index;

	for (var i = 0; i < sBets.length; i++) {

		index = i;
		tempDateExpires1 = sBets[i].date + "_" + sBets[i].expires;

		for (var j = i + 1; j < sBets.length; j++) {

			tempDateExpires2 = sBets[j].date + "_" + sBets[j].expires;

			if (tempDateExpires1.localeCompare(tempDateExpires2) == 1) {

				index = j;
				tempDateExpires1 = tempDateExpires2;

			}

		}

		var surebetTemp = sBets[i];
		sBets[i] = sBets[index];
		sBets[index] = surebetTemp;

	}

	return arr;

}

/**
 * 
 * @param sBets
 * @returns {Array}
 */
function sortQuote(sBets) {

	var arr = [];

	for (var i = 0; i < sBets.length; i++)
		arr[i] = i;

	var index;

	for (var i = 0; i < sBets.length; i++) {

		index = i;

		for (var j = i + 1; j < sBets.length; j++)
			if (sBets[index].max < sBets[j].max)
				index = j;

		var surebetTemp = sBets[i];
		sBets[i] = sBets[index];
		sBets[index] = surebetTemp;

	}

	return arr;

}

