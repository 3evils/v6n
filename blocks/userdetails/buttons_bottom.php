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
//== Forum posts
if (($forumposts = $mc1->get_value('forum_posts_' . $id)) === false) {
    $res = sql_query("SELECT COUNT(id) FROM posts WHERE user_id=" . sqlesc($user['id'])) or sqlerr(__FILE__, __LINE__);
    list($forumposts) = mysqli_fetch_row($res);
    $mc1->cache_value('forum_posts_' . $id, $forumposts, $INSTALLER09['expires']['forum_posts']);
}
if ($user['paranoia'] < 2 || $CURUSER['id'] == $id || $CURUSER['class'] >= UC_STAFF) {
    if ($forumposts && (($user["class"] >= UC_POWER_USER && $user["id"] == $CURUSER["id"]) || $CURUSER['class'] >= UC_STAFF)) 
		$HTMLOUT.= "<a class='button small hollow' href='userhistory.php?action=viewposts&amp;id=$id'>{$lang['userdetails_posts']}<span class='badge success'>" . htmlsafechars($forumposts) . "</span></a>";
    else 
		$HTMLOUT.= "<a class='button small hollow'>{$lang['userdetails_posts']}<span class='badge success'>" . htmlsafechars($forumposts) . "</span></a>";
}
//==Torrent comments
if (($torrentcomments = $mc1->get_value('torrent_comments_' . $id)) === false) {
    $res = sql_query("SELECT COUNT(id) FROM comments WHERE user=" . sqlesc($user['id'])) or sqlerr(__FILE__, __LINE__);
    list($torrentcomments) = mysqli_fetch_row($res);
    $mc1->cache_value('torrent_comments_' . $id, $torrentcomments, $INSTALLER09['expires']['torrent_comments']);
}
if ($user['paranoia'] < 2 || $CURUSER['id'] == $id || $CURUSER['class'] >= UC_STAFF) {
    if ($torrentcomments && (($user["class"] >= UC_POWER_USER && $user["id"] == $CURUSER["id"]) || $CURUSER['class'] >= UC_STAFF)) 
		$HTMLOUT.= "<a class='button small hollow' href='userhistory.php?action=viewcomments&amp;id=$id'>{$lang['userdetails_comments']}<span class='badge success'>" . (int)$torrentcomments . "</span></a>";
    else $HTMLOUT.= "<a class='button small hollow'>{$lang['userdetails_comments']}<span class='badge success'>" . (int)$torrentcomments . "</span></a>";
}
//=== member contact mail
if ($CURUSER['class'] >= UC_STAFF || $user['show_email'] === 'yes')
	$HTMLOUT.= '<a class="button small hollow" href="mailto:' . /*decrypt_email(*/htmlsafechars($user['email'])/*)*/ . '" target="_blank">' . $lang['userdetails_send_email'] . '</a>';
else
	$HTMLOUT.= '';
//==Report User
$HTMLOUT.= "<form class='float-right' method='post' action='report.php?type=User&amp;id={$id}'>
	<input type='submit' value='{$lang['userdetails_report']}' class='button small alert hollow'>
</form>";

$HTMLOUT.= "".($CURUSER['id'] == $user['id'] ? "<a class='button small hollow float-right' href='{$INSTALLER09['baseurl']}/usercp.php?action=default'>{$lang['userdetails_editself']}</a>" : "") . "
 ".($CURUSER['id'] == $user['id'] ? "<a class='button small hollow float-right' href='{$INSTALLER09['baseurl']}/view_announce_history.php'>{$lang['userdetails_announcements']}</a>" : "") . "";
$HTMLOUT.= $CURUSER['id'] != $user['id'] ? "<a class='button small hollow float-left' href='{$INSTALLER09['baseurl']}/sharemarks.php?id=$id'>{$lang['userdetails_sharemarks']}</a>" : "";