<?php
if ($CURUSER["id"] != $user["id"]) if ($CURUSER['class'] >= UC_STAFF) $showpmbtn = 1;
elseif ($user["acceptpms"] == "yes") {
    $r = sql_query("SELECT id FROM blocks WHERE userid=" . sqlesc($user['id']) . " AND blockid=" . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
    $showpmbtn = (mysqli_num_rows($r) == 1 ? 0 : 1);
} elseif ($user["acceptpms"] == "friends") {
    $r = sql_query("SELECT id FROM friends WHERE userid=" . sqlesc($user['id']) . " AND friendid=" . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
    $showpmbtn = (mysqli_num_rows($r) == 1 ? 1 : 0);
}
$HTMLOUT.= "<div class='card text-white bg-warning mb-3' style='max-width: 18rem;'>";
$HTMLOUT.= "<tr><td>{$lang['userdetails_anonymous']}</td></tr>";
if ($user["avatar"])
	$HTMLOUT.= "<tr><td><img src='" . htmlsafechars($user["avatar"]) . "'></td></tr>\n";
if ($user["info"]) 
	$HTMLOUT.= "<div class='card-body'>'" . format_comment($user["info"]) . "'</div>";
if (isset($showpmbtn)) 
	$HTMLOUT.= "<tr>
      <td colspan='2' align='center'>
      <form method='get' action='pm_system.php?'>
        <input type='hidden' name='action' value='send_message' />
        <input type='hidden' name='receiver' value='" . (int)$user["id"] . "' />
        <input type='hidden' name='returnto' value='" . urlencode($_SERVER['REQUEST_URI']) . "' />
        <input type='submit' value='{$lang['userdetails_msg_btn']}' class='btn' />
      </form>
      </td></tr>";
    $HTMLOUT.= "<form method='get' action='{$INSTALLER09['baseurl']}/pm_system.php?action=send_message'>
		<input type='hidden' name='receiver' value='" . (int)$user["id"] . "'>
		<input type='submit'class='btn btn-sm' value='{$lang['userdetails_sendmess']}' style='height: 23px'></form>";
    if ($CURUSER['class'] < UC_STAFF && $user["id"] != $CURUSER["id"]) {
        echo stdhead($lang['userdetails_anonymoususer']) . $HTMLOUT . stdfoot();
        die;
    }
    $HTMLOUT.= "</td></tr></div>";

  <div class='card-header'>Header</div>
  <div class='card-body'>
    <h5 class='card-title'>Warning card title</h5>
    <p class='card-text'>Some quick example text to build on the card title and make up the bulk of the card's content.</p>
  </div>
