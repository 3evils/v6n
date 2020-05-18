<?php
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
dbconn(true);
loggedinorreturn();
$HTMLOUT = '';
$page = (isset($_GET['page']) ? $_GET['page'] : (isset($_POST['page']) ? $_POST['page'] : NULL));
$page = isset($_GET['page']) ? $_GET['page'] : '';

$main_files = array(
    'upload' => 'upload',
    'browse' => 'browse',
    'bookmarks' => 'bookmarks',
    'achievementlist' => 'achievementlist',
	'achievementbonus' => 'achievementbonus',
    'home' => 'home',
    'topten' => 'topten',
    'faq' => 'faq',
    'rules' => 'rules',
    'chat' => 'chat',
    'staff' => 'staff',
    'wiki' => 'wiki',
    'rsstfreak' => 'rsstfreak',
    'casino' => 'casino',
    'blackjack' => 'blackjack',
    'sitepot' => 'sitepot',
    'requests' => 'requests',
    'offers' => 'offers',
    'needseed' => 'needseed',
    'uploadapp' => 'uploadapp',
    'multiupload' => 'multiupload',
    'editlog' => 'editlog',
    'reset' => 'reset',
    'iphistory' => 'iphistory',
    'ipsearch' => 'ipsearch',
    'ipcheck' => 'ipcheck',
    'inactive' => 'inactive',
    'snatched_torrents' => 'snatched_torrents',
    'events' => 'events',
    'bonusmanage' => 'bonusmanage',
    'floodlimit' => 'floodlimit',
    'stats_extra' => 'stats_extra',
    'polls_manager' => 'polls_manager',
    'findnotconnectable' => 'findnotconnectable',
    'namechanger' => 'namechanger',
    'backup' => 'backup',
    'pmview' => 'pmview',
    'reports' => 'reports',
    'nameblacklist' => 'nameblacklist',
    'system_view' => 'system_view',
    'datareset' => 'datareset',
    'grouppm' => 'grouppm',
    'load' => 'load',
    'allagents' => 'allagents',
    'watched_users' => 'watched_users',
    'sysoplog' => 'sysoplog',
    'forum_manage' => 'forum_manage',
    'forum_config' => 'forum_config',
    'over_forums' => 'over_forums',
    'forummanager' => 'forummanager',
    'msubforums' => 'msubforums',
    'moforums' => 'moforums',
    'member_post_history' => 'member_post_history',
    'comment_overview' => 'comment_overview',
    'reputation_ad' => 'reputation_ad',
    'reputation_settings' => 'reputation_settings',
    'mega_search' => 'mega_search',
    'shit_list' => 'shit_list',
    'acpmanage' => 'acpmanage',
    'class_config' => 'class_config',
    'warn' => 'warn',
    'leechwarn' => 'leechwarn',
    'hnrwarn' => 'hnrwarn',
    'cleanup_manager' => 'cleanup_manager',
    'view_peers' => 'view_peers',
    'uploader_info' => 'uploader_info',
    'block.settings' => 'block.settings',
    'groupmessage' => 'groupmessage',
    'paypal_settings' => 'paypal_settings',
    'staff_config' => 'staff_config',
    'site_settings' => 'site_settings',
    'user_hits' => 'user_hits',
    'op' => 'op',
    'memcache' => 'memcache',
    'invite_tree' => 'invite_tree',
    'edit_moods' => 'edit_moods',
    'mass_bonus_for_members' => 'mass_bonus_for_members',
    'deathrow' => 'deathrow',
    'hit_and_run' => 'hit_and_run',
    'hit_and_run_settings' => 'hit_and_run_settings',
    'uploadapps' => 'uploadapps',
    'modtask' => 'modtask',
    'staff_shistory' => 'staff_shistory',
    'bannedemails' => 'bannedemails',
    'cloudview' => 'cloudview',
    'rules_admin' => 'rules_admin',
    'faq_admin' => 'faq_admin',
    'referrers' => 'referrers',
	'traceroute' => 'traceroute',
    'modded_torrents' => 'modded_torrents',
    'comments' => 'comments',
    'comment_check' => 'comment_check',
    'class_promo' => 'class_promo',
    'addpre' => 'addpre'
);
if (in_array($page, $main_files) and file_exists(MAIN_DIR . $main_files[$page] . '.php')) {
    require_once MAIN_DIR . $main_files[$page] . '.php';
} else {
	if (!$page) {
        header("Location: {$INSTALLER09['baseurl']}/page.php?page=home");
        exit();
    }	
}
?>