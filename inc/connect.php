<?php
    function add_premerator($key = 'login', $value = NULL) {
		$url = "https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
		$url_parts = parse_url($url);
		// If URL doesn't have a query string.
		if (isset($url_parts['query'])) { // Avoid 'Undefined index: query'
    		parse_str($url_parts['query'], $params);
		} else {
    		$params = array();
		}

		$params[$key] = $value;     // Overwrite if exists

		// Note that this will url_encode all values
		$url_parts['query'] = http_build_query($params);

		// If not
		return $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'] . '?' . $url_parts['query'];
	}

	include dirname(__FILE__) . '/auth.php';
	$Auth = new modAuth();
	//if($Auth->isLoggedIn == 0){
	if(isset($_SESSION['freepv'])&&$_SESSION['freepv']==0){
	  include dirname(__FILE__) . '/login_prompt.php';
	  die();
	}else if($_SESSION['freepv']<0){
		include dirname(__FILE__) . '/graph.php';
		$Graph = new modGraph();
		$profile = $Graph->getProfile();
		$_SESSION['playername'] = $profile->displayName;
		$_SESSION['userpname'] = $Auth->userName;
	}
	//Display the username, logout link and a list of attributes returned by Azure AD.
	//echo var_dump($playername);

	date_default_timezone_set('UTC');
	
	$servername = "localhost";
	$username = "u135329933_gcgsrc";
	$password = "8I4~Vy/v9B";
	$dbname = "u135329933_gcgsrc";
	
	$conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection establishment.
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

	function anti_injection($value=null) {
    	$ai_filter_str = '#select|insert|and|or|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile#i';
    	if(!isset($value)) {
        	return NULL;
		}elseif(preg_match($ai_filter_str, $value)==1) {
        	return 'lorem ipsum dolor sit amet';
    	}
    	return $value;
	}

	function uni_encode($value = null) { 
		return str_replace(array("&#92;&#110;&#92;&#114;", "&#92;&#114;&#92;&#110;", "&#92;&#110;", "&#92;&#114;"), "<br />", mb_encode_numericentity (str_replace("playername", $_SESSION['playername'], $value), array (0x0, 0xffff, 0, 0xffff), 'UTF-8'));
	}
	
?>