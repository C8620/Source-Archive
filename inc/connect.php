<?php
// Force show all errors
error_reporting(E_ERROR);
ini_set('display_errors', '1');

function add_premerator($key = 'login', $value = 1, $id = null)
{
	$url = "https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
	$url_parts = parse_url($url);
	// If URL doesn't have a query string.
	if (isset($url_parts['query'])) { // Avoid 'Undefined index: query'
		parse_str($url_parts['query'], $params);
	} else {
		$params = array();
	}

	$params[$key] = $value;     // Overwrite if exists

	if (isset($params['cf-turnstile-response'])) {
		unset($params['cf-turnstile-response']);
	}

	// Note that this will url_encode all values
	$url_parts['query'] = http_build_query($params);

	$url = $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'] . '?' . $url_parts['query'];

	if ($id != null) {
		$url = $url . "#" . $id;
	}
	// If not
	return $url;
}

function add_premerator_multi($paras = null, $id = null)
{
	$url = "https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
	$url_parts = parse_url($url);
	// If URL doesn't have a query string.
	if (isset($url_parts['query'])) { // Avoid 'Undefined index: query'
		parse_str($url_parts['query'], $params);
	} else {
		$params = array();
	}

	foreach ($paras as $key => $value) {
		$params[$key] = $value;     // Overwrite if exists
	}

	if (isset($params['cf-turnstile-response'])) {
		unset($params['cf-turnstile-response']);
	}

	// Note that this will url_encode all values
	$url_parts['query'] = http_build_query($params);

	$url = $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'] . '?' . $url_parts['query'];

	if ($id != null) {
		$url = $url . "#" . $id;
	}
	// If not
	return $url;
}

// Start session, configuration load.
session_start();
require_once dirname(__FILE__) . '/config.inc';
require_once dirname(__FILE__) . '/mysql.php';
$modDB = new modDB();

// Initialise i18n
require_once dirname(__FILE__) . '/i18n.php';
if (!isset($_SESSION['LANG'])) {
	// If browser wants Chinese, set language to Chinese, otherwise English
	if (strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'zh') !== false) {
		$lang = "zh";
	} else if (strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'ja') !== false) {
		$lang = "ja";
	} else if (strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'ko') !== false) {
		$lang = "kr";
	} else {
		$lang = "en";
	}
	if ($lang == 'kr') {
		$_SESSION['LANG'] = 'en';
	} else {
		$_SESSION['LANG'] = $lang;
	}
	$_SESSION['LANG_SYSTEM'] = $lang;
	$_SESSION['LANG_CONTENT'] = $lang;
}

i18n_init($_SESSION['LANG_SYSTEM']);

include dirname(__FILE__) . '/auth.php';
$Auth = new modAuth();
//if($Auth->isLoggedIn == 0){
if (isset($_SESSION['freepv']) && $_SESSION['freepv'] == 0) {
	// User not logged in, free views depleted, need login.
	include dirname(__FILE__) . '/login_prompt.php';
	die();
} else if (_WRITE_LOGS && (!isset($_SESSION['conscent']) || !$_SESSION['conscent'])) {
	include dirname(__FILE__) . '/copyright_prompt.php';
	die();
} else if ($_SESSION['freepv'] < 0) {
	if (isset($_SESSION['just_logon']) && $_SESSION['just_logon']) {
		$_SESSION['just_logon'] = false;
		// Load user profile info from Graph API
		include dirname(__FILE__) . '/graph.php';
		$Graph = new modGraph();
		$profile = $Graph->getProfile();

		if (_VOICE_GA_ENABLED) {
			$_SESSION['voice'] = true;
		} else if (_VOICE_LB_ENABLED) {
			// read whitelist, txt file seperated by lines
			$whitelist = file_get_contents(dirname(__FILE__) . '/whitelist-voice.txt');
			$whitelist = explode("\n", $whitelist);
			$whitelist = array_map('trim', $whitelist);
			// check if user is in whitelist
			if (in_array($_SESSION['userpname'], $whitelist)) {
				$_SESSION['voice'] = true;
			} else {
				$_SESSION['voice'] = false;
			}
		} else {
			$_SESSION['voice'] = false;
		}
		if ($_SESSION['voice'] && _VOICE_ONLOGON) {
			$_SESSION['voice_greetings'] = _VOICE_ONLOGON_LIST[array_rand(_VOICE_ONLOGON_LIST)];
		}
		if (_WHITELIST_ENABLED) {
			// read whitelist, txt file seperated by lines
			$whitelist = file_get_contents(dirname(__FILE__) . '/whitelist.txt');
			$whitelist = explode("\n", $whitelist);
			$whitelist = array_map('trim', $whitelist);
			// check if user is in whitelist
			if (!in_array($_SESSION['userpname'], $whitelist)) {
				// user not in whitelist, logout and prompt
				session_destroy();
				include dirname(__FILE__) . '/login_prompt.php';
				die();
			}
		}
		$whitelist = file_get_contents(dirname(__FILE__) . '/admin.txt');
		$whitelist = explode("\n", $whitelist);
		$whitelist = array_map('trim', $whitelist);
		// check if user is in whitelist
		if (in_array($_SESSION['userpname'], $whitelist)) {
			// user is in whitelist, set admin flag
			$_SESSION['admin'] = true;
		}
	}
}

date_default_timezone_set('UTC');

function anti_injection($value = null)
{
	$ai_filter_str = '#select|insert|and|or|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile#i';
	if (!isset($value)) {
		return NULL;
	} elseif (is_array($value)) {
		return array_map('anti_injection', $value);
	} elseif (preg_match($ai_filter_str, $value) == 1) {
		return 'lorem ipsum dolor sit amet';
	}
	return $value;
}

function get_categoryByPair($type, $typeID)
{
	global $modDB;

	$type = anti_injection($type);
	$typeID = anti_injection($typeID);

	$tax_data = $modDB->FindSingleAnd('category', array('categoryType' => $type, 'categoryTypeID' => $typeID));
	if ($tax_data == NULL) {
		return NULL;
	}

	$type_data = $modDB->FindSingleAnd('type', array('typeName' => $type));
	$tax_data['typeCommon_en'] = $type_data['typeCommon_en'];
	$tax_data['typeCommon_zh'] = $type_data['typeCommon_zh'];
	$tax_data['typeCommon_ja'] = $type_data['typeCommon_ja'];

	return $tax_data;
}

function get_typeInfo($type)
{
	global $modDB;

	$type = anti_injection($type);

	$type_data = $modDB->FindSingleAnd('type', array('typeName' => $type));

	if ($type_data == NULL) {
		return NULL;
	}

	return $type_data;
}

function get_typeCategories($type)
{

	global $modDB;
	$type = anti_injection($type);

	$categories_data = $modDB->FindMultipleAnd('category', array('categoryType' => $type));

	if ($categories_data == NULL) {
		return NULL;
	}

	return $categories_data;
}

function get_categoryInfo($categoryID)
{
	$categoryID = anti_injection($categoryID);

	global $modDB;

	$tax_data = $modDB->FindSingleAnd('category', array('categoryID' => $categoryID));
	if ($tax_data == NULL) {
		return NULL;
	}

	$type_data = get_typeInfo($tax_data['categoryType']);

	$tax_data['typeCommon_zh'] = $type_data['typeCommon_zh'];
	$tax_data['typeCommon_en'] = $type_data['typeCommon_en'];
	$tax_data['typeCommon_ja'] = $type_data['typeCommon_ja'];

	return $tax_data;
}

function get_categoryEntries($category)
{
	global $modDB;

	$entries_data = $modDB->FindMultipleAnd('entry', array('entryTypeName' => $category['categoryType'], 'entryTypeID' => $category['categoryTypeID']));

	if ($entries_data == NULL) {
		return NULL;
	}

	return $entries_data;
}

function get_entryInfo($entryID)
{
	global $modDB;
	$entryID = anti_injection($entryID);

	$entry_data = $modDB->FindSingleAnd('entry', array('entryID' => $entryID));

	if ($entry_data == NULL) {
		return NULL;
	}

	return $entry_data;
}

function get_ipdata($ip)
{
	global $modDB;
	$ipdata = $modDB->FindSingleAnd('ipdata', array('ip' => $ip));
	if ($ipdata == NULL) {
		return NULL;
	}
	return $ipdata['data'];
}

function set_ipdata($ip, $data)
{
	global $modDB;
	$ipdata = $modDB->FindSingleAnd('ipdata', array('ip' => $ip));
	if ($ipdata == NULL) {
		$modDB->Insert('ipdata', array('ip' => $ip, 'data' => $data));
	} else {
		$modDB->Update('ipdata', array('data' => $data), array('ip' => $ip));
	}
}

function audioPath($tag)
{
	$salt = strval(crc32($tag));
	return md5(md5($salt . $tag) . $salt);
}

function audioKey($id, $ts)
{
	// TKT = hash_hmac('sha256', ID + IP + TS, SECRET)
	$ip = $_SERVER['REMOTE_ADDR'];
	$tkt = hash_hmac('sha256', $id . $ip . $ts, _VOICE_ACCESS_SECRET);
	return $tkt;
}

function voiceTGS($tag, $errr = true)
{
	$id = audioPath($tag);
	$ts = time();
	$key = audioKey($id, $ts);
	$err_str = $errr ? 'true' : 'false';
	return "'" . $id . "','" . $ts . "','" . $key . "'," . $err_str . "";
}