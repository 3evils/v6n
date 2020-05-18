<?php
if (($friends = $mc1->get_value('Friends_' . $id)) === false) {
	$r3 = sql_query("SELECT id FROM friends WHERE userid=" . sqlesc($CURUSER['id']) . " AND friendid=" . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
	$friends = mysqli_num_rows($r3);
	$mc1->cache_value('Friends_' . $id, $friends, $INSTALLER09['expires']['user_friends']);
}
if (($blocks = $mc1->get_value('Blocks_' . $id)) === false) {
	$r4 = sql_query("SELECT id FROM blocks WHERE userid=" . sqlesc($CURUSER['id']) . " AND blockid=" . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
	$blocks = mysqli_num_rows($r4);
	$mc1->cache_value('Blocks_' . $id, $blocks, $INSTALLER09['expires']['user_blocks']);
}
$HTMLOUT.= $friends > 0 ? "<a class='button tiny alert hollow float-right' href='friends.php?action=delete&amp;type=friend&amp;targetid=$id'><i class='fas fa-user-times'></i>{$lang['userdetails_remove_friends']}</a>" : "<a class='button tiny hollow float-right' href='friends.php?action=add&amp;type=friend&amp;targetid=$id'><i class='fas fa-user-plus'></i>{$lang['userdetails_add_friends']}</a>";
$HTMLOUT.= $blocks > 0 ? "<a class='button tiny hollow alert float-right' href='friends.php?action=delete&amp;type=block&amp;targetid=$id'><i class='fas fa-user-times'></i>{$lang['userdetails_remove_blocks']}</a>" : "<a class='button tiny hollow float-right' href='friends.php?action=add&amp;type=block&amp;targetid=$id'><i class='fas fa-user-lock'></i>{$lang['userdetails_add_blocks']}</a>";