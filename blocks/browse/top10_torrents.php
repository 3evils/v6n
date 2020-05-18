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
$categorie = genrelist();
foreach ($categorie as $key => $value) $change[$value['id']] = array(
    'id' => $value['id'],
    'name' => $value['name'],
    'image' => $value['image']
);
//== O9 Top 5 and last5 torrents with tooltip
$HTMLOUT.= "<script src='{$INSTALLER09['baseurl']}/scripts/wz_tooltip.js'></script>";
if (($top5torrents = $mc1->get_value('top5_tor_')) === false) {
    $res = sql_query("SELECT id, seeders, poster, leechers, name, category from torrents ORDER BY seeders + leechers DESC LIMIT {$INSTALLER09['latest_torrents_limit']}") or sqlerr(__FILE__, __LINE__);
    while ($top5torrent = mysqli_fetch_assoc($res)) $top5torrents[] = $top5torrent;
    $mc1->cache_value('top5_tor_', $top5torrents);
}
if (!empty($top5torrents)) {
    $HTMLOUT.= "<div class='module'><div class='tbadge tbadge-top'></div>
     	    <table class='table table-bordered'>
            <thead><tr>
            <th scope='col'><b>{$lang['top5torrents_type']}</b></th>
            <th scope='col'><b>{$lang['top5torrents_name']}</b></th>
            <th scope='col'><i class='fas fa-arrow-up'></i></th>
            <th scope='col'>{$lang['top5torrents_leechers']}</th></tr></thead>";
if ($top5torrents) {
        foreach ($top5torrents as $top5torrentarr) {
            $top5torrentarr['cat_name'] = htmlsafechars($change[$top5torrentarr['category']]['name']);
	    $top5torrentarr['cat_pic'] = htmlsafechars($change[$top5torrentarr['category']]['image']);
            $torrname = htmlsafechars($top5torrentarr['name']);
            if (strlen($torrname) > 50) $torrname = substr($torrname, 0, 50) . "...";
            $poster = empty($top5torrentarr["poster"]) ? "<img src=\'{$INSTALLER09['pic_base_url']}noposter.jpg\' width=\'150\' height=\'220\' />" : "<img src=\'" . htmlsafechars($top5torrentarr['poster']) . "\' width=\'150\' height=\'220\' />";
            $HTMLOUT.= "
            <tbody><tr>
            <th scope='row'><img src='pic/caticons/{$CURUSER['categorie_icon']}/" . htmlsafechars($top5torrentarr["cat_pic"]) . "' alt='" . htmlsafechars($top5torrentarr["cat_name"]) . "' title='" . htmlsafechars($top5torrentarr["cat_name"]) . "' /></td>
            <td><a href=\"{$INSTALLER09['baseurl']}/details.php?id=" . (int)$top5torrentarr['id'] . "&amp;hit=1\" onmouseover=\"Tip('<b>{$lang['index_ltst_name']}" . htmlsafechars($top5torrentarr['name']) . "</b><br /><b>{$lang['index_ltst_seeder']}" . (int)$top5torrentarr['seeders'] . "</b><br /><b>{$lang['index_ltst_leecher']}" . (int)$top5torrentarr['leechers'] . "</b><br />$poster');\" onmouseout=\"UnTip();\">{$torrname}</a></td>
          <td>" . (int)$top5torrentarr['seeders'] . "</td>
          <td>" . (int)$top5torrentarr['leechers'] . "</td>     
	 </tr></tbody>";
        }
        $HTMLOUT.= "</table>";
    } else {
        //== If there are no torrents
        if (empty($top5torrents)) $HTMLOUT.= "<table class='table table-bordered'><tbody><tr><td class='text-left' colspan='3'>{$lang['top5torrents_no_torrents']}</td></tr></tbody></table>";
    }
}
$HTMLOUT.="</div>";
//==End	
// End Class
// End File
