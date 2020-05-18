<?php
// == Query update by Putyn
$res_achiev = sql_query("SELECT a1.*, (SELECT COUNT(a2.id) FROM achievements AS a2 WHERE a2.achievement = a1.achievname) as count FROM achievementist AS a1 ORDER BY a1.id ") or sqlerr(__FILE__, __LINE__);
$HTMLOUT = '';
if (mysqli_num_rows($res_achiev) == 0) {
    $HTMLOUT.= "<p align='center'><b>{$lang['achlst_there_no_ach_msg']}!<br />{$lang['achlst_staff_been_lazy']}!</b></p>\n";
} else {
	    $HTMLOUT.= "<div class='col-md-8'>
	<table class='table table-bordered'>";
    $HTMLOUT.= "<thead>
		<tr>
			<th scope='col'>{$lang['achlst_achievname']}</th>
			<th scope='col'>{$lang['achlst_description']}</th>
			<th scope='col'>{$lang['achlst_earned']}</th>
		</tr>
	</thead>";
    while ($arr_achiev = mysqli_fetch_assoc($res_achiev)) {
        $notes = htmlsafechars($arr_achiev["notes"]);
        $clienticon = '';
        if ($arr_achiev["clienticon"] != "") {
            $clienticon = "<img src='" . $INSTALLER09['pic_base_url'] . "achievements/" . htmlsafechars($arr_achiev["clienticon"]) . "' title='" . htmlsafechars($arr_achiev['achievname']) . "' alt='" . htmlsafechars($arr_achiev['achievname']) . "' />";
        }
        $HTMLOUT.= "<tbody>
			<tr>
				<th scope='row'>$clienticon</th>
				<td>$notes</td>
				<td>" . htmlsafechars($arr_achiev['count']) . "</td>
			</tr>
		</tbody>";
    }
	$HTMLOUT.="</table></div>";
}