<?php
if ($CURUSER['class'] >= UC_POWER_USER) { 
//== Snatched Torrents mod
$What_Table = (XBT_TRACKER == true ? 'xbt_peers' : 'snatched');
$What_cache = (XBT_TRACKER == true ? 'snatched_tor_xbt_' : 'snatched_tor_');
$What_Value = (XBT_TRACKER == true ? 'WHERE completedtime != "0"' : 'WHERE complete_date != "0"');
$Which_ID = (XBT_TRACKER == true ? 'tid' : 'id');
$Which_T_ID = (XBT_TRACKER == true ? 'tid' : 'torrentid');
$Which_Key_ID = (XBT_TRACKER == true ? 'snatched_count_xbt_' : 'snatched_count_');
$keys['Snatched_Count'] = $Which_Key_ID . $id;

    if (($Row_Count = $mc1->get_value($keys['Snatched_Count'])) === false) {
$Count_Q = sql_query("SELECT COUNT($Which_ID) FROM $What_Table $What_Value AND $Which_T_ID =" . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
$Row_Count = mysqli_fetch_row($Count_Q);
$mc1->cache_value($keys['Snatched_Count'], $Row_Count, $INSTALLER09['expires']['details_snatchlist']);
}
$Count = $Row_Count[0];
$perpage = 15;
$pager = pager($perpage, $Count, "details.php?id=$id&amp;");
$HTMLOUT.= "
<h3 class='text-center'>{$lang['details_add_snatch1']}<a href='{$INSTALLER09['baseurl']}/details.php?id=" . (int)$torrents['id'] . "'>" . htmlsafechars($torrents['name']) . "</a><br />{$lang['details_add_snatch2']}{$Row_Count['0']}{$lang['details_add_snatch3']}" . ($Row_Count[0] == 1 ? "" : "es") . "</h3>\n";

if (($Detail_Snatch = $mc1->get_value($What_cache . $id)) === false) {
    if (XBT_TRACKER == true) {
     //== \\0//
      $Main_Q = sql_query("SELECT x.*, x.uid AS su, torrents.username as username1, users.username as username2, users.paranoia, torrents.anonymous as anonymous1, users.anonymous as anonymous2, size, parked, warned, enabled, class, chatpost, leechwarn, donor, owner FROM xbt_peers AS x INNER JOIN users ON x.uid = users.id INNER JOIN torrents ON x.tid = torrents.id WHERE completedtime !=0 AND tid = " . sqlesc($id) . " ORDER BY completedtime DESC " . $pager['limit']) or sqlerr(__FILE__, __LINE__);
} else {
      $Main_Q = sql_query("SELECT s.*, s.userid AS su, torrents.username as username1, users.username as username2, users.paranoia, torrents.anonymous as anonymous1, users.anonymous as anonymous2, size, parked, warned, enabled, class, chatpost, leechwarn, donor, timesann, owner FROM snatched AS s INNER JOIN users ON s.userid = users.id INNER JOIN torrents ON s.torrentid = torrents.id WHERE complete_date !=0 AND torrentid = " . sqlesc($id) . " ORDER BY complete_date DESC " . $pager['limit']) or sqlerr(__FILE__, __LINE__);
}
    while ($snatched_torrent = mysqli_fetch_assoc($Main_Q)) $Detail_Snatch[] = $snatched_torrent;
    $mc1->cache_value($What_cache . $id, $Detail_Snatch, $INSTALLER09['expires']['details_snatchlist']);
}

if (($Detail_Snatch && count($Detail_Snatch) > 0 && $CURUSER['class'] >= UC_STAFF)) {
    if ($Count > $perpage) $HTMLOUT.= $pager['pagertop'];
 //== \\0//
 if (XBT_TRACKER == true) {
    $snatched_torrent = "
<table class='table-bordered'>
<tr>
<td class='colhead' align='left'>{$lang['details_snatches_username']}</td>
<td class='colhead' align='right'>{$lang['details_snatches_uploaded']}</td>
" . ($INSTALLER09['ratio_free'] ? "" : "<td class='colhead' align='right'>{$lang['details_snatches_downloaded']}</td>") . "
<td class='colhead' align='right'>{$lang['details_snatches_ratio']}</td>
<td class='colhead' align='right'>{$lang['details_snatches_seedtime']}</td>
<td class='colhead' align='right'>{$lang['details_snatches_leechtime']}</td>
<td class='colhead' align='center'>{$lang['details_snatches_lastaction']}</td>
<td class='colhead' align='center'>{$lang['details_snatches_completedat']}</td>
<td class='colhead' align='center'>{$lang['details_snatches_announced']}</td>
<td class='colhead' align='center'>{$lang['details_snatches_active']}</td>
<td class='colhead' align='right'>{$lang['details_snatches_completed']}</td>
</tr>\n";
    } else {
    $snatched_torrent = "
<table class='table-bordered'>
<tr>
<td class='colhead' align='left'>{$lang['details_snatches_username']}</td>
<td class='colhead' align='center'>{$lang['details_snatches_connectable']}</td>
<td class='colhead' align='right'>{$lang['details_snatches_uploaded']}</td>
<td class='colhead' align='right'>{$lang['details_snatches_upspeed']}</td>
" . ($INSTALLER09['ratio_free'] ? "" : "<td class='colhead' align='right'>{$lang['details_snatches_downloaded']}</td>") . "
" . ($INSTALLER09['ratio_free'] ? "" : "<td class='colhead' align='right'>{$lang['details_snatches_downspeed']}</td>") . "
<td class='colhead' align='right'>{$lang['details_snatches_ratio']}</td>
<td class='colhead' align='right'>{$lang['details_snatches_completed']}</td>
<td class='colhead' align='right'>{$lang['details_snatches_seedtime']}</td>
<td class='colhead' align='right'>{$lang['details_snatches_leechtime']}</td>
<td class='colhead' align='center'>{$lang['details_snatches_lastaction']}</td>
<td class='colhead' align='center'>{$lang['details_snatches_completedat']}</td>
<td class='colhead' align='center'>{$lang['details_snatches_client']}</td>
<td class='colhead' align='center'>{$lang['details_snatches_port']}</td>
<td class='colhead' align='center'>{$lang['details_snatches_announced']}</td>
</tr>\n";
}

    if ($Detail_Snatch) {
        foreach ($Detail_Snatch as $D_S) {
          
if (XBT_TRACKER == true) {
           //== \\0//
           $ratio = ($D_S["downloaded"] > 0 ? number_format($D_S["uploaded"] / $D_S["downloaded"], 3) : ($D_S["uploaded"] > 0 ? "Inf." : "---"));
           $active = ($D_S['active'] == 1 ? $active = "<img src='" . $INSTALLER09['pic_base_url'] . "aff_tick.gif' alt='Yes' title='Yes' />" : $active = "<img src='" . $INSTALLER09['pic_base_url'] . "aff_cross.gif' alt='No' title='No' />");
           $completed = ($D_S['completed'] >= 1 ? $completed = "<img src='" . $INSTALLER09['pic_base_url'] . "aff_tick.gif' alt='Yes' title='Yes' />" : $completed = "<img src='" . $INSTALLER09['pic_base_url'] . "aff_cross.gif' alt='No' title='No' />");
           $snatchuserxbt = (isset($D_S['username2']) ? ("<a href='userdetails.php?id=" . (int)$D_S['uid'] . "'><b>" . htmlsafechars($D_S['username2']) . "</b></a>") : "{$lang['details_snatches_unknown']}");
           $username_xbt = (($D_S['anonymous2'] == 'yes' OR $D_S['paranoia'] >= 2) ? ($CURUSER['class'] < UC_STAFF && $D_S['uid'] != $CURUSER['id'] ? '' : $snatchuserxbt . ' - ') . "<i>{$lang['details_snatches_anon']}</i>" : $snatchuserxbt);
           $snatched_torrent.= "<tr>
                                 <td align='left'><font size='2%'>{$username_xbt}</font></td>
                                 <td align='right'><font size='2%'>" . mksize($D_S["uploaded"]) . "</font></td>
  " . ($INSTALLER09['ratio_free'] ? "" : "<td align='right'><font size='2%'>" . mksize($D_S["downloaded"]) . "</font></td>") . "
                                 <td align='right'><font size='2%'>" . htmlsafechars($ratio) . "</font></td>
                                 <td align='right'><font size='2%'>" . mkprettytime($D_S["seedtime"]) . "</font></td>
                                 <td align='right'><font size='2%'>" . mkprettytime($D_S["leechtime"]) . "</font></td>
                                 <td align='center'><font size='2%'>" . get_date($D_S["mtime"], '', 0, 1) . "</font></td>
                                 <td align='center'><font size='2%'>" . get_date($D_S["completedtime"], '', 0, 1) . "</font></td>
                                 <td align='center'><font size='2%'>" . (int)$D_S["announced"] . "</font></td>
                                 <td align='center'><font size='2%'>" . $active . "</font></td>
                                 <td align='center'><font size='2%'>" . $completed . "</font></td>
        </tr>\n";

} else {
 $upspeed = ($D_S["upspeed"] > 0 ? mksize($D_S["upspeed"]) : ($D_S["seedtime"] > 0 ? mksize($D_S["uploaded"] / ($D_S["seedtime"] + $D_S["leechtime"])) : mksize(0)));
           $downspeed = ($D_S["downspeed"] > 0 ? mksize($D_S["downspeed"]) : ($D_S["leechtime"] > 0 ? mksize($D_S["downloaded"] / $D_S["leechtime"]) : mksize(0)));
    $ratio = ($D_S["downloaded"] > 0 ? number_format($D_S["uploaded"] / $D_S["downloaded"], 3) : ($D_S["uploaded"] > 0 ? "Inf." : "---"));
           $completed = sprintf("%.2f%%", 100 * (1 - ($D_S["to_go"] / $D_S["size"])));
           $snatchuser = (isset($D_S['username2']) ? ("<a href='userdetails.php?id=" . (int)$D_S['userid'] . "'><b>" . htmlsafechars($D_S['username2']) . "</b></a>") : "{$lang['details_snatches_unknown']}");
           $username = (($D_S['anonymous2'] == 'yes' OR $D_S['paranoia'] >= 2) ? ($CURUSER['class'] < UC_STAFF && $D_S['userid'] != $CURUSER['id'] ? '' : $snatchuser . ' - ') . "<i>{$lang['details_snatches_anon']}</i>" : $snatchuser);
$snatched_torrent.= "<tr>
                                 <td align='left'><font size='2%'>{$username}</font></td>
                                 <td align='center'><font size='2%'>" . ($D_S["connectable"] == "yes" ? "<font color='green'>{$lang['details_add_yes']}</font>" : "<font color='red'>{$lang['details_add_no']}</font>") . "</font></td>
                                 <td align='right'><font size='2%'>" . mksize($D_S["uploaded"]) . "</font></td>
                                 <td align='right'><font size='2%'>" . htmlsafechars($upspeed) . "/s</font></td>
  " . ($INSTALLER09['ratio_free'] ? "" : "<td align='right'><font size='2%'>" . mksize($D_S["downloaded"]) . "</font></td>") . "
  " . ($INSTALLER09['ratio_free'] ? "" : "<td align='right'><font size='2%'>" . htmlsafechars($downspeed) . "/s</font></td>") . "
                                 <td align='right'><font size='2%'>" . htmlsafechars($ratio) . "</font></td>
                                 <td align='right'><font size='2%'>" . htmlsafechars($completed) . "</font></td>
                                 <td align='right'><font size='2%'>" . mkprettytime($D_S["seedtime"]) . "</font></td>
                                 <td align='right'><font size='2%'>" . mkprettytime($D_S["leechtime"]) . "</font></td>
                                 <td align='center'><font size='2%'>" . get_date($D_S["last_action"], '', 0, 1) . "</font></td>
                                 <td align='center'><font size='2%'>" . get_date($D_S["complete_date"], '', 0, 1) . "</font></td>
                                 <td align='center'><font size='2%'>" . htmlsafechars($D_S["agent"]) . "</font></td>
                                 <td align='center'><font size='2%'>" . (int)$D_S["port"] . "</font></td>
                                 <td align='center'><font size='2%'>" . (int)$D_S["timesann"] . "</font></td>
        </tr>\n";
        }

}

$snatched_torrent.= "</table>";
$HTMLOUT.= "
<p class='text-center'>{$lang['details_add_snatch4']}</p>
<div class='panel-body'>
        <div class='panel-group' id='accordion'>
            <div id='collapseOne' class='panel-collapse collapse in'>
                <div class='panel'>
                    <div class='panel-body'>$snatched_torrent</div></div></div>";
} else {
 if (empty($Detail_Snatch)) $HTMLOUT.= "<p class='text-center'>{$lang['details_add_snatch4']}</p>
<div class='panel-body'>
        <div class='panel-group' id='accordion'>
            <div id='collapseOne' class='panel-collapse collapse in'>
                <div class='panel'>
                    <div class='panel-body'><h3 class=text-center'>{$lang['details_add_snatch5']}</h3></div></div></div>";
   }
}
$HTMLOUT .="</div><!-- closing panel-group --></div><!-- closing panel body -->";
$HTMLOUT .= "</div><!-- closing tab pane -->";
}
?>