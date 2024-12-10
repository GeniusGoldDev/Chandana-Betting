<?php
include "../Includes/config.php";
$url = "http://www.oddschecker.com/betslip?".$_SERVER['QUERY_STRING'];
$html = @file_get_contents($url);
$doms = new DOMDocument();
@$doms->loadHTML($html);
$x = $doms->getElementsByTagName("html")->item(0)->getElementsByTagName("body")->item(0);
$doms->getElementsByTagName("html")->item(0)->removeChild($x);
$body = $doms->createElement('body', '');
$img = $doms->createElement('img');
$img->setAttribute('src',$base_url.'/img/loading.gif');
$nbody = $doms->importNode($body, true);
$nimg = $doms->importNode($img, true);
$doms->getElementsByTagName("html")->item(0)->appendChild($nbody)->appendChild($nimg)->setAttribute('style','margin:auto;display:block;');
echo $doms->saveHTML();
?>