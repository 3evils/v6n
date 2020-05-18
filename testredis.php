<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once INCL_DIR . 'user_functions.php';
require_once INCL_DIR . 'bbcode_functions.php';
require_once INCL_DIR . 'html_functions.php';
require_once ROOT_DIR . 'polls.php';
require_once (CLASS_DIR . 'class_user_options.php');
require_once (CLASS_DIR . 'class_user_options_2.php');
dbconn(true);
loggedinorreturn();
require_once(TEMPLATE_DIR.''.$CURUSER['stylesheet'].'' . DIRECTORY_SEPARATOR . 'html_functions' . DIRECTORY_SEPARATOR . 'global_html_functions.php'); 
require_once(TEMPLATE_DIR.''.$CURUSER['stylesheet'].'' . DIRECTORY_SEPARATOR . 'html_functions' . DIRECTORY_SEPARATOR . 'navigation_html_functions.php'); 
require_once (CLASS_DIR . 'class_cache_redis.php');
// set server
RedisCache::setRedisServer('redis');

// create two store groups
$r1 = new RedisCache('test');
$r2 = new RedisCache('test1');


$stdhead = array(
    /** include css **/
    'css' => array(
        'bbcode'
    )
);
$stdfoot = array(
    /** include js **/
    'js' => array(
	/*'gallery',*/
    'shout'
    )
);

$lang = array_merge(load_language('global') , load_language('index'));

if (($stats_cache = $r2->keyExists('site_stats_')) === false) {

    $stats_cache = mysqli_fetch_assoc(sql_query("SELECT *, seeders + leechers AS peers, seeders / leechers AS ratio, unconnectables / (seeders + leechers) AS ratiounconn FROM stats WHERE id = '1' LIMIT 1"));

    $stats_cache['seeders'] = (int)$stats_cache['seeders'];
    $stats_cache['leechers'] = (int)$stats_cache['leechers'];
    $stats_cache['regusers'] = (int)$stats_cache['regusers'];
    $stats_cache['unconusers'] = (int)$stats_cache['unconusers'];
    $stats_cache['torrents'] = (int)$stats_cache['torrents'];
    $stats_cache['torrentstoday'] = (int)$stats_cache['torrentstoday'];
    $stats_cache['ratiounconn'] = (int)$stats_cache['ratiounconn'];
    $stats_cache['unconnectables'] = (int)$stats_cache['unconnectables'];
    $stats_cache['ratio'] = (int)$stats_cache['ratio'];
    $stats_cache['peers'] = (int)$stats_cache['peers'];
    $stats_cache['numactive'] = (int)$stats_cache['numactive'];
    $stats_cache['donors'] = (int)$stats_cache['donors'];
    $stats_cache['forumposts'] = (int)$stats_cache['forumposts'];
    $stats_cache['forumtopics'] = (int)$stats_cache['forumtopics'];
    $stats_cache['torrentsmonth'] = (int)$stats_cache['torrentsmonth'];
    $stats_cache['gender_na'] = (int)$stats_cache['gender_na'];
    $stats_cache['gender_male'] = (int)$stats_cache['gender_male'];
    $stats_cache['gender_female'] = (int)$stats_cache['gender_female'];
    $stats_cache['powerusers'] = (int)$stats_cache['powerusers'];
    $stats_cache['disabled'] = (int)$stats_cache['disabled'];
    $stats_cache['uploaders'] = (int)$stats_cache['uploaders'];
    $stats_cache['moderators'] = (int)$stats_cache['moderators'];
    $stats_cache['administrators'] = (int)$stats_cache['administrators'];
    $stats_cache['sysops'] = (int)$stats_cache['sysops'];
    $r1->arraySet('site_stats_', $stats_cache, $INSTALLER09['expires']['site_stats']);
}
//==End
//==Installer 09 stats
$HTMLOUT ='';
$HTMLOUT.= "
<div class='card'>
        <div class='card-header'>
                <label for='checkbox_4' class='text-left'>{$lang['index_stats_title']}</label>
        </div>
        <div class='card-body'>
                <div class='row'>
                        <div class='col-lg-3'>
                                <ul class='list-group'>
                                        <li class='list-group-item btn btn-default '><b>{$lang['index_stats_uinfo']}</b></li>
                                        <li class='list-group-item'>{$lang['index_stats_regged']}<span class='badge'>{$stats_cache['regusers']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_max']}<span class='badge'>{$INSTALLER09['maxusers']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_online']}<span class='badge'>{$stats_cache['numactive']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_uncon']}<span class='badge'>{$stats_cache['unconusers']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_gender_na']}<span class='badge'>{$stats_cache['gender_na']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_gender_male']}<span class='badge'>{$stats_cache['gender_male']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_gender_female']}<span class='badge'>{$stats_cache['gender_female']}</span></li>
                                </ul>
                        </div>
                        <div class='col-lg-3'>
                                <ul class='list-group'>
                                        <li class='list-group-item btn btn-default'><b>{$lang['index_stats_cinfo']}</b></li>                                                                    
                                        <li class='list-group-item'>{$lang['index_stats_powerusers']}<span class='badge'>{$stats_cache['powerusers']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_banned']}<span class='badge'>{$stats_cache['disabled']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_uploaders']}<span class='badge'>{$stats_cache['uploaders']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_moderators']}<span class='badge'>{$stats_cache['moderators']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_admin']}<span class='badge'>{$stats_cache['administrators']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_sysops']}<span class='badge'>{$stats_cache['sysops']}</span></li>
                                </ul>
                        </div>
                        <div class='col-lg-3'>
                                <ul class='list-group'>
                                        <li class='list-group-item btn btn-default'><b>{$lang['index_stats_finfo']}</b></li>                                                                    
                                        <li class='list-group-item'>{$lang['index_stats_topics']}<span class='badge'>{$stats_cache['forumtopics']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_posts']}<span class='badge'>{$stats_cache['forumposts']}</span></li>
                                </ul>
                        </div>
                        <div class='col-lg-3'>
                                <ul class='list-group'>
                                        <li class='list-group-item btn btn-default'><b>{$lang['index_stats_tinfo']}</b></li>                                                                                                                                            <li class='list-group-item'>{$lang['index_stats_torrents']}<span class='badge'>{$stats_cache['torrents']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_newtor']}<span class='badge'>{$stats_cache['torrentstoday']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_peers']}<span class='badge'>{$stats_cache['peers']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_unconpeer']}<span class='badge'>{$stats_cache['unconnectables']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_seeders']}<span class='badge'>{$stats_cache['seeders']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_unconratio']}<span class='badge'>" . round($stats_cache['ratiounconn'] * 100) . "</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_leechers']}<span class='badge'>{$stats_cache['leechers']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_slratio']}<span class='badge'>" . round($stats_cache['ratio'] * 100) . "</span></li>
                                </ul>
                        </div>
                </div>
        </div>
</div>";
echo stdhead('testredis', true, $stdhead) . $HTMLOUT . stdfoot($stdfoot);
?>