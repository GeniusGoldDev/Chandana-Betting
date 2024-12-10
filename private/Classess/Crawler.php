<?php
function get_fcontent( $url,  $javascript_loop = 0, $timeout = 20 ) {
    $url = str_replace( "&amp;", "&", urldecode(trim($url)) );

    $cookie = tempnam ("/tmp", "CURLCOOKIE");
    $ch = curl_init();
	# sending manually set cookie
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: odds_type=decimal"));

    curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookie );
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
    curl_setopt( $ch, CURLOPT_ENCODING, "" );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );    # required for https urls
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
    curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
    curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
    $content = curl_exec( $ch );
    $response = curl_getinfo( $ch );
	curl_close ( $ch );

    if ($response['http_code'] == 301 || $response['http_code'] == 302) {
        ini_set("user_agent", "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");

        if ( $headers = get_headers($response['url']) ) {
            foreach( $headers as $value ) {
                if ( substr( strtolower($value), 0, 9 ) == "location:" )
                    return get_url( trim( substr( $value, 9, strlen($value) ) ) );
            }
        }
    }

    if (    ( preg_match("/>[[:space:]]+window\.location\.replace\('(.*)'\)/i", $content, $value) || preg_match("/>[[:space:]]+window\.location\=\"(.*)\"/i", $content, $value) ) && $javascript_loop < 5) {
        return get_url( $value[1], $javascript_loop+1 );
    } else {
        return array( $content, $response );
    }
}

function url_exists($url) {
    if (!$fp = curl_init($url)) return false;
    return true;
}

function check_your_datetime($x) {
    return (date('l jS F Y', strtotime($x)) == $x);
}

function get_url_search($url)
{ 
	// $url = "https://www.oddschecker.com/search/process?from=1&limit=1&query=FK+Karabakh+v+FC+Sheriff";
	$timeout = 0;
    $cookie = tempnam ("/tmp", "CURLCOOKIE");
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: odds_type=decimal"));
    curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookie );
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
    curl_setopt( $ch, CURLOPT_ENCODING, "" );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );    # required for https urls
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
    curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
    curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
    $content = curl_exec( $ch );
    $response = curl_getinfo( $ch );
	curl_close ( $ch );
	$start = strpos($content, "market_map");
	$temp = strpos($content, "category_group_name");
	$mid_result= substr($content, $start+13, $temp-$start-13); 
	$end = strrpos($mid_result, "/") + 1;
	$result= substr($mid_result, 0, $end);
	
    return $result;
}

function get_url_collection_match($match_name, $market_type, $match_date)
{ 	
	$odds="All Odds";
	$match_re = str_ireplace(" ", "+", $match_name);
        $market_re = str_ireplace(" ", "-", $market_type);
	$market = strtolower($market_re);
	$search_url = "https://www.oddschecker.com/search/process?from=1&limit=1&query=".$match_re;
	$result = get_url_search($search_url);

	$length = strrpos($result, "/");
	$sub_url = substr($result, 0, $length);

	$url = "https://www.oddschecker.com/".$sub_url;

	$match = "/".$result."/winner";
	$match_date_format = date('l jS F Y', strtotime($match_date));

	$url_collection = array();
	if(empty($match_name)) return $url_collection;
	global $odds_url,$tmp_odds_url;
				
	$conetnts = get_fcontent($url);

	$dom = new DOMDocument();
	libxml_use_internal_errors(true);
	$dom->loadHTML($conetnts[0]);
	libxml_use_internal_errors(false);
	$div=$dom->getElementById('fixtures');
	if(empty($div)) return $url_collection;

	$tables = $div->getElementsByTagName('table');

	foreach($tables->item(0)->getElementsByTagName('tr') as  $key =>$tr){
		
		if(!empty($date))
		{
			$time = $tr->firstChild->nodeValue;
			
		}
		if(check_your_datetime($tr->firstChild->nodeValue))
		{
			$date = $tr->firstChild->nodeValue;
			
		}
		if($tr->lastChild->nodeValue == $odds || $tr->lastChild->nodeValue == "In Play")
		{
			if ($date == $match_date_format) {
				$match_title = $tr->lastChild->getElementsByTagName('a')->item(0)->getAttribute('href');
				if ($match_title == $match) {
					$odd_url = $odds_url.$tr->lastChild->getElementsByTagName('a')->item(0)->getAttribute('href');
					$length = strrpos($odd_url, "/") + 1;
					$sub_url = substr($odd_url, 0, $length);
					$match_odd_url = $sub_url.$market;
					$title = $tr->lastChild->getElementsByTagName('a')->item(0)->getAttribute('title');
			       $url_collection[] = array('text'=>$title.'##'.$date.' '.$time, 'url'=>$match_odd_url);
				   $text='';
				   return $url_collection;
				   break;
			   }
		   }
		}
    }
	
	unset($conetnts);
	unset($dom);
	unset($tables);
	return $url_collection;
}

function get_url_collection_match_search($sport_type, $match_name, $market_type, $match_date)
{ 	
	$odds="All Odds";
	$match_re = str_ireplace(" ", "+", $match_name);
	$market_re = str_ireplace(" ", "-", $market_type);
	$market = strtolower($market_re);
	$sport = strtolower($sport_type);
	$search_url = "https://www.oddschecker.com/search/process?from=1&limit=1&query=".$match_re;
	$result = get_url_search($search_url);
	$url_collection = array();
	if(strchr($result, $sport)){
		$length = strrpos($result, "/");
		$sub_url = substr($result, 0, $length);

		$url = "https://www.oddschecker.com/".$sub_url;

		$match = "/".$result."/winner";
		$match_date_format = date('l jS F Y', strtotime($match_date));

		if(empty($match_name)) return $url_collection;
		global $odds_url,$tmp_odds_url;
					
		$conetnts = get_fcontent($url);

		$dom = new DOMDocument();
		libxml_use_internal_errors(true);
		$dom->loadHTML($conetnts[0]);
		libxml_use_internal_errors(false);
		$div=$dom->getElementById('fixtures');
		if(empty($div)) return $url_collection;

		$tables = $div->getElementsByTagName('table');

		foreach($tables->item(0)->getElementsByTagName('tr') as  $key =>$tr){
			
			if(!empty($date))
			{
				$time = $tr->firstChild->nodeValue;
				
			}
			if(check_your_datetime($tr->firstChild->nodeValue))
			{
				$date = $tr->firstChild->nodeValue;
				
			}
			if($tr->lastChild->nodeValue == $odds || $tr->lastChild->nodeValue == "In Play")
			{
				if ($date == $match_date_format) {
					$match_title = $tr->lastChild->getElementsByTagName('a')->item(0)->getAttribute('href');
					if ($match_title == $match) {
						$odd_url = $odds_url.$tr->lastChild->getElementsByTagName('a')->item(0)->getAttribute('href');
						$length = strrpos($odd_url, "/") + 1;
						$sub_url = substr($odd_url, 0, $length);
						$match_odd_url = $sub_url.$market;
						$title = $tr->lastChild->getElementsByTagName('a')->item(0)->getAttribute('title');
				       $url_collection[] = array('text'=>$title.'##'.$date.' '.$time, 'url'=>$match_odd_url);
					   $text='';
					   return $url_collection;
					   break;
				   }
			   }
			}
	    }
		
		unset($conetnts);
		unset($dom);
		unset($tables);
	}
	return $url_collection;
}

function get_url_collection($url, $odds="All Odds")
{ 
	global $odds_url,$tmp_odds_url;
	$url_collection = array();
				
	$conetnts = get_fcontent($url);
	
	$dom = new DOMDocument();
	libxml_use_internal_errors(true);
	$dom->loadHTML($conetnts[0]);
	libxml_use_internal_errors(false);
	$div=$dom->getElementById('fixtures');
	if(empty($div)) return $url_collection;

	$tables = $div->getElementsByTagName('table');

	foreach($tables->item(0)->getElementsByTagName('tr') as  $key =>$tr){
		
		if(!empty($date))
		{
			$time = $tr->firstChild->nodeValue;
			
		}
		if(check_your_datetime($tr->lastChild->nodeValue))
		{
			$date = $tr->lastChild->nodeValue;
			
		}
		if($tr->lastChild->nodeValue == $odds)
		{
	       $url_collection[] = array('text'=>$tr->lastChild->getElementsByTagName('a')->item(0)->getAttribute('title').'##'.$date.' '.$time, 'url'=>$odds_url.$tr->lastChild->getElementsByTagName('a')->item(0)->getAttribute('href'));
		   $text='';
		}
    }
	
	unset($conetnts);
	unset($dom);
	unset($tables);
	return $url_collection;
}

function get_result($url_collection)
{
	$result = array();
	foreach($url_collection as $url)
	{
		$conetnts = get_fcontent($url['url']);
		if(!empty($conetnts))
		{
			$first_step = explode( '<div id="oddsTableContainer" data-ng-controller="XmlBetController as XmlBetController">' , $conetnts[0] );
			if(!isset($first_step[1]))
				continue;
			
			$second_step = explode('<div id="all-odds-footer">' , $first_step[1] );
			$path = explode("##", $url['text']);
			$row = array();	
			$row['title'] = substr($path[0], 5);
			$fulldate = explode(" ", $path[1]);
			$date = substr($fulldate[1], 0, 2);
			$date_time = str_replace($fulldate[1], $date, $path[1]);		
			$row['date_time'] = isset($path[1]) ? $date_time : '';
			$row['data'] = isset($second_step[0]) ? $second_step[0] : '';			

			$result[] = $row;
		}
	}
	return $result;
}
function get_horse_racing($url)
{ 
	$conetnts = get_fcontent($url);
	
		if(!empty($conetnts))
		{
			$first_step = explode( '<div id="oddsTableContainer" data-ng-controller="XmlBetController as XmlBetController">' , $conetnts[0] );
		
			if(!isset($first_step[1]))
				continue;

			$second_step = explode('</div></div></section></div>' , $first_step[1] );
			return $second_step[0];
		}
}
function get_horse_url_collection($url)
{
	global $odds_url,$tmp_odds_url;
	$url_collection = array();
				
	$conetnts = get_fcontent($url);
	
	$dom = new DOMDocument();
	libxml_use_internal_errors(true);
	$dom->loadHTML($conetnts[0]);
	libxml_use_internal_errors(false);
	$div=$dom->getElementById('mc');
	if(empty($div)) return $url_collection;

	$tables = $div->getElementsByTagName('section');

	for($i = 0; $i < $tables->length; $i++)
	{
		$header = $tables->item($i)->getElementsByTagName('h2');
		foreach($header as $val)
		{
			$venueArr = array();
			$timeArr=array();
			$venue='';
			$childNodeList = $tables->item($i)->getElementsByTagName('div');
			for ($j = 0; $j < $childNodeList->length; $j++) {
				$temp = $childNodeList->item($j);
				if (stripos($temp->getAttribute('class'), 'venue-details') !== false) {
				    $a=$temp->getElementsByTagName('a');
					foreach($a as $b)
					{
						$venue =$b->nodeValue;
					}
				}
				if (stripos($temp->getAttribute('class'), 'racing-time') !== false) {
				    $a=$temp->getElementsByTagName('a');
					
					foreach($a as $b)
					{
						$venueArr[$venue][$b->nodeValue]=array('link' => $b->getAttribute('href'), 'class' => $b->getAttribute('class'),  'data-time' => $b->getAttribute('data-time'), 'title' => $b->getAttribute('title'));
					}
				}
			}
			
			$url_collection[$val->nodeValue] = $venueArr;
		}
		
	}
	return $url_collection;		
}
?>
