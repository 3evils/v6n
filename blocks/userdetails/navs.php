<?php 
$HTMLOUT.= "<ul class='tabs'>
  <li class='tabs-title'>
    <a href='userdetails.php?id={$id}&amp;action=torrents'>{$lang['userdetails_torrents']}</a>
  </li>
  <li class='tabs-title'>
    <a href='userdetails.php?id={$id}&amp;action=snatched'>{$lang['userdetails_snatched_menu']}</a>
  </li>
  <li class='tabs-title'>
    <a href='userdetails.php?id={$id}&amp;action=general'>{$lang['userdetails_general']}</a>
  </li>
  <li class='tabs-title'>
    <a href='userdetails.php?id={$id}&amp;action=activity'>{$lang['userdetails_activity']}</a>
  </li>
  <li class='tabs-title'>
    <a href='userdetails.php?id={$id}&amp;action=comments'>{$lang['userdetails_usercomments']}</a>
  </li>";
if ($CURUSER['class'] >= UC_STAFF && $user["class"] < $CURUSER['class']) {
  $HTMLOUT.= "<li class='tabs-title'>
		<a href='#' data-toggle='edit_userModal'>{$lang['userdetails_edit_user']}</a>
  </li>";
}
$HTMLOUT.= "</ul>";
