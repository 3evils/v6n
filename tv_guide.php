<?php
/**
 |--------------------------------------------------------------------------|
 |   https://github.com/Bigjoos/                                            |
 |--------------------------------------------------------------------------|
 |   Licence Info: WTFPL                                                    |
 |--------------------------------------------------------------------------|
 |   Copyright (C) 2010 U-232 V5                                            |
 |--------------------------------------------------------------------------|
 |   A bittorrent tracker source based on TBDev.net/tbsource/bytemonsoon.   |
 |--------------------------------------------------------------------------|
 |   Project Leaders: Mindless, Autotron, whocares, Swizzles.               |
 |--------------------------------------------------------------------------|
  _   _   _   _   _     _   _   _   _   _   _     _   _   _   _
 / \ / \ / \ / \ / \   / \ / \ / \ / \ / \ / \   / \ / \ / \ / \
( U | - | 2 | 3 | 2 )-( S | o | u | r | c | e )-( C | o | d | e )
 \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/
 */
require_once __DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php';
require_once INCL_DIR . 'user_functions.php';
require_once (INCL_DIR . 'bbcode_functions.php');
require_once (INCL_DIR . 'pager_functions.php');
require_once INCL_DIR . 'html_functions.php';
require_once INCL_DIR . 'getpre.php';
dbconn(false);
loggedinorreturn();
require_once(TEMPLATE_DIR.''.$CURUSER['stylesheet'].'' . DIRECTORY_SEPARATOR . 'html_functions' . DIRECTORY_SEPARATOR . 'global_html_functions.php'); 
require_once(TEMPLATE_DIR.''.$CURUSER['stylesheet'].'' . DIRECTORY_SEPARATOR . 'html_functions' . DIRECTORY_SEPARATOR . 'navigation_html_functions.php');
$lang = load_language('global');
$HTMLOUT = '';
$HTMLOUT .='<style>
.checked {
    color: orange;
}
</style>';
$HTMLOUT .= "
	<ul class='tabs'>
                <li class='tabs-title'><a href='tv_guide.php?country=US'>USA TV Schedule</a></li>
                <li class='tabs-title'><a href='tv_guide.php?country=GB'>UK TV Schedule</a></li>
                <li class='tabs-title'><a href='tv_guide.php?country=FR'>France TV Schedule</a></li>
                <li class='tabs-title'><a href='tv_guide.php?country=IE'>Ireland TV Schedule</a></li>
                <li class='tabs-title'><a href='tv_guide.php?country=SE'>Sweden TV Schedule</a></li>
                <li class='tabs-title'><a href='tv_guide.php?country=DE'>Germany TV Schedule</a></li>
		</ul>
";
$lcountry = (isset($_REQUEST['country']))? $_REQUEST["country"]:"US";
if (($tvsched = $mc1->get_value('schedule_'.$lcountry)) === false) {
	$date = date(('Y-m-d'));
    $tvmaze = file_get_contents('https://api.tvmaze.com/schedule?country='.$lcountry.'&date='.$date);
    $tvsched = json_decode($tvmaze, true);
if (count($tvsched) > 0)
    $mc1->cache_value('schedule_'.$lcountry, $tvsched, 60 * 60);
}
	$dcountry = "";
    switch ($lcountry) {
        case "US":
            $dcountry = "Usa";
            break;
        case "GP":
            $dcountry = "United Kingdom";
            break;
        case "FR":
            $dcountry = "France";
            break;
        case "IE":
            $dcountry = "Ireland";
            break;
        case "SE":
            $dcountry = "Sweden";
            break;
        case "DE":
            $dcountry = "Germany";
            break;
    }
$HTMLOUT .= "<div class='card'><div class='card-divider'><h4 class='subheader'>Upcoming " . $dcountry . " TV Schedule</h4></div><div class='row card-section'>";
foreach ($tvsched as $key => $item){
		$image = $item['show']['image']['original'] ?? '';
        $airimg = $image ? "<img src='".$item['show']['image']['original']."'></img>":"<img src='" .$INSTALLER09['pic_base_url']."/noposter.png' style='width:214; height:305px;'></img>";
			//episode info    		
			$unwantedChars = array(',', '!', '?', "'"); // create array with unwanted chars
          	$season = "";
	    	$number = "";
	    	$airdate = "";
	    	$airtime = "";
	    	$airstamp = "";
	    	$runtime = "";
	    	$episodeSummary = "";
	    	$itemName= "";
	    	$itemType= "";
	    	$itemLanguage= "";
	    	$itemPremiered = "";
	    	$itemAverageRating = "";
	    	$itemGenre = "";
	    	$itemSummary =  "";
			//$episodeID = ($item['id']);
			//$item['id'] = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
			//$tvmaze_shows = sprintf('http://api.tvmaze.com/shows/%d', $episodeID);
			//$tvmaze_array = json_decode(file_get_contents($tvmaze_shows), true);	
			$episodeName = ($item['name']);	
	    	$season = $item['season'];
	    	$number = $item['number'];
	    	$airdate = $item['airdate'];
	    	$airtime = $item['airtime'];
	    	$airstamp = $item['airstamp'];
	    	$runtime = $item['runtime'];
			$network = isset($item['show']['network']['name']) ? $item['show']['network']['name'] : 0;
	    	$episodeSummary = str_replace($unwantedChars,"",(($item['summary'])));

	    	//show info
	    	$itemName = str_replace($unwantedChars,"",(htmlentities($item['show']['name'])));
	    	$subtitleLink = "http://www.opensubtitles.org/en/search2/sublanguageid-eng/searchonlytvseries-on/moviename-".str_replace(" ", "+", $itemName);
	    	$itemType = $item['show']['type'] ?? '';
	    	$itemLanguage= $item['show']['language'];
	    	$itemPremiered = $item['show']['premiered'];
	    	$itemAverageRating = $item['show']['rating']['average'];		
			//some genres are blank
	    	$showGenre = "";
	    	foreach($item['show']['genres'] as $key => $genre) 	{	
				$showGenre = $showGenre . " <a class='float-left' href='browse.php?search={$genre}&searchin=genre&incldead=0' target='_blank'>". $genre . " | </a>";
	    	}	
	    	$itemSummary = str_replace($unwantedChars,"",(($item['show']['summary'])));
	    	$episodeName = str_replace($unwantedChars,"",(htmlentities($item['name'])));
        $HTMLOUT .= "<div class='large-6 columns'>
		<p><ul class='vertical menu'>
		<a data-open='showsModal{$item['show']['id']} callout'>
		<strong>{$item['show']['name']}</strong>
		<strong style='color:#fe7600;'>S".($season < 10 ? '0'.$season : $season)."</strong>
		<strong style='color:#080;'>E".($number < 10 ? '0'.$number : $number)."</strong><label class='badge float-right'>{$airtime}</label></a></ul></p></div>";
		$HTMLOUT .= "<div class='large reveal row' id='showsModal{$item['show']['id']}' data-reveal>
		<div class='large-3 columns'>".$airimg."</div>
		<div class='large-9 columns'>
			<h4>{$item['show']['name']}</h4>";
			$HTMLOUT .= "<b>{$showGenre}</b> <p>Airs on {$network}</p>
			<a class='float-right' href='browse.php?search={$item['show']['name']} S".($season < 10 ? '0'.$season : $season)."E".($number < 10 ? '0'.$number : $number)."&searchin=title'><i class='fas fa-search'></i></a>";
			$rating = $itemAverageRating;
			$x=1;
				for($x=1;$x<=$itemAverageRating;$x++) {
					$HTMLOUT .= '<span class="fas fa-star checked"></span>';
					   if ($x++ == 5) break;
				}
				if (strpos($itemAverageRating,'.')) {
					$HTMLOUT .= '<span class="fas fa-star-half""></span>';
					$x++;
				}
				while ($x < 5) {
					$HTMLOUT .= '<span class="far fa-star""></span>';
					$x++;
				}			
		$HTMLOUT .= " <a class='label' href='tv_show.php?id={$item['show']['id']}'>List of seasons and episodes</a>
		  <div class='callout'>
			<p><strong style='color:#fe7600;'>Season: {$item['season']}</strong>
		<strong style='color:#080;'>Episode: {$item['number']}</strong></p>
				<strong>On this Episode</strong>{$episodeSummary}
		  </div>
		  <a class='button float-right' type='button'>Follow</a>
		   </div>
		<button class='close-button' data-close aria-label='Close modal' type='button'>
    <span aria-hidden='true'>&times;</span>
  </button>";
$HTMLOUT .= "</div>";	
}
$HTMLOUT .= "</div></div>";
echo stdhead("Upcoming TV Episodes") . $HTMLOUT . stdfoot();