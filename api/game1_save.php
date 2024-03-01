<?php
require_once dirname(__FILE__) . '/../protected/common.php';
require_once dirname(__FILE__) . '/../protected/config.php';
require_once dirname(__FILE__) . '/../protected/functions.php';

header("Content-type: application/json; charset=utf-8");

$form_data = array();

$game_data = [];
$game_result = '';

if(isset($_POST['game1_selected']) && !empty($_POST['game1_selected'])){
    $get_game_data = $_POST['game1_selected']['game1'];
    $game_data['q1'] = isset($get_game_data['q1']) ? filter_var($get_game_data['q1'], FILTER_SANITIZE_STRING) : '';
    $game_data['q1a'] = isset($get_game_data['q1a']) ? filter_var($get_game_data['q1a'], FILTER_SANITIZE_STRING) : '';
    $game_data['q1b'] = isset($get_game_data['q1b']) ? filter_var($get_game_data['q1b'], FILTER_SANITIZE_STRING) : '';
    $game_data['q2'] = isset($get_game_data['q2']) ? filter_var($get_game_data['q2'], FILTER_SANITIZE_STRING) : '';
    $game_data['q2a'] = isset($get_game_data['q2a']) ? filter_var($get_game_data['q2a'], FILTER_SANITIZE_STRING) : '';
    $game_data['q2b'] = isset($get_game_data['q2b']) ? filter_var($get_game_data['q2b'], FILTER_SANITIZE_STRING) : '';
    $game_data['q3'] = isset($get_game_data['q3']) ? filter_var($get_game_data['q3'], FILTER_SANITIZE_STRING) : '';
    $game_data['q3a'] = isset($get_game_data['q3a']) ? filter_var($get_game_data['q3a'], FILTER_SANITIZE_STRING) : '';
    $game_data['q3b'] = isset($get_game_data['q3b']) ? filter_var($get_game_data['q3b'], FILTER_SANITIZE_STRING) : '';
    $game_data['q3c'] = isset($get_game_data['q3c']) ? filter_var($get_game_data['q3c'], FILTER_SANITIZE_STRING) : '';
    $game_data['q3d'] = isset($get_game_data['q3d']) ? filter_var($get_game_data['q3d'], FILTER_SANITIZE_STRING) : '';
    $game_data['q4'] = isset($get_game_data['q4']) ? filter_var($get_game_data['q4'], FILTER_SANITIZE_STRING) : '';
    $game_data['q4a'] = isset($get_game_data['q4a']) ? filter_var($get_game_data['q4a'], FILTER_SANITIZE_STRING) : '';
    $game_data['q4b'] = isset($get_game_data['q4b']) ? filter_var($get_game_data['q4b'], FILTER_SANITIZE_STRING) : '';
    $game_data['q4c'] = isset($get_game_data['q4c']) ? filter_var($get_game_data['q4c'], FILTER_SANITIZE_STRING) : '';
    $game_data['q4d'] = isset($get_game_data['q4d']) ? filter_var($get_game_data['q4d'], FILTER_SANITIZE_STRING) : '';
}

if(isset($_POST['game1_result'])){
    if($_POST['game1_result'] === 'true'){
        $game_result = '有';
    } else {
        $game_result = '沒有';
    }
}

if(!empty($game_data) && !empty($game_result)){
    /*var_dump($game_data);
    var_dump($game_result);*/
    $current_time = date('Y-m-d H:i:s');

    /*
     * $add_result = db()->insert('game1', array(
        'q1'         => $game_data['q1'],
        'q1a'         => $game_data['q1a'],
        'q1b'         => $game_data['q1b'],
        'q2'         => $game_data['q2'],
        'q2a'         => $game_data['q2a'],
        'q2b'         => $game_data['q2b'],
        'q3'         => $game_data['q3'],
        'q3a'         => $game_data['q3a'],
        'q3b'         => $game_data['q3b'],
        'q3c'         => $game_data['q3c'],
        'q3d'         => $game_data['q3d'],
        'q4'         => $game_data['q4'],
        'q4a'         => $game_data['q4a'],
        'q4b'         => $game_data['q4b'],
        'q4c'         => $game_data['q4c'],
        'q4d'         => $game_data['q4d'],
        'game1_result' => $game_result,
        'created_time'     => $current_time,
        'remote_address' => remoteAddress(),
        'user_agent' => getUserAgent(),
        'is_mobile' => isMobile(),
    ));*/

    $add_result = db()->insert('game1', array(
        'q1'         => $game_data['q1'],
        'q1a'         => $game_data['q1a'],
        'q1b'         => $game_data['q1b'],
        'q2'         => $game_data['q2'],
        'q2a'         => $game_data['q2a'],
        'q2b'         => $game_data['q2b'],
        'q3'         => $game_data['q3'],
        'q3a'         => $game_data['q3a'],
        'q3b'         => $game_data['q3b'],
        'q3c'         => $game_data['q3c'],
        'q3d'         => $game_data['q3d'],
        'q4'         => $game_data['q4'],
        'q4a'         => $game_data['q4a'],
        'q4b'         => $game_data['q4b'],
        'q4c'         => $game_data['q4c'],
        'q4d'         => $game_data['q4d'],
        'result' => $game_result,
        'created_time'     => $current_time,
        'remote_address' => remoteAddress(),
        'user_agent' => getUserAgent(),
        'is_mobile' => isMobile(),
    ));
}

die();


/*$form_data['token'] = isset($_POST['token']) ? filter_var($_POST['token'], FILTER_SANITIZE_STRING) : '';
$form_data['qty'] = isset($_POST['qty']) ? filter_var($_POST['qty'], FILTER_SANITIZE_STRING) : '';*/