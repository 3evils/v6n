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
// Achievements mod by MelvinMeow
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (INCL_DIR . 'user_functions.php');
require_once (INCL_DIR . 'pager_functions.php');
require_once (CLASS_DIR . 'page_verify.php');
dbconn();
loggedinorreturn();
$newpage = new page_verify();
$newpage->create('takecounts');
$lang = array_merge(load_language('global') , load_language('achievement_history'));

if ($INSTALLER09['achieve_sys_on'] == false) {
stderr($lang['achievement_history_err'], $lang['achievement_history_off']);
exit();
}

$HTMLOUT = "";
$id = (int)$_GET["id"];

if (!is_valid_id($id)) stderr($lang['achievement_history_err'], $lang['achievement_history_err1']);
$res = sql_query("SELECT users.id, users.username, usersachiev.achpoints, usersachiev.spentpoints FROM users LEFT JOIN usersachiev ON users.id = usersachiev.id WHERE users.id = " . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
$arr = mysqli_fetch_assoc($res);
if (!$arr) stderr($lang['achievement_history_err'], $lang['achievement_history_err1']);
$achpoints = (int)$arr['achpoints'];
$spentpoints = (int)$arr['spentpoints'];
$res = sql_query("SELECT COUNT(*) FROM achievements WHERE userid =" . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_row($res);
$count = $row[0];
$perpage = 15;
if (!$count) stderr($lang['achievement_history_no'], "{$lang['achievement_history_err2']}<a class='altlink' href='userdetails.php?id=" . (int)$arr['id'] . "'>" . htmlsafechars($arr['username']) . "</a>{$lang['achievement_history_err3']}");
$pager = pager($perpage, $count, "?id=$id&amp;");
if ($id == $CURUSER['id']) {
	require_once (BLOCK_DIR . 'achievements/ach_history_nav.php');
}
require_once (BLOCK_DIR . 'achievements/ach_history_info.php');
if ($count > $perpage) $HTMLOUT.= $pager['pagertop'];
require_once (BLOCK_DIR . 'achievements/ach_history.php');
if ($count > $perpage) $HTMLOUT.= $pager['pagerbottom'];
echo stdhead($lang['achievement_history_stdhead']) . $HTMLOUT . stdfoot();
die;
?>
