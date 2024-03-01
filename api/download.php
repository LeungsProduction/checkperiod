<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2021/8/20
 * Time: 下午 01:05
 */
require_once dirname(__FILE__) . '/../protected/common.php';
require_once dirname(__FILE__) . '/../protected/config.php';
require_once dirname(__FILE__) . '/../protected/functions.php';

if(empty($_GET['game'])){
    echo 'Invalid URL';
    die();
}
if(empty($_GET['token']) || $_GET['token'] !== 'aBa92nPT7g39LY2W'){
    echo 'Invalid URL';
    die();
}

$game = $_GET['game'];


if($game === '1'){
    $get_game_data = db()->select('game1', '*');
    $data = getGameData($get_game_data, 1);
} else if($game === '2'){
    $get_game_data = db()->select('game2', '*');
    $data = getGameData($get_game_data, 2);
}


$fileName = 'game'.$game.'_'.date('Y-m-d_H-i-s').'.csv';
downloadCsv($data, $fileName);

function getGameData($get_data, $game){
    $rows = array();

    // game 1
    if($game === 1){
        foreach ($get_data as $item) {
            $row = array(
                'ID' => $item['id'],
                '年齡' => $item['q4a'],
                //'性別' => $item['q4'],
                '曾因受經痛困擾以致無法工作/上學/出席社交活動，或影響日常生活' => $item['q1'],
                '曾於月經期間出現腹脹、腹痛、壓痛(按壓腹部時感到疼痛)' => $item['q1a'],
                '曾於月經期間出現腸胃不適情況，例如： 噁心或嘔吐, 腹部絞痛及出現肚瀉/便秘情況' => $item['q1b'],
                '經常出現全身無力、疲憊等狀況' => $item['q2'],
                '曾於進行性行為時感到疼痛' => $item['q2a'],
                '曾有過敏情況，並於月經前後及期間情況轉壞' => $item['q2b'],
                '家族中曾有人患有子宮內膜異位症' => $item['q3'],
                '曾患朱古力瘤' => $item['q3a'],
                '曾出現流產、不育或宮外孕' => $item['q3b'],
                '曾患上免疫系統疾病或以下疾病: 
甲狀腺疾病 / 類風濕關節炎 / 紅斑狼瘡 / 纖維肌痛 / 多發性硬化症 / 慢性偏頭痛' => $item['q3c'],
                '曾進行盆腔手術例如腹腔鏡檢查，而懷疑患上子宮內膜異位症，但未曾確診' => $item['q3d'],
                '曾否聽過子宮內膜異位症' => $item['q4b'],
                '認為子宮內膜異位症有機會復發' => $item['q4c'],
                '知道子宮內膜異位症可導致不育' => $item['q4d'],
                '測試結果' => $item['result'],
                '測試時間' => $item['created_time'],
            );

            $rows[] = $row;
        }
    } else if($game === 2){
        // game 2
        foreach ($get_data as $item) {

            $get_record = json_decode(html_entity_decode( stripslashes ($item['record'])))->arrayIndex;
            $record_quantity = '';
            $record_rate = '';
            $record_blood_clot = '';
            $record_vaginal_bleeding = '';

            $line_break = '
';

            foreach ($get_record as $key => $record){
                //var_dump($record);
                $before = '';
                if($key != 0){
                    $before = $line_break;
                }

                $record_quantity .= $before.'第'.($key+1).'天 使用量:'.$record->q1c;
                $record_rate .= $before.'第'.($key+1).'天 少量:'.$record->q2answer->q2c0.'--中量:'.$record->q2answer->q2c1.'--多量:'.$record->q2answer->q2c2;
                $record_blood_clot .= $before.'第'.($key+1).'天 少:'.$record->q3answer->q3c1.'--大:'.$record->q3answer->q3c2;
                $record_vaginal_bleeding .= $before.'第'.($key+1).'天: '.$record->q4c;
            }
            /*echo '<pre>';
            var_dump($get_record);
            var_dump($record_quantity);
            var_dump($record_rate);
            var_dump($record_blood_clot);
            var_dump($record_vaginal_bleeding);
            echo '</pre>';*/



            $row = array(
                'ID' => $item['id'],
                //'年齡' => $item['age'],
                '年齡' => '"=""'.$item['age'].'"""',
                //'性別' => $item['gender'],
                '平均來經日數' => $item['day'],
                '來經時所用的是' => $item['using_item'],
                //'' => $item['record'],
                '衛生巾/棉條用量' => $record_quantity,
                '流量於衛生棉條出現的次數' => $record_rate,
                '血塊出現的次數' => $record_blood_clot,
                '血崩出現的次數' => $record_vaginal_bleeding,
                '曾否到婦科醫生求診或做檢查' => $item['find_doctor'],
                '血紅素測試結果' => $item['heme_test'],
                '藥物治療' => $item['medication'],
                '分數' => $item['score'],
                '測試時間' => $item['created_time'],
            );

            $rows[] = $row;
        }
    }


    return $rows;
}

/*var_dump($get_game1_data);
die();*/




function downloadCsv($data, $fileName) {
    header('Content-Disposition: attachment; filename=' . $fileName);
    header('Content-Type: application/csv');
    echo "\xEF\xBB\xBF"; // UTF-8 BOM
    echo array_to_csv($data);
    exit;
}


exit;
