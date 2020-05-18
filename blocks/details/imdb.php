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
/*if ((in_array($torrents['category'], $INSTALLER09['movie_cats'])) && $torrents['url'] != '') {
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
*/
////////////OMDB & TMDB by Antimidas and Tundracanine 2018-2019
include_once(CACHE_DIR . 'api_keys.php');
if($INSTALLER09['omdb_on'] == 1) {
    $O_url = trim($torrents['url']);
    $thenumbers = ltrim(strrchr($O_url, 'tt'), 'tt');
    $thenumbers = ($thenumbers[strlen($thenumbers) - 1] == "/" ? substr($thenumbers, 0, strlen($thenumbers) - 1) : $thenumbers);
    $thenumbers = preg_replace("[^A-Za-z0-9]", "", $thenumbers);
    $id_imdb = $thenumbers;

    $rem = file_get_contents("https://www.omdbapi.com/?i=tt" . $id_imdb . "&plot=full&tomatoes=True&r=json&apikey=" . $INSTALLER09['omdb_key']."");
    $omdb = json_decode($rem, true);
    //foreach ($omdb['Ratings'] as $rat => $rate);
    if($torrents['poster'] == '') {
        if ($omdb['Poster'] != "N/A") {
            if (!file_exists(BITBUCKET_DIR ."poster/" . $id_imdb . ".jpg")) {
                @copy($omdb['Poster'], (BITBUCKET_DIR ."poster/" . $id_imdb . ".jpg"));
                $poster = "/bucket/poster/" . $id_imdb . ".jpg";
            } else {
                $poster = "/bucket/poster/" . $id_imdb . ".jpg";
            }

        } else {
            if ($omdb['Poster'] == "N/A") {
                $poster = "";
            }
        }
        sql_query("UPDATE torrents SET poster = " . sqlesc($poster) . " WHERE id = $id LIMIT 1") or sqlerr(__file__, __line__);
    }
///////////TMDB Trailer scrape//////////////
    if($torrents['youtube'] == '') {
        if ($INSTALLER09['tmdb_on'] == 1 ) {
            $json = file_get_contents("https://api.themoviedb.org/3/movie/tt" . $id_imdb . "/videos?api_key=". $INSTALLER09['tmdb_key']."");
            $tmdb = json_decode($json, true);
            foreach ($tmdb['results'] as $key => $test) {
                $yt = $test['key'];
                $trailer = 'https://www.youtube.com/embed/' . $yt . '';
            }
            sql_query("UPDATE torrents SET youtube = " . sqlesc($trailer) . " WHERE id = $id LIMIT 1") or sqlerr(__file__, __line__);
        }
    }


    if ($omdb['Title'] != '') {
        $HTMLOUT .= "<div class='imdb_info' style='width: 80%; display: table;''><tr><th class=' col-md-1 text-center'>
	        </th><div style='width:90%;margin-left:20%;'><th class=' col-md-5 text-left'>
            <strong><font color='#79c5c5'>Title:</font></strong><font style='font-size:24px;' color='white'> " . $omdb['Title'] . "</font><br/>
            <strong><font color='#79c5c5'>Released:</font></strong><font color='grey'> " . $omdb['Released'] . "</font><br/>
            <strong><font color='#79c5c5'>Genre:</font></strong><font color='grey'> " . $omdb['Genre'] . "</font><br/>
	        <strong><font color='#79c5c5'>Rated:</font></strong><font color='grey'> " . $omdb['Rated'] . "</font><br/>
	        <strong><font color='#79c5c5'>Director:</font></strong><font color='grey'> " . $omdb['Director'] . "</font><br/>
	        <strong><font color='#79c5c5'>Cast:</font></strong><font color='grey'> " . $omdb['Actors'] . "</font><br/>
	        <strong><font color='#79c5c5'>Studio:</font></strong><font color='grey'> " . $omdb['Production'] . "</font><br/>
	        <strong><font color='#79c5c5'>Description:</font></strong><font color='grey'> " . $omdb['Plot'] . "</font><br/>
            <strong><font color='#79c5c5'>Runtime:</font></strong><font color='grey'> " . $omdb['Runtime'] . "</font><br/>
            <strong><font color='#79c5c5'>IMDB Rating:</font></strong><span color='white'> " . $omdb['imdbRating'] . "</span><span style='color:grey;'>&nbspfrom&nbsp&nbsp</span><span color='white'>".$omdb['imdbVotes']."</span><span style='color:grey;'>&nbspVotes</span><br/><br/>
            </div></div>";

        /*if (empty($torrents["poster"]) or ($torrents["poster"] == "./pic/nopostermov.jpg") && $omdb['Poster'] != "./pic/nopostermov.jpg") {
            sql_query("UPDATE torrents SET poster = " . sqlesc($omdb['Poster']) . " WHERE id = $id LIMIT 1") or sqlerr(__file__, __line__);
            $torrents["poster"] = $omdb['Poster'];
            $torrent_cache['poster'] = $omdb['Poster'];
            if ($torrent_cache) {
                $mc1->update_row(false, $torrent_cache);
                $mc1->commit_transaction($INSTALLER09['expires']['torrent_details']);
                $mc1->delete_value('top5_tor_');
                $mc1->delete_value('last5_tor_');
                $mc1->delete_value('scroll_tor_');
            }
        }*/

    }
}
if (!empty($torrents['youtube'])) {
    $HTMLOUT .= "<div class='row' style='background-color:rgba(0,0,0,0);;'>
            <div class='col-md-12'><h3 class='text-center'><strong><font color='#79c5c5'>Trailer </font></strong><span style='font-size:12px;'>(Some videos may be unavailable in your region)</span></h3><br>";
    $HTMLOUT .= "<div><iframe style='margin-left:13%;text-align:center;justify-content:center;' id=\"ytplayer\" type=\"text/html\" width=\"75%\" height=\"450px\" src=\"{$torrents['youtube']}\" frameborder=\"0\"></iframe></div></td></tr>";
}else if (!empty($yt)) {
    $HTMLOUT .= "<div class='row' style='background-color:rgba(0,0,0,0);;'>
            <div class='col-md-12'><h3 class='text-center'><strong><font color='#79c5c5'>Trailer </font></strong><span style='font-size:12px;'>(Some videos may be unavailable in your region)</span></h3><br>";
    $HTMLOUT .= "<div><iframe style='margin-left:13%;text-align:center;justify-content:center;' id=\"ytplayer\" type=\"text/html\" width=\"75%\" height=\"450px\" src=\"$trailer\" frameborder=\"0\"></iframe></div></td></tr>";
} else  {
    $HTMLOUT.= "<tr><td>No youtube data found</td></tr>";
}


$d_name = ($omdb['Title'] . " (". $omdb['Year'] . ")");
sql_query("UPDATE torrents SET name = " . sqlesc($d_name) . " WHERE id = $id LIMIT 1") or sqlerr(__file__, __line__);



?>