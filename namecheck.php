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
if (empty($_GET['wantusername'])) {
    die('Silly Rabbit - Twix are for kids - You cant post nothing please enter a username !');
}
sleep(1);
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
dbconn();
$HTMLOUT = "";
$lang = array_merge(load_language('global') , load_language('takesignup'));
function validusername($username)
{
    global $lang;
    if ($username == "") return false;
    $namelength = strlen($username);
    if (($namelength < 3) OR ($namelength > 32)) {
        $HTMLOUT = "";
        $HTMLOUT.= "<p class='text-danger'>{$lang['takesignup_username_length']}</p>";
        echo $HTMLOUT;
        exit();
    }
    // The following characters are allowed in user names
    $allowedchars = $lang['takesignup_allowed_chars'];
    for ($i = 0; $i < $namelength; ++$i) {
        if (strpos($allowedchars, $username[$i]) === false) return false;
    }
    return true;
}
if (!validusername($_GET["wantusername"])) {
    $HTMLOUT.= "<p class='text-danger'>{$lang['takesignup_allowed_chars']}</p>";
    echo $HTMLOUT;
    exit();
}
if (strlen($_GET["wantusername"]) > 12) {
    $HTMLOUT.= "<p class='text-danger'>{$lang['takesignup_username_length']}</p>";
    echo $HTMLOUT;
    exit();
}

$checkname = htmlsafechars($_GET["wantusername"]);
$result = sql_query("SELECT username FROM users WHERE username = ".sqlesc($checkname)) or sqlerr(__FILE__, __LINE__);
$numbers = mysqli_num_rows($result);
if ($numbers > 0) {
    while ($namecheck = mysqli_fetch_assoc($result)) {
        $HTMLOUT.= "<p class='text-danger'><i class='fas fa-times-circle'></i><strong>Sorry... Username - " . htmlsafechars($namecheck["username"]) . " is already in use.</strong></p>";
    }
} else {
    $HTMLOUT.= "<p class='text-success'><i class='fas fa-check-circle'></i><strong>Username Available</strong></p>";
}
echo $HTMLOUT;
exit();
?>
