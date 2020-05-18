<?php
// ===donor count down
if ($user["donor"] && $CURUSER["id"] == $user["id"] || $CURUSER["class"] == UC_SYSOP) {
    $donoruntil = htmlsafechars($user['donoruntil']);
    if ($donoruntil == '0') $HTMLOUT.= "";
    else {
        $HTMLOUT.= "<b>{$lang['userdetails_donatedtill']} - " . get_date($user['donoruntil'], 'DATE') . "";
        //$HTMLOUT.= " [ " . mkprettytime($donoruntil - TIME_NOW) . " ] {$lang['userdetails_togo']}...</b>{$lang['userdetails_renew']}<a class='altlink' href='{$INSTALLER09['baseurl']}/donate.php'>{$lang['userdetails_here']}</a>";
    }
}