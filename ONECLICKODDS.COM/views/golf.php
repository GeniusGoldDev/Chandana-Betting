<?php
// USAGE

 include "Includes/config.php";
 include "Classess/Crawler.php";
 $url_collection = get_url_search("https://www.oddschecker.com/search/process?from=1&limit=10&query=Katerina+Siniakova+v+Venus+Williams");
 // $url_collection = get_url_collection_match("Club Brugge v Istanbul Basaksehir FK", "winner", "07/26/2017");
 ?>
 <div id="searh_result">
 	<?php echo $url_collection;?>
 </div>