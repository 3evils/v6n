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
if ($INSTALLER09['report_alert'] && $CURUSER['class'] >= UC_STAFF) {
    if (($delt_with = $mc1->get_value('new_report_')) === false) {
        $res_reports = sql_query("SELECT COUNT(id) FROM reports WHERE delt_with = '0'");
        list($delt_with) = mysqli_fetch_row($res_reports);
        $mc1->cache_value('new_report_', $delt_with, $INSTALLER09['expires']['alerts']);
    }
    if ($delt_with > 0) {
        $htmlout.= "<a class='button small warning' href='staffpanel.php?tool=reports&amp;action=reports'>" . ($delt_with > 1 ? $lang['gl_reportss'] . $lang['gl_reports_news'] : $lang['gl_reports'] . $lang['gl_reports_new']) . "</a>";
    }
}
//==End
// End Class
// End File
