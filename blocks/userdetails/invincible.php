<?php
//==invincible no iplogging and ban bypass by pdq
$invincible = $mc1->get_value('display_' . $CURUSER['id']);
if ($invincible) $HTMLOUT.= '<div class="col-sm-2 col-md-push-2"><h3>' . htmlsafechars($user['username']) . ' '.$lang['userdetails_is'].' ' . $invincible . ' '.$lang['userdetails_invincible'].'</h3></div>';

//== links to make invincible method 1(PERMS_NO_IP/ no log ip) and 2(PERMS_BYPASS_BAN/cannot be banned)
$HTMLOUT.= "<div class='grid-container'>
<div class='row'>
<div class='col-md-5'>".($CURUSER['class'] === UC_MAX ? (($user['perms'] & bt_options::PERMS_NO_IP) ? ' [<a title=' . "\n" . '"'.$lang['userdetails_invincible_def1'].' ' . "\n" . ''.$lang['userdetails_invincible_def2'].'" href="userdetails.php?id=' . $id . '&amp;invincible=no">' . "\n" . ''.$lang['userdetails_invincible_remove'].'</a>]' . (($user['perms'] & bt_options::PERMS_BYPASS_BAN) ? ' - ' . "\n" . ' [<a title="'.$lang['userdetails_invincible_def3'].'' . "\n" . ' '.$lang['userdetails_invincible_def4'].'" href="userdetails.php?id=' . $id . '&amp;' . "\n" . 'invincible=remove_bypass">'.$lang['userdetails_remove_bypass'].'</a>]' : ' - [<a title="'.$lang['userdetails_invincible_def5'].' ' . "\n" . $lang['userdetails_invincible_def6'] . "\n" . ' '.$lang['userdetails_invincible_def7'].' ' . "\n" . ''.$lang['userdetails_invincible_def8'].'" href="userdetails.php?id=' . $id . '&amp;invincible=yes">' . "\n" . ''.$lang['userdetails_add_bypass'].'</a>]') : '[<a title="'.$lang['userdetails_invincible_def9'].'' . "
               \n" . ' '.$lang['userdetails_invincible_def0'].'" ' . "\n" . 'href="userdetails.php?id=' . $id . '&amp;invincible=yes">'.$lang['userdetails_make_invincible'].'</a>]') : '') ."</div></div>";

//==Stealth mode
$stealth = $mc1->get_value('display_stealth' . $CURUSER['id']);
if ($stealth) $HTMLOUT.= '<div class="row"><div class="col-md-6 col-md-pull-0"><h4>' . htmlsafechars($user['username']) . '&nbsp;' . $stealth . ' '.$lang['userdetails_in_stelth'].'</h4>';
$HTMLOUT.= "".($CURUSER['class'] >= UC_STAFF ? (($user['perms'] & bt_options::PERMS_STEALTH) ? '[<a title=' . "" . '"'.$lang['userdetails_stelth_def1'].' ' . "" . ' '.$lang['userdetails_stelth_def2'].'" href="userdetails.php?id=' . $id . '&amp;stealth=no">' . "" . ''.$lang['userdetails_stelth_disable'].'</a>]' : '[<a title="'.$lang['userdetails_stelth_def1'].'' . "
               " . ' '.$lang['userdetails_stelth_def2'].'" ' . "" . 'href="userdetails.php?id=' . $id . '&amp;stealth=yes">'.$lang['userdetails_stelth_enable'].'</a>]') : '')."</div></div></div>";