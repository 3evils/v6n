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
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (CLASS_DIR . 'class_user_options.php');
require_once (CLASS_DIR . 'class_user_options_2.php');
require_once (INCL_DIR . 'user_functions.php');
require_once (INCL_DIR . 'html_functions.php');
require_once (INCL_DIR . 'bbcode_functions.php');
require_once (CLASS_DIR . 'page_verify.php');
require_once (CACHE_DIR . 'timezones.php');
dbconn(false);
loggedinorreturn();
$stdfoot = array(
    /** include js **/
    'js' => array(
        'keyboard',
    )
);
$stdhead = array(
    /** include js **/
    'js' => array(
        'custom-form-elements'
    ),
    /** include css **/
    'css' => array(
         'usercp',
		 'bootstrap_slate.mi.n'
    )
);
//echo user_options::CLEAR_NEW_TAG_MANUALLY;
//die();
$lang = array_merge(load_language('global') , load_language('usercp'), load_language('achievementlist'));
$newpage = new page_verify();
$newpage->create('tkepe');
$HTMLOUT = $stylesheets = $wherecatina = '';
$possible_actions = array(
    'avatar',
    'signature',
	'awards',
    'location',
    'security',
	'social',
    'links',
    'torrents',
    'personal',
    'default'
);
$action = isset($_GET["action"]) ? htmlsafechars(trim($_GET["action"])) : '';
if (!in_array($action, $possible_actions)) stderr('ERROR', $lang['usercp_err1']);
if (isset($_GET["edited"])) {
    $HTMLOUT.= "<br /><div class='alert alert-success span11'>{$lang['usercp_updated']}!</div><br />";
    if (isset($_GET["mailsent"])) $HTMLOUT.= "<h2>{$lang['usercp_mail_sent']}!</h2>\n";
} elseif (isset($_GET["emailch"])) {
    $HTMLOUT.= "<h1>{$lang['usercp_emailch']}!</h1>\n";
}
$HTMLOUT.= "<form method='post' action='takeeditcp.php'>";
//show menu bar
require_once (BLOCK_DIR . 'usercp/navs.php');
//Show Profile picture
require_once (BLOCK_DIR . 'usercp/profile_avatar.php');
//== Avatar
if ($action == "avatar") {
		require_once (BLOCK_DIR . 'usercp/avatar.php');
}
//== Signature
elseif ($action == "signature") {
	require_once (BLOCK_DIR . 'usercp/signature.php');
}
//== award
elseif ($action == "awards") {
	require_once (BLOCK_DIR . 'usercp/awards.php');
}
//== Location
elseif ($action == "location") {
	require_once (BLOCK_DIR . 'usercp/location.php');
}
//== links
elseif ($action == "links") {
	require_once (BLOCK_DIR . 'usercp/links.php');
}
//== Security
elseif ($action == "security") {
    require_once (BLOCK_DIR . 'usercp/security.php');
}
//== Torrents
elseif ($action == "torrents") {
	require_once (BLOCK_DIR . 'usercp/torrents.php');
}
//== Torrents
elseif ($action == "social") {
	require_once (BLOCK_DIR . 'usercp/social.php');
}
//== Personal
elseif ($action == "personal") {
    require_once (BLOCK_DIR . 'usercp/personal.php');
} else {
    if ($action == "default") 
	require_once (BLOCK_DIR . 'usercp/pms.php');
}
$HTMLOUT.= "</form>";
echo stdhead(htmlsafechars($CURUSER["username"], ENT_QUOTES) . "{$lang['usercp_stdhead']} ", true, $stdhead) . $HTMLOUT . stdfoot($stdfoot);
?>
