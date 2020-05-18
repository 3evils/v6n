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
//== loginlink mod - stonebreath/laffin
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (CLASS_DIR . 'class_browser.php');
dbconn();

global $CURUSER;
if (isset($CURUSER)) {
    header("Location: {$INSTALLER09['baseurl']}/index.php");
    exit();
}
$lang = array_merge(load_language('global') , load_language('takelogin'));
//== flood check
function bark()
{
    global $lang, $INSTALLER09, $mc1;
    $sha = sha1($_SERVER['REMOTE_ADDR']);
    $dict_key = 'dictbreaker:::' . $sha;
    $flood = $mc1->get_value($dict_key);
    if ($flood === false) $mc1->cache_value($dict_key, 'flood_check', 20);
    else die($lang['tlogin_err4']);
}
//== 09 failed logins thanks to pdq - Retro
function failedloginscheck()
{
    global $INSTALLER09, $lang;
    $total = 0;
    $ip = getip();
    $res = sql_query("SELECT SUM(attempts) FROM failedlogins WHERE ip=" . sqlesc($ip)) or sqlerr(__FILE__, __LINE__);
    list($total) = mysqli_fetch_row($res);
    if ($total >= $INSTALLER09['failedlogins']) {
        sql_query("UPDATE failedlogins SET banned = 'yes' WHERE ip=" . sqlesc($ip)) or sqlerr(__FILE__, __LINE__);
        bark();
        die("{$lang['tlogin_locked']} - {$lang['tlogin_lockerr1']} . <b>(" . htmlsafechars($ip) . ")</b> . {$lang['tlogin_lockerr2']}");
    }
}
//==End
failedloginscheck();
$ip = getip();
if (!mkglobal("qlogin") || (strlen($qlogin = $qlogin) != 96)) {
    $added = TIME_NOW;
    $fail = (mysqli_fetch_row(sql_query("SELECT COUNT(id) from failedlogins where ip=" . sqlesc($ip)))) or sqlerr(__FILE__, __LINE__);
        if ($fail[0] == 0) sql_query("INSERT INTO failedlogins (ip, added, attempts) VALUES (" . sqlesc($ip) . ", " . sqlesc($added) . ", 1)") or sqlerr(__FILE__, __LINE__);
        else sql_query("UPDATE failedlogins SET attempts = attempts + 1 WHERE ip=" . sqlesc($ip)) or sqlerr(__FILE__, __LINE__);
        bark();
        die($lang['tlogin_err5']);
}
$hash1 = substr($qlogin, 0, 32);
$hash2 = substr($qlogin, 32, 32);
$hash3 = substr($qlogin, 64, 32);
$hash1.= $hash2 . $hash3;
$res = sql_query("SELECT id, username, perms, passhash, enabled FROM users WHERE hash1 = " . sqlesc($hash1) . " AND class >= " . UC_STAFF . " AND status = 'confirmed' LIMIT 1") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_assoc($res);
if (!$row) {
    $added = TIME_NOW;
    $fail = (mysqli_fetch_row(sql_query("SELECT COUNT(id) from failedlogins where ip=" . sqlesc($ip)))) or sqlerr(__FILE__, __LINE__);
    if ($fail[0] == 0) sql_query("INSERT INTO failedlogins (ip, added, attempts) VALUES (" . sqlesc($ip) . ", " . sqlesc($added) . ", 1)") or sqlerr(__FILE__, __LINE__);
    else sql_query("UPDATE failedlogins SET attempts = attempts + 1 WHERE ip=" . sqlesc($ip)) or sqlerr(__FILE__, __LINE__);
    bark();
}
if ($row['enabled'] == 'no') die($lang['tlogin_disabled']);
sql_query("DELETE FROM failedlogins WHERE ip = " . sqlesc($ip)) or sqlerr(__FILE__, __LINE__);
$userid = (int)$row["id"];
$row['perms'] = (int)$row['perms'];
//== Start ip logger - Melvinmeow, Mindless, pdq
$no_log_ip = ($row['perms'] & bt_options::PERMS_NO_IP);
if ($no_log_ip) {
    $ip = '127.0.0.1';
    $ip_escaped = sqlesc($ip);
}
if (!$no_log_ip) {
    $res = sql_query("SELECT * FROM ips WHERE ip=$ip_escaped AND userid =" . sqlesc($userid)) or sqlerr(__FILE__, __LINE__);
    if (mysqli_num_rows($res) == 0) {
        sql_query("INSERT INTO ips (userid, ip, lastlogin, type) VALUES (" . sqlesc($userid) . ", $ip_escaped , $added, 'Login')") or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('ip_history_' . $userid);
    } else {
        sql_query("UPDATE ips SET lastlogin=$added WHERE ip=$ip_escaped AND userid=" . sqlesc($userid)) or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('ip_history_' . $userid);
    }
} // End Ip logger
// output browser
$ua = getBrowser();
$browser = "Browser: " . $ua['name'] . " " . $ua['version'] . ". Os: " . $ua['platform'] . ". Agent : " . $ua['userAgent'];
sql_query('UPDATE users SET browser=' . sqlesc($browser) . ', ip = ' . $ip_escaped . ', last_access=' . TIME_NOW . ', last_login=' . TIME_NOW . ' WHERE id=' . sqlesc($row['id'])) or sqlerr(__FILE__, __LINE__);
$mc1->begin_transaction('MyUser_' . $row['id']);
$mc1->update_row(false, array(
    'browser' => $browser,
    'ip' => $ip,
    'last_access' => TIME_NOW,
    'last_login' => TIME_NOW
));
$mc1->commit_transaction($INSTALLER09['expires']['curuser']);
$mc1->begin_transaction('user' . $row['id']);
$mc1->update_row(false, array(
    'browser' => $browser,
    'ip' => $ip,
    'last_access' => TIME_NOW,
    'last_login' => TIME_NOW
));
$mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
$passh = md5($row["passhash"] . $_SERVER["REMOTE_ADDR"]);
logincookie($row["id"], $passh);
$HTMLOUT = '';
$HTMLOUT.= "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN'
'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<title>{$INSTALLER09['site_name']} Redirecting</title>
<link rel='stylesheet' href='./templates/1/1.css' type='text/css' />
<meta http-equiv='Refresh' content='1; URL=" . $INSTALLER09['baseurl'] ."/index.php' />
</head>
<body>
<p><br /></p>
<p><br /></p>
<p><br /></p>
<p><br /></p>
<p></p>
<p align='center'><strong>Welcome Back - " . htmlsafechars($row['username']) . ".</strong></p><br />
<p align='center'><strong>Click <a href='" . $INSTALLER09['baseurl'] . "/index.php'>here</a> if you are not redirected automatically.</strong></p><br />
</body>
</html>";
echo $HTMLOUT;
?>
