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
//==Staff tools quick link - Stoner
 if ($CURUSER['class'] >= UC_STAFF)
 {
 if (($mysql_data = $mc1->get_value('is_staff_' . $CURUSER['class'])) === false) {
 $res = sql_query('SELECT * FROM staffpanel WHERE av_class <= ' . sqlesc($CURUSER['class']) . ' ORDER BY page_name ASC') or sqlerr(__FILE__, __LINE__);
  while ($arr = mysqli_fetch_assoc($res)) $mysql_data[] = $arr;
 $mc1->cache_value('is_staff_' . $CURUSER['class'], $mysql_data, $INSTALLER09['expires']['staff_check']);
  }
  if ($mysql_data) { 
  $htmlout .= '<div class="small button-group float-right">
     <button type="button" class="button" data-toggle="user-dropdown">User</button>
 <button type="button" class="button" data-toggle="settings-dropdown">Settings</button>
  <button type="button" class="button" data-toggle="stats-dropdown">Stats</button>
  <button type="button" class="button" data-toggle="other-dropdown">Other</button>
  </div>';
  $htmlout .= '<div data-position="bottom" data-alignment="right" class="dropdown-pane" id="user-dropdown" data-dropdown data-auto-focus="true"><ul class="submenu menu vertical">';
 foreach ($mysql_data as $key => $value){
  if ($value['av_class'] <= $CURUSER['class'] && $value['type'] == 'user') {
  $htmlout .= '<li><a href="'.htmlsafechars($value["file_name"]).'">'.htmlsafechars($value["page_name"]).'</a></li>';
  }
  }
  $htmlout .= '</ul></div>';
  $htmlout .= '<div class="dropdown-pane" data-position="bottom" data-alignment="right" id="settings-dropdown" data-dropdown data-auto-focus="true">
  <ul class="submenu menu vertical">';           
  foreach ($mysql_data as $key => $value){
  if ($value['av_class'] <= $CURUSER['class'] && $value['type'] == 'settings') {
  $htmlout .= '<li><a href="'.htmlsafechars($value["file_name"]).'">'.htmlsafechars($value["page_name"]).'</a></li>';
  }
  }
  $htmlout .= '</ul></div>';
  $htmlout .= '<div class="dropdown-pane" data-position="bottom" data-alignment="right" id="stats-dropdown" data-dropdown data-auto-focus="true">
  <ul class="submenu menu vertical">';           
  foreach ($mysql_data as $key => $value){
  if ((int)$value['av_class'] <= $CURUSER['class'] && htmlsafechars($value['type']) == 'stats') {
  $htmlout .= '<li><a href="'.htmlsafechars($value["file_name"]).'">'.htmlsafechars($value["page_name"]).'</a></li>';
  }
  }
  $htmlout .= '</ul></div>';
  $htmlout .= '<div class="dropdown-pane" data-position="bottom" data-alignment="right" id="other-dropdown" data-dropdown data-auto-focus="true">
  <ul class="submenu menu vertical">';
  foreach ($mysql_data as $key => $value){
  if ((int)$value['av_class'] <= $CURUSER['class'] && htmlsafechars($value['type']) == 'other') {
  $htmlout .= '<li><a href="'.htmlsafechars($value["file_name"]).'">'.htmlsafechars($value["page_name"]).'</a></li>';
  }
  }
  $htmlout .= '</ul></div>';
  }
  }
//== End
// End Class
// End File
