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
//-------- Begins a main frame
function begin_main_frame()
{
    return "<table class='table' width='750' border='0' cellspacing='0' cellpadding='0'>" . "<tr><td class='embedded'>\n";
}
//-------- Ends a main frame
function end_main_frame()
{
    return "</td></tr></table>\n";
}
function begin_frame($caption = "", $center = false, $padding = 10)
{
    $tdextra = "";
    $htmlout = '';
    if ($caption)
        $htmlout .= "<h2>$caption</h2>\n";
    if ($center)
        $tdextra .= " align='center'";
    $htmlout .= "<table class='table'><tr><td$tdextra>\n";
    return $htmlout;
}
function attach_frame($padding = 10)
{
    $htmlout = '';
    $htmlout .="</td></tr><tr><td style='border-top: 0px'>\n";
    return $htmlout;
}
function end_frame()
{
    return "</td></tr></table>\n";
}
function begin_table($fullwidth = false, $padding = 5)
{
    $width   = "";
    $htmlout = '';
    if ($fullwidth)
        $width .= " width='100%'";
    $htmlout .= "<table class='table table-bordered'>";
    return $htmlout;
}
function end_table()
{
    return "</table>";
}
function tr($x, $y, $noesc = 0)
{
    if ($noesc)
        $a = $y;
    else {
        $a = htmlsafechars($y);
        $a = str_replace("\n", "<br />\n", $a);
    }
    return "<tr>
				<td>$x</td>
				<td>$a</td>
			</tr>";
}
//-------- Inserts a smilies frame
function insert_smilies_frame()
{
    global $smilies, $INSTALLER09;
    $htmlout = '';
    $htmlout .= begin_frame("Smilies", true);
    $htmlout .= begin_table(false, 5);
    $htmlout .= "<tr><td>Type...</td><td>To make a...</td></tr>\n";
    foreach ($smilies as $code => $url) {
        $htmlout .= "<tr><td>$code</td><td><img src=\"{$INSTALLER09['pic_base_url']}smilies/{$url}\" alt='' /></td></tr>\n";
    }
    $htmlout .= end_table();
    $htmlout .= end_frame();
    return $htmlout;
}
?>
