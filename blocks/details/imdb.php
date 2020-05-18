<?php
//==
$HTMLOUT.= "<br />
<div class='row'>
<div class='col-md-12'>
        </div><!-- closing col md 12 -->
     </div><!-- closing row -->";
$HTMLOUT.= "<div class='row'>
<div class='col-md-12'>
<table align='center' class='table table-bordered'>\n";
//== tvrage by pdq/putyn
//if (in_array($torrents['category'], $INSTALLER09['tv_cats'])) {
//    require_once (INCL_DIR . 'tvrage_functions.php');
//    $tvrage_info = tvrage($torrents);
//    if ($tvrage_info) $HTMLOUT.= tr($lang['details_tvrage'], $tvrage_info, 1);
//}
//== tvmaze by whocares converted from former tvrage functions by pdq/putyn  //uncomment the following to use tvmaze auto-completion
if (in_array($torrents['category'], $INSTALLER09['tv_cats'])) {
    $tvmaze_info = tvmaze($torrents);
    if ($tvmaze_info) $HTMLOUT.= tr($lang['details_tvrage'], $tvmaze_info, 1);
}
//== end tvmaze
if ((in_array($torrents['category'], $INSTALLER09['movie_cats'])) && $torrents['url'] != '') {
$IMDB = new IMDB($torrents['url']);
    $country =($IMDB->getCountry());
    $country = explode("/",$country);
    $description = $IMDB->getDescription();
    $director = $IMDB->getDirector();
    $director = explode("/",$director);
    $genre =$IMDB->getGenre();
    $genre = explode("/",$genre);
    $location =$IMDB->getLocation();
    $location = explode(",",$location);
    $plot =$IMDB->getPlot();
    $poster =$IMDB->getPoster("small",true);
    $runtime =$IMDB->getRuntime();
    $title = $IMDB->getTitle();
    $year = $IMDB->getYear();
	$rating = $IMDB->getRating();
	$writer = $IMDB->getWriter();
	$trailer = $IMDB->getTrailerAsUrl($bEmbed = true);
	$comment = $IMDB->getUserReview();
	$soundmix =$IMDB->getSoundMix();
$imdb = '';
$imdb .= "<div class='imdb'>
<div class='imdb_info'>
<br /><strong><font color=\"red\">{$lang['details_add_imdb01']}</font></strong> ".$year."";
	$imdb .= "<br /><strong><font color=\"red\">{$lang['details_add_imdb02']}</font></strong>";
	foreach ($genre as $gen) {
		$imdb .= $gen . '/';
}
$imdb .= "<br /><strong><font color=\"red\">{$lang['details_add_imdb03']}</font></strong> ".$runtime." Mins   
<br /><strong><font color=\"red\">{$lang['details_add_imdb04']}</font></strong>".$rating."  
<br />";
foreach ($director as $dir) {
$imdb .= "<br /><strong><font color=\"red\">{$lang['details_add_imdb05']}</font></strong>".$dir."";
} 
foreach ($location as $loc) {
$imdb .= "<br /><strong><font color=\"red\">{$lang['details_add_imdb06']}</font></strong>".$loc . ',';
}
$imdb .= "<br />
<strong><font color=\"red\">{$lang['details_add_imdb07']}</font></strong>".$writer."";
	foreach ($country as $cntry) {
$imdb .= "<br /><strong><font color=\"red\">{$lang['details_add_imdb08']}</font></strong>" .$soundmix . ',';
}
$imdb .= "</div><!-- closing imdb info -->
<br />";
$imdb.= "
<div class='imdb_summary'>
<div style=\"background-color:transparent; border: none; width:100%;\"><div style=\"text-transform: uppercase; border-bottom: 1px solid #CCCCCC; margin-bottom: 3px; font-size: 0.8em; color: red; font-weight: bold; display: block;\"><span onclick=\"if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.innerHTML = '<b>{$lang['details_add_imdb10']}</b><a href=\'#\' onclick=\'return false;\'>{$lang['details_add_imdbhd']}</a>'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerHTML = '<b>{$lang['details_add_imdb10']}</b><a href=\'#\' onclick=\'return false;\'>{$lang['details_add_imdbsh']}</a>'; }\" ><font color='red'><b>{$lang['details_add_imdb10']}</b></font><a href=\"#\" onclick=\"return false;\">{$lang['details_add_imdbsh']}</a></span></div><div class=\"quotecontent\"><div style=\"display: none;\"><div style='background-color:transparent;width:100%;overflow: auto'>";
$imdb.= "".$description."";
$imdb.="</div></div></div><!-- closing quote --></div></div><!-- closing imdb summary -->";

$imdb.= "<div class='imdb_plot'>
<div style=\"background-color:transparent; border: none; width:100%;\"><div style=\"text-transform: uppercase; border-bottom: 1px solid #CCCCCC; margin-bottom: 3px; font-size: 0.8em; color: red; font-weight: bold; display: block;\"><span onclick=\"if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.innerHTML = '<b>{$lang['details_add_imdb11']}</b><a href=\'#\' onclick=\'return false;\'>{$lang['details_add_imdbhd']}</a>'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerHTML = '<b>{$lang['details_add_imdb11']}</b><a href=\'#\' onclick=\'return false;\'>{$lang['details_add_imdbsh']}</a>'; }\" ><font color='red'><b>{$lang['details_add_imdb11']}</b></font><a href=\"#\" onclick=\"return false;\">{$lang['details_add_imdbsh']}</a></span></div><div class=\"quotecontent\"><div style=\"display: none;\"><div style='background-color:transparent;width:100%;overflow: auto'>";
$imdb.= "".strip_tags($plot)."";
$imdb.="</div></div></div></div></div><!-- closing plot -->";

$imdb.= "<div class='imdb_trailers'>
<div style=\"background-color:transparent; border: none; width:100%;\"><div style=\"text-transform: uppercase; border-bottom: 1px solid #CCCCCC; margin-bottom: 3px; font-size: 0.8em; color: red; font-weight: bold; display: block;\"><span onclick=\"if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.innerHTML = '<b>{$lang['details_add_imdb12']}</b><a href=\'#\' onclick=\'return false;\'>{$lang['details_add_imdbhd']}</a>'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerHTML = '<b>{$lang['details_add_imdb12']}</b><a href=\'#\' onclick=\'return false;\'>{$lang['details_add_imdbsh']}</a>'; }\" ><font color='red'><b>{$lang['details_add_imdb12']}</b></font><a href=\"#\" onclick=\"return false;\">{$lang['details_add_imdbsh']}</a></span></div><div class=\"quotecontent\"><div style=\"display: none;\"><div style='background-color:transparent;width:100%;overflow: auto'>";
$imdb.= "<a href=\"".$trailer."\" onclick=\"return popitup('".$trailer."')\"><span class='imdb_titles'>{$lang['details_add_imdb14']}</span></a>
";
$imdb.="</div></div></div></div></div><!-- closing trailers -->";

//Below was added here, but thought better in bittorrent.php where the IMDB function run.  Making sure variables are set right there seems much more sane
//isset($imdb_info['comment']) ?: $imdb_info['comment'] = 'None Available';
$imdb.= "<div class='imdb_comments'>
<div style=\"background-color:transparent; border: none; width:100%;\"><div style=\"text-transform: uppercase; border-bottom: 1px solid #CCCCCC; margin-bottom: 3px; font-size: 0.8em; color: red; font-weight: bold; display: block;\"><span onclick=\"if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.innerHTML = '<b>{$lang['details_add_imdb13']}</b><a href=\'#\' onclick=\'return false;\'>{$lang['details_add_imdbhd']}</a>'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerHTML = '<b>Comments: </b><a href=\'#\' onclick=\'return false;\'>{$lang['details_add_imdbsh']}</a>'; }\" ><font color='red'><b>{$lang['details_add_imdb13']}</b></font><a href=\"#\" onclick=\"return false;\">{$lang['details_add_imdbsh']}</a></span></div><div class=\"quotecontent\"><div style=\"display: none;\"><div style='background-color:transparent;width:100%;overflow: auto'>";
$imdb.= "".strip_tags($comment)."";
$imdb.="</div></div></div></div></div><!-- closing comments -->";
$imdb .="</div><!-- closing imdb -->";
$HTMLOUT.= tr($lang['details_add_imdb'], $imdb, 1);
}
//if (empty($tvrage_info) && empty($imdb) && in_array($torrents['category'], array_merge($INSTALLER09['movie_cats'], $INSTALLER09['tv_cats']))) $HTMLOUT.= "<tr><td colspan='2'>No Imdb or Tvrage info.</td></tr>";
if (empty($tvmaze_info) && empty($imdb) && in_array($torrents['category'], array_merge($INSTALLER09['movie_cats'], $INSTALLER09['tv_cats']))) $HTMLOUT.= "<tr><td colspan='2'>{$lang['details_add_noimdb']}</td></tr>";
$HTMLOUT.= "</table>
     </div><!-- closig col md 12 -->
     </div><!-- closing row -->";
?>