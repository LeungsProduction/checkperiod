<?php
function db() {
	global $db;
	if (!$db) {
		/*require_once dirname(__FILE__) . '/vendors/php-pdo-wrapper-class/class.db.php';
		try {
			$db = new db('mysql:host=' . DATABASE_HOST . ';dbname=' . DATABASE_NAME, DATABASE_USERNAME, DATABASE_PASSWORD);
			$db->query('set names "utf8"');
		} catch (Exception $e) {
			die($e->getMessage());
		}*/


        require_once dirname(__FILE__) . "/vendors/Medoo.php";
        $db = new Medoo\Medoo([
            'database_type' => 'mysql',
            'database_name' => DATABASE_NAME,
            'server' => DATABASE_HOST,
            'username' => DATABASE_USERNAME,
            'password' => DATABASE_PASSWORD,
            'charset' => 'utf8'
        ]);
	}
	return $db;
}

function isPost() {
	return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
}

function getPost($name, $defaultValue = null, $isTrim = true) {
	if (isset($_POST[$name])) {
		if (is_string($_POST[$name])) {
			return $isTrim ? trim($_POST[$name]) : $_POST[$name];
		}
		return $_POST[$name];
	}
	return $defaultValue;
}

function startState() {
	@session_start();
}

// http://www.php.net/session_destroy
function destroyState() {
	$_SESSION = array();
	if (ini_get('session.use_cookies')) {
		$params = session_get_cookie_params();
		// avoid double Set-Cookie header
		header_remove('Set-Cookie');
		setcookie(session_name(), '', time() - 42000,
				$params['path'], $params['domain'],
				$params['secure'], $params['httponly']
		);
	}
	session_destroy();
}

function hasState($key) {
	return isset($_SESSION[$key]);
}

function getState($key, $defaultValue = null) {
	return isset($_SESSION[$key]) ? $_SESSION[$key] : $defaultValue;
}

function setState($key, $value, $defaultValue = null) {
	if ($value === $defaultValue) {
		unset($_SESSION[$key]);
	} else {
		$_SESSION[$key] = $value;
	}
}

function setSiteCookie($key, $value, $defaultValue = null) {
	if ($value === $defaultValue) {
		unset($_COOKIE[$key]);
        setcookie($key, "", time()-3600, '/');
    } else {
        setcookie($key, $value, time()+36000, '/'); // 10 hours
	}
}

function getSiteCookie($key, $defaultValue = null) {
    return isset($_COOKIE[$key]) ? $_COOKIE[$key] : $defaultValue;
}

function createUrl($route, $params = array()) {
	$url = BASE_URL . '/' . $route;
	if ($route == 'index') {
		$url = BASE_URL . '/';
	}
	$query = '';
	if (!empty($params)) {
		$query = '?' . http_build_query($params);
	}
	return $url . $query;
}

function redirect($url, $exit = true) {
	header('Location: ' . $url);
	$exit && exit;
}

function errorData($name, $message) {
	global $language;
	return array(
			'success' => false,
			'error'   => array(
					$name => __($message, $language),
			),
	);
}

function array_to_csv($array, $header_row = true, $col_sep = ",", $row_sep = "\n", $qut = '"') {
	if (empty($array) || !is_array($array)) return false;

	$output = '';
	//Header row.
	if ($header_row) {
		foreach ($array[0] as $key => $val) {
			//Escaping quotes.
			$key = str_replace($qut, "$qut$qut", $key);
			$output .= "$col_sep$qut$key$qut";
		}
		$output = substr($output, 1) . "\n";
	}
	//Data rows.
	foreach ($array as $key => $val) {
		$tmp = '';
		foreach ($val as $cell_key => $cell_val) {
			//Escaping quotes.

            if($cell_key === '年齡'){
                $tmp .= "$col_sep$cell_val";
            } else {
                $cell_val = str_replace($qut, "$qut$qut", $cell_val);
                $tmp .= "$col_sep$qut$cell_val$qut";
            }

		}
		$output .= substr($tmp, 1) . $row_sep;
	}

	return $output;
}

function generateRandomString() {
	$crypto_strong = true;
	return sha1(base64_encode(openssl_random_pseudo_bytes(32, $crypto_strong)));
}

function h($text) {
	return htmlspecialchars($text, ENT_QUOTES);
}

startState();
$timeout = getState('timeout');
if ($timeout !== null && $timeout + 24 * 60 * 60 < time()) {
	// session timed out
	$path = str_replace($_SERVER['DOCUMENT_ROOT'], '', dirname($_SERVER['SCRIPT_FILENAME']));
	$baseUrl = rtrim($path,'/') . '/index.php';
	destroyState();
	redirect($baseUrl);
}
setState('timeout', time());

function isSecure() {
	return !empty($_SERVER['HTTPS']) && strcasecmp($_SERVER['HTTPS'], 'off');
}

function getUserAgent()
{
    return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
}

function getReferer()
{
    return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
}

function isMobile()
{
    $ua = getUserAgent();
    if(!!preg_match('/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', $ua)){
        return 1;
    } else {
        return 0;
    }
}

function isBirthdayValid($month, $date, $year) {
	if (checkdate($month, $date, $year)) {
		return true;
	}
	return false;
}
function isSecureConnection() {
	return isset($_SERVER['HTTPS']) && (strcasecmp($_SERVER['HTTPS'], 'on') === 0 || $_SERVER['HTTPS'] == 1)
	|| isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') === 0;
}

function logFile($var, $destination = 'app_error.log') {
	if (!is_string($var)) {
		$var = json_encode($var);
	}
	$debug = debug_backtrace();
	$file = $debug[0]['file'];
	$line = $debug[0]['line'];
	$message = date('Y-m-d H:i:s') . ': ' . $file . ' on line ' . $line . ' | ' . $var . "\r\n";

	$logFile = dirname(__FILE__) . '/log/' . $destination;
	if (!is_file($logFile)) {
		touch($logFile);
	}
	return file_put_contents($logFile, $message, FILE_APPEND | LOCK_EX);
}

// https://gist.github.com/cballou/2201933
function remoteAddress() {
	$ip_keys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
	foreach ($ip_keys as $key) {
		if (array_key_exists($key, $_SERVER) === true) {
			foreach (explode(',', $_SERVER[$key]) as $ip) {
				// trim for safety measures
				$ip = trim($ip);
				// attempt to validate IP
				if (validateIp($ip)) {
					return $ip;
				}
			}
		}
	}
	return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;
}

/**
 * Ensures an ip address is both a valid IP and does not fall within
 * a private network range.
 */
function validateIp($ip) {
	if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
		return false;
	}
	return true;
}

function userAgent() {
	return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
}

function getRandom($length){
	$cstrong = true;
	$bytes = openssl_random_pseudo_bytes($length, $cstrong);
	$hex   = bin2hex($bytes);
	return substr($hex, $length);
}

function return_response($success, $message = "")
{
    $return_array = array(
        "success" => $success,
        "msg" => $message
    );
    echo json_encode($return_array);
    die;
}