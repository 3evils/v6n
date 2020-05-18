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
    'forums' => 'forums',
    'shoutbox' => 'shoutbox',
    'login' => 'login',
    'logout' => 'logout',
    'addpre' => 'addpre'
);
if (in_array($page, $main_files) and file_exists(MAIN_DIR . $main_files[$page] . '.php')) {
    require_once MAIN_DIR . $main_files[$page] . '.php';
} else {
	if (!$page) {
        header("Location: {$INSTALLER09['baseurl']}/index.php?page=home");
    }	
}
?>