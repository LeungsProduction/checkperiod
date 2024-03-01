<?php
require_once dirname(__FILE__) . '/../protected/common.php';
require_once dirname(__FILE__) . '/../protected/config.php';
require_once dirname(__FILE__) . '/../protected/functions.php';

header("Content-type: application/json; charset=utf-8");

$form_data = array();

$game_data = [];

if(!empty($_POST['gender']) && !empty($_POST['age']) && !empty($_POST['day']) && !empty($_POST['using_item']) && !empty($_POST['record']) && !empty($_POST['score'])){

    $game_data['gender'] = isset($_POST['gender']) ? filter_var($_POST['gender'], FILTER_SANITIZE_STRING) : '';
    $game_data['age'] = isset($_POST['age']) ? filter_var($_POST['age'], FILTER_SANITIZE_STRING) : '';
    $game_data['day'] = isset($_POST['day']) ? filter_var($_POST['day'], FILTER_SANITIZE_STRING) : '';
    $game_data['using_item'] = isset($_POST['using_item']) ? filter_var($_POST['using_item'], FILTER_SANITIZE_STRING) : '';
    $game_data['record'] = isset($_POST['record']) ? filter_var($_POST['record'], FILTER_SANITIZE_STRING) : '';
    $game_data['find_doctor'] = isset($_POST['find_doctor']) ? filter_var($_POST['find_doctor'], FILTER_SANITIZE_STRING) : '';
    $game_data['heme_test'] = isset($_POST['heme_test']) ? filter_var($_POST['heme_test'], FILTER_SANITIZE_STRING) : '';
    $game_data['medication'] = isset($_POST['medication']) ? filter_var($_POST['medication'], FILTER_SANITIZE_STRING) : '';
    $game_data['score'] = isset($_POST['score']) ? filter_var($_POST['score'], FILTER_SANITIZE_STRING) : '';

}


if(!empty($game_data)){
    var_dump($game_data);
    /*var_dump($game1_result);*/
    $current_time = date('Y-m-d H:i:s');

    $add_result = db()->insert('game2', array(
        'gender'         => $game_data['gender'],
        'age'         => $game_data['age'],
        'day'         => $game_data['day'],
        'using_item'         => $game_data['using_item'],
        'record'         => $game_data['record'],
        'find_doctor'         => $game_data['find_doctor'],
        'heme_test'         => $game_data['heme_test'],
        'medication'         => $game_data['medication'],
        'score'         => $game_data['score'],
        'created_time'     => $current_time,
        'remote_address' => remoteAddress(),
        'user_agent' => getUserAgent(),
        'is_mobile' => isMobile(),
    ));
}

die();


/*$form_data['token'] = isset($_POST['token']) ? filter_var($_POST['token'], FILTER_SANITIZE_STRING) : '';
$form_data['qty'] = isset($_POST['qty']) ? filter_var($_POST['qty'], FILTER_SANITIZE_STRING) : '';*/