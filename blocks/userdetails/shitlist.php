<?php
//== 09 Shitlist by Sir_Snuggles
if ($CURUSER['class'] >= UC_STAFF) {
    $shitty = '';
    if (($shit_list = $mc1->get_value('shit_list_' . $id)) === false) {
        $check_if_theyre_shitty = sql_query("SELECT suspect FROM shit_list WHERE userid=" . sqlesc($CURUSER['id']) . " AND suspect=" . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
        list($shit_list) = mysqli_fetch_row($check_if_theyre_shitty);
        $mc1->cache_value('shit_list_' . $id, $shit_list, $INSTALLER09['expires']['shit_list']);
    }
    if ($shit_list > 0) {
        $HTMLOUT.= "<b>{$lang['userdetails_shit1']} <a class='button small hollow float-right' href='staffpanel.php?tool=shit_list&amp;action=shit_list'>{$lang['userdetails_here']}</a> {$lang['userdetails_shit2']}&nbsp;" . $shitty . "</b>";
    } 
	if ($CURUSER['class'] >= UC_STAFF && $CURUSER["id"] <> $user["id"]) {
        $HTMLOUT.= "<a class='button tiny hollow float-right' href='staffpanel.php?tool=shit_list&amp;action=shit_list&amp;action2=new&amp;shit_list_id=" . $id . "&amp;return_to=userdetails.php?id=" . $id . "'><i class='fas fa-poop'></i>{$lang['userdetails_shit3']}</a>";
    }
}