<?php
$HTMLOUT.= '<div class="grid-x grid-padding-x">
  <div class="cell large-4 flex-container flex-dir-column">';
  $poster_url = ((empty($torrents["poster"])) ? $INSTALLER09["pic_base_url"] ."noposter.png" : htmlsafechars($torrents["poster"]));
	$HTMLOUT.= '<div class="card-section">
	  <div class="media-object-section">
    <div class="thumbnail">
      <img src="'.$poster_url.'">
    </div>
  </div>
	</div>';
if (!empty($torrents["description"])) {
$HTMLOUT.= "<div class='card-section'><table class='striped'><th class='text-center'>{$lang['details_small_descr']}</th><tr><td class='details-text-ellipsis'><i>" . htmlsafechars($torrents['description']) . "</i></td></tr></table></div>";
} else {
$HTMLOUT.= "<table class='striped'><th>{$lang['details_small_descr']}</th><tr><td><i>{$lang['details_add_nodscrp']}</i></td></tr></table>";
} 
$HTMLOUT.= '</div>';
//==09 Poster mod
$HTMLOUT .= "<div style='display:block;height:20px'></div>";
    $Free_Slot = (XBT_TRACKER == true ? '' : $freeslot);
    $Free_Slot_Zip = (XBT_TRACKER == true ? '' : $freeslot_zip);
    $Free_Slot_Text = (XBT_TRACKER == true ? '' : $freeslot_text);
  
$HTMLOUT.= "
<div class='cell large-8'>
    <table class='striped'>
	<tbody>
            <tr>
            <td width='20%'>{$lang['details_download']}</td>
            <td class='details-text-ellipsis'>
            <a class='index' href='download.php?torrent={$id}" . ($CURUSER['ssluse'] == 3 ? "&amp;ssl=1" : "") . "'>&nbsp;<u>" . htmlsafechars($torrents["filename"]) . "</u></a>{$Free_Slot}
            </td>
            </tr>";
    /** end **/
    //==Torrent as zip by putyn
    $HTMLOUT.= "<tr>
        <td>{$lang['details_zip']}</td>
        <td class='details-text-ellipsis'>
        <a href='download.php?torrent={$id}" . ($CURUSER['ssluse'] == 3 ? "&amp;ssl=1" : "") . "&amp;zip=1'>&nbsp;<u>" . htmlsafechars($torrents["filename"]) . "</u></a>{$Free_Slot_Zip}</td></tr>";
    //==Torrent as text by putyn
    $HTMLOUT.= "<tr>
        <td>{$lang['details_text']}</td>
        <td class='details-text-ellipsis'>
        <a href='download.php?torrent={$id}" . ($CURUSER['ssluse'] == 3 ? "&amp;ssl=1" : "") . "&amp;text=1'>&nbsp;<u>" . htmlsafechars($torrents["filename"]) . "</u></a>{$Free_Slot_Text}</td></tr></tbody></table>";
    $HTMLOUT.= "
	<div class='table-scroll'>
    <table class='striped'>
	<tbody>
        <tr>
        <td>{$lang['details_tags']}</td>
        <td>" . $keywords . "</td>
        </tr>";
    /**  Mod by dokty, rewrote by pdq  **/    
$my_points = 0;
    if (($torrent['torrent_points_'] = $mc1->get_value('coin_points_' . $id)) === false) {
        $sql_points = sql_query('SELECT userid, points FROM coins WHERE torrentid=' . sqlesc($id));
        $torrent['torrent_points_'] = array();
        if (mysqli_num_rows($sql_points) !== 0) {
            while ($points_cache = mysqli_fetch_assoc($sql_points)) $torrent['torrent_points_'][$points_cache['userid']] = $points_cache['points'];
        }
        $mc1->add_value('coin_points_' . $id, $torrent['torrent_points_'], 0);
    }
    $my_points = (isset($torrent['torrent_points_'][$CURUSER['id']]) ? (int)$torrent['torrent_points_'][$CURUSER['id']] : 0);
    $HTMLOUT.= '<tr>
        <td>'.$lang['details_add_karma1'].'</td>
        <td><b>'.$lang['details_add_karma2'].'' . (int)$torrents['points'] . ''.$lang['details_add_karma3'].'' . $my_points . ''.$lang['details_add_karma4'].'<br /><br />
        <a href="coins.php?id=' . $id . '&amp;points=10"><img src="' . $INSTALLER09['pic_base_url'] . '10coin.png" alt="10" title="'.$lang['details_add_kar10'].'" /></a>&nbsp;&nbsp;
        <a href="coins.php?id=' . $id . '&amp;points=20"><img src="' . $INSTALLER09['pic_base_url'] . '20coin.png" alt="20" title="'.$lang['details_add_kar20'].'" /></a>&nbsp;&nbsp;
        <a href="coins.php?id=' . $id . '&amp;points=50"><img src="' . $INSTALLER09['pic_base_url'] . '50coin.png" alt="50" title="'.$lang['details_add_kar50'].'" /></a>&nbsp;&nbsp;
        <a href="coins.php?id=' . $id . '&amp;points=100"><img src="' . $INSTALLER09['pic_base_url'] . '100coin.png" alt="100" title="'.$lang['details_add_kar100'].'" /></a>&nbsp;&nbsp;
        <a href="coins.php?id=' . $id . '&amp;points=200"><img src="' . $INSTALLER09['pic_base_url'] . '200coin.png" alt="200" title="'.$lang['details_add_kar200'].'" /></a>&nbsp;&nbsp;
        <a href="coins.php?id=' . $id . '&amp;points=500"><img src="' . $INSTALLER09['pic_base_url'] . '500coin.png" alt="500" title="'.$lang['details_add_kar500'].'" /></a>&nbsp;&nbsp;
        <a href="coins.php?id=' . $id . '&amp;points=1000"><img src="' . $INSTALLER09['pic_base_url'] . '1000coin.png" alt="1000" title="'.$lang['details_add_kar1000'].'" /></a></b>&nbsp;&nbsp;
        <br />'.$lang['details_add_karma'].'</td></tr>';
      /** pdq's ratio afer d/load **/
    $downl = ($CURUSER["downloaded"] + $torrents["size"]);
    $sr = $CURUSER["uploaded"] / $downl;
    switch (true) {
    case ($sr >= 4):
        $s = "w00t";
        break;

    case ($sr >= 2):
        $s = "grin";
        break;

    case ($sr >= 1):
        $s = "smile1";
        break;

    case ($sr >= 0.5):
        $s = "noexpression";
        break;

    case ($sr >= 0.25):
        $s = "sad";
        break;

    case ($sr > 0.00):
        $s = "cry";
        break;

    default;
    $s = "w00t";
    break;
}
$sr = floor($sr * 1000) / 1000;
$sr = "<font color='" . get_ratio_color($sr) . "'>" . number_format($sr, 3) . "</font>&nbsp;&nbsp;<img src='pic/smilies/{$s}.gif' alt='' />";
if ($torrents['free'] >= 1 || $torrents['freetorrent'] >= 1 || $isfree['yep'] || $free_slot OR $double_slot != 0 || $CURUSER['free_switch'] != 0) {
    $HTMLOUT.= "<tr>
        <td>{$lang['details_add_ratio1']}</td>
        <td class='details-text-ellipsis'><del>{$sr}&nbsp;&nbsp;{$lang['details_add_ratio2']}</del> <b><font size='' color='#FF0000'>{$lang['details_add_ratio3']}</font></b>{$lang['details_add_ratio4']}</td></tr>";
} else {
    $HTMLOUT.= "<tr>
        <td>{$lang['details_add_ratio1']}</td>
        <td>{$sr}&nbsp;&nbsp;{$lang['details_add_ratio2']}</td></tr>";
}
//==End
function hex_esc($matches) {
    return sprintf("%02x", ord($matches[0]));
}
$HTMLOUT .= tr("{$lang['details_info_hash']}", '<div class="details-text-ellipsis">' .preg_replace_callback('/./s', "hex_esc", hash_pad($torrents["info_hash"])) . '</div>',true);
    $HTMLOUT.= "</tbody></table></div></div>";
$HTMLOUT.= "</div>";
	?>