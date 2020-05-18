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
 //==Start activeusers - pdq
$keys['activeusers'] = 'activeusers';
if (($active_users_cache = $mc1->get_value($keys['activeusers'])) === false) {
    $dt = $_SERVER['REQUEST_TIME'] - 180;
    $activeusers = '';
    $active_users_cache = array();
    $res = sql_query('SELECT id, username, class, avatar, donor, title, warned, enabled, chatpost, leechwarn, pirate, king, perms ' . 'FROM users WHERE last_access >= ' . $dt . ' ' . 'AND perms < ' . bt_options::PERMS_STEALTH . ' ORDER BY username ASC') or sqlerr(__FILE__, __LINE__);
    $actcount = mysqli_num_rows($res);
    $v = ($actcount != 1 ? 's' : '');
    while ($arr = mysqli_fetch_assoc($res)) {
        if ($activeusers) $activeusers.= "<br> ";
        $activeusers.= '<b>' . avatar_stuff($arr, 20) . format_username($arr) . '</b>';
    }
    $active_users_cache['activeusers'] = $activeusers;
    $active_users_cache['actcount'] = $actcount;
    $active_users_cache['au'] = number_format($actcount);
    $last24_cache['v'] = $v;
    $mc1->cache_value($keys['activeusers'], $active_users_cache, $INSTALLER09['expires']['activeusers']);
}
if (!$active_users_cache['activeusers']) $active_users_cache['activeusers'] = $lang['index_active_users_no'];
// ===End Active users
// ===Start Irc
$nick = ($CURUSER ? $CURUSER['username'] : '');
$irc_url = 'irc.uk.mibbit.net';
$irc_channel = '#U232_Dev';
$irc_network = 'U232_Dev';
// === shoutbox 09
$commandbutton = $refreshbutton = $smilebutton = $custombutton = $staffsmiliebutton = $shistorybutton = '';
if ($CURUSER['class'] >= UC_STAFF) {
	$staffsmiliebutton.= "<a href=\"javascript:PopStaffSmiles('shbox','shbox_text')\">{$lang['index_shoutbox_ssmilies']}</a>";
}
if (get_smile() != 1) 
	$custombutton.= "<a href=\"javascript:PopCustomSmiles('shbox','shbox_text')\">{$lang['index_shoutbox_csmilies']}</a>";
if ($CURUSER['class'] >= UC_STAFF) {
	$commandbutton = "<a href=\"javascript:popUp('shoutbox_commands.php')\">{$lang['index_shoutbox_commands']}</a>\n";
}
if ($CURUSER['class'] >= UC_STAFF) {
    $shistorybutton = "<a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=shistory'>[{$lang['index_shoutbox_history']}]</a>";
}
$refreshbutton = "<a class='dropdown-item' href='/shoutbox.php' target='shoutbox'>{$lang['index_shoutbox_refresh']}</a>\n";
$smilebutton = "<a class='dropdown-item' href=\"javascript:PopMoreSmiles('shbox','shbox_text')\">{$lang['index_shoutbox_smilies']}</a>\n";
$HTMLOUT .= "<div class='callout'><h4 class='subheader'>{$lang['index_shoutbox_general']}</h4>
<ul class='tabs' data-active-collapse='true' data-tabs id='collapsing-tabs'>
  <li class='tabs-title is-active'><a href='#panel1c' aria-selected='true'>Chat</a></li>
  <li class='tabs-title'><a href='#panel2c'>Online&nbsp;&nbsp;<span class='badge success'>{$active_users_cache['actcount']}</span></a></li>
  <li class='tabs-title'><a href='#panel3c'>Commands</a></li>
  <li class='tabs-title'><a href='#panel4c'>IRC</a></li>
</ul>

<div class='tabs-content' data-tabs-content='collapsing-tabs'>
  <div class='tabs-panel is-active' id='panel1c'>
<form action='shoutbox.php' method='get' target='shoutbox' name='shbox' onsubmit='mysubmit()'>
<div style='display:flex;'><iframe src='{$INSTALLER09['baseurl']}/shoutbox.php' class='shout-table' name='shoutbox'></iframe><div style='width:150px;border-color:black;flex-direction:column;border:1px;'>{$active_users_cache['activeusers']}</div></div>
<div  class='input-group'>
  <input class='input-group-field' type='text' name='shbox_text' aria-label='Shout Text'>
  <div class='input-group-button'>
<input class='button' type='submit' value='{$lang['index_shoutbox_send']}' />
<input type='hidden' name='sent' value='yes' />
  </div>
</div>
<a href=\"javascript:SmileIT(':-)','shbox','shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/smile1.gif' alt='Smile' title='Smile' /></a>
<a href=\"javascript:SmileIT(':smile:','shbox','shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/smile2.gif' alt='Smiling' title='Smiling' /></a>
<a href=\"javascript:SmileIT(':-D','shbox','shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/grin.gif' alt='Grin' title='Grin' /></a>
<a href=\"javascript:SmileIT(':lol:','shbox','shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/laugh.gif' alt='Laughing' title='Laughing' /></a>
<a href=\"javascript:SmileIT(':w00t:','shbox','shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/w00t.gif' alt='W00t' title='W00t' /></a>
<a href=\"javascript:SmileIT(':blum:','shbox','shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/blum.gif' alt='Rasp' title='Rasp' /></a>
<a href=\"javascript:SmileIT(';-)','shbox','shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/wink.gif' alt='Wink' title='Wink' /></a>
<a href=\"javascript:SmileIT(':devil:','shbox','shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/devil.gif' alt='Devil' title='Devil' /></a>
<a href=\"javascript:SmileIT(':yawn:','shbox','shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/yawn.gif' alt='Yawn' title='Yawn' /></a>
<a href=\"javascript:SmileIT(':-/','shbox','shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/confused.gif' alt='Confused' title='Confused' /></a>
<a href=\"javascript:SmileIT(':o)','shbox','shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/clown.gif' alt='Clown' title='Clown' /></a>
<a href=\"javascript:SmileIT(':innocent:','shbox','shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/innocent.gif' alt='Innocent' title='innocent' /></a>
<a href=\"javascript:SmileIT(':whistle:','shbox','shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/whistle.gif' alt='Whistle' title='Whistle' /></a>
<a href=\"javascript:SmileIT(':unsure:','shbox','shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/unsure.gif' alt='Unsure' title='Unsure' /></a>
<a href=\"javascript:SmileIT(':blush:','shbox','shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/blush.gif' alt='Blush' title='Blush' /></a>
<a href=\"javascript:SmileIT(':hmm:','shbox','shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/hmm.gif' alt='Hmm' title='Hmm' /></a>
<a href=\"javascript:SmileIT(':hmmm:','shbox','shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/hmmm.gif' alt='Hmmm' title='Hmmm' /></a>
<a href=\"javascript:SmileIT(':huh:','shbox','shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/huh.gif' alt='Huh' title='Huh' /></a>
<a href=\"javascript:SmileIT(':look:','shbox','shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/look.gif' alt='Look' title='Look' /></a>
<a href=\"javascript:SmileIT(':rolleyes:','shbox','shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/rolleyes.gif' alt='Roll Eyes' title='Roll Eyes' /></a>
<a href=\"javascript:SmileIT(':kiss:','shbox','shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/kiss.gif' alt='Kiss' title='Kiss' /></a>
<a href=\"javascript:SmileIT(':blink:','shbox','shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/blink.gif' alt='Blink' title='Blink' /></a>
<a href=\"javascript:SmileIT(':baby:','shbox','shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/baby.gif' alt='Baby' title='Baby' /></a>
</form>
  </div>
  <div class='tabs-panel' id='panel2c'>
<p>{$active_users_cache['activeusers']}</p>
  </div>
  <div style=''>
   		{$commandbutton}
		{$staffsmiliebutton}
		{$smilebutton}
		{$custombutton}
		{$refreshbutton}
		{$shistorybutton}
  </div>
  <div class='tabs-panel' id='panel4c'>
  <p>{$lang['chat_channel']}<a href='irc://{$irc_url}/{$irc_channel}'>{$irc_channel}</a> {$lang['chat_on']} {$irc_network} {$lang['chat_network']}</p>
   <iframe src='https://kiwiirc.com/client/{$irc_url}/?nick={$nick}&theme=cli{$irc_channel}' style='border:0; width:100%; height:450px;'></iframe>
  </div>
</div>";
$HTMLOUT .= "</div>";
//==end 09 shoutbox
//==End
// End Class
// End File
