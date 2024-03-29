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
require_once (INCL_DIR . 'user_functions.php');
require_once (CLASS_DIR . 'page_verify.php');
dbconn();
global $CURUSER;
if (isset($CURUSER)) {
    header("Location: {$INSTALLER09['baseurl']}/index.php");
    exit();
} else {
    get_template();
}
ini_set('session.use_trans_sid', '0');
$stdfoot = '';
if ($INSTALLER09['captcha_on'] === true);
$stdfoot = array(
    /** include js **/
    'js' => array(
           'captcha', 
		   'jquery.simpleCaptcha-0.2'
    )
);

$lang = array_merge(load_language('global') , load_language('login'));
$newpage = new page_verify();
$newpage->create('takelogin');
$left = $total = '';
//== 09 failed logins
function left()
{
    global $INSTALLER09;
    $total = 0;
    $ip = getip();
    $fail = sql_query("SELECT SUM(attempts) FROM failedlogins WHERE ip=" . sqlesc($ip)) or sqlerr(__FILE__, __LINE__);
    list($total) = mysqli_fetch_row($fail);
    $left = $INSTALLER09['failedlogins'] - $total;
    if ($left <= 2) $left = "<span class='button rounded alert'>{$left}</span>";
    else $left = "<span class='button rouned success'>{$left}</span>";
    return $left;
}
//== End Failed logins
$HTMLOUT = "";
$HTMLOUT.= "<div class='grid-container'>
	<div class='grid-x grid-padding-x align-center-middle text-center margin-top-3'>
		<div class='callout margin-top-3'>
			<div class='corner-badge'>".left()."</div>
			<img src='pic/logo.png'>";
unset($returnto);
if (!empty($_GET["returnto"])) {
    $returnto = htmlsafechars($_GET["returnto"]);
        $HTMLOUT.= "<div class='callout alert-callout-border warning'><p class='text-center'>{$lang['login_error']}</p></div>";
}
$HTMLOUT.= "".($INSTALLER09['captcha_on'] ? "<script>
	  /*<![CDATA[*/
	  $(document).ready(function () {
	  $('#captchalogin').simpleCaptcha();
    });
    /*]]>*/
    </script>" : "")."
    <form role='form' method='post' title='login' action='takelogin.php'>
		<div class='input-group'>
		    <span class='input-group-label'>
				<i class='fa fa-user'></i>
			</span>
			<input class='input-group-field' name='username'  placeholder='Username' type='text'>
		</div>
		<div class='input-group'>
			<span class='input-group-label'>
				<i class='fa fa-lock'></i>
			</span>
			<input type='password' class='input-group-field' name='password'  placeholder='Type your password' type='password'>
		</div> 
".($INSTALLER09['captcha_on'] ? "<div id='captchalogin'></div>" : "") . "";
    $HTMLOUT.= "<input name='submitme' type='submit' value='Login' class='button'>";
if (isset($returnto)) $HTMLOUT.= "<input type='hidden' name='returnto' value='" . htmlsafechars($returnto) . "'>";
$HTMLOUT.= "
<div class='clearfix'>
<a href='signup.php'><span class='float-left'>{$lang['login_signup']}</span></a>
<a href='resetpw.php'><span class='float-right'>{$lang['login_forgot']}</span></a>
</div></form>";
$HTMLOUT.="</div></div></div>";
echo stdhead("{$lang['login_login_btn']}", true) . $HTMLOUT . stdfoot($stdfoot);
?>