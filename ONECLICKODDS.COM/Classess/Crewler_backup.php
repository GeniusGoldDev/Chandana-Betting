<?php
function get_fcontent( $url,  $javascript_loop = 0, $timeout = 5 ) {
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

function check_your_datetime($x) {
    return (date('l jS F Y', strtotime($x)) == $x);
}

function get_url_collection($url)
{
	global $odds_url,$tmp_odds_url;
	$conetnts = get_fcontent($url);
	$dom = new DOMDocument();
	libxml_use_internal_errors(true);
	$dom->loadHTML($conetnts[0]);
	libxml_use_internal_errors(false);
	$tables = $dom->getElementsByTagName('table');
	$url_collection = array();
    foreach($tables->item(0)->getElementsByTagName('tr') as  $key =>$tr){
		
		if(!empty($text))
		{
			$text = $text.' '.$tr->firstChild->nodeValue;
		}
		if(check_your_datetime($tr->lastChild->nodeValue))
		{
			$text = $tr->lastChild->nodeValue;
		}
		if($tr->lastChild->nodeValue == 'All Odds')
		{
	       $url_collection[] = array('text'=>$tr->lastChild->getElementsByTagName('a')->item(0)->getAttribute('title').'##'.$text, 'url'=>$odds_url.$tr->lastChild->getElementsByTagName('a')->item(0)->getAttribute('href'));
		   $text='';
		}
    }
	
	unset($conetnts);
	unset($dom);
	unset($tables);

	if(empty($url_collection))
	{
		return false;
	}
	return $url_collection;
}

function get_result($url_collection)
{
	$table = '';
	$result = false;
	foreach($url_collection as $url)
	{
		$conetnts = get_fcontent($url['url']);
		if(!empty($conetnts))
		{
			$first_step = explode( '<div id="oddsTableContainer" data-ng-controller="XmlBetController as XmlBetController">' , $conetnts[0] );
			if(!isset($first_step[1]))
				continue;
			$second_step = explode('<div id="all-odds-footer">' , $first_step[1] );
			//$title = str_replace($tmp_odds_url, '', $url['url']);
			$path = explode("##", $url['text']);
			$table .=  '<h1 class="heading">'.substr($path[0], 4).' <small> '.$path[1].'</small></h1><div id="oddsTableContainer">'.$second_step[0].'<div class="col-md-4 col-md-offset-8 divCheckWrapper pull-right">
		  <button class="checkodds btn btn-info">Check</button> <button class="uncheckodds btn btn-info">Un Checkall</button>
		</div><div class="content"></div>';
				if(!empty($second_step[0]))
				{
					$result = true;	
				}
		}
	}
	if($result)
		return $table.'<div id="all-odds-footer"><p id="text-disclaimer">&nbsp;</p><div class="nav-site-settings"><div class="settings-table module"><div class="table-info-bar settings-container"><p class="title best-odds-description">The Best Odds Are <span class="title best-odds">Bold</span>,</p><span class="shortening"><span class="title">Odds Shortening</span><span class="box">Odds Shortening</span></span><span class="drifting"><span class="title">Odds Drifting</span><span class="box">Odds Drifting</span></span></div></div></div></div>';
	else
		return false;
}

?>
