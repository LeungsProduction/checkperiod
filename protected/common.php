<?php
defined('APP_PATH') || define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']));
defined('BASE_URL') || define('BASE_URL', str_replace($_SERVER['DOCUMENT_ROOT'], '', APP_PATH));

define('KB', 1024);         // 1024
define('MB', 1048576);      // 1024 * 1024
define('GB', 1073741824);   // 1024 * 1024 * 1024

header('Content-Type: text/html; charset=UTF-8');

$year = (date('Y') - 12);
$month = array(
		'en' => array(
				'00' => 'Month',
				'01' => 'January',
				'02' => 'February',
				'03' => 'March',
				'04' => 'April',
				'05' => 'May',
				'06' => 'June',
				'07' => 'July',
				'08' => 'August',
				'09' => 'September',
				'10' => 'October',
				'11' => 'November',
				'12' => 'December'),
		'hk' => array(
				'00' => '月份',
				'01' => '一月',
				'02' => '二月',
				'03' => '三月',
				'04' => '四月',
				'05' => '五月',
				'06' => '六月',
				'07' => '七月',
				'08' => '八月',
				'09' => '九月',
				'10' => '十月',
				'11' => '十一月',
				'12' => '十二月'),
);
