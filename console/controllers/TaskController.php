<?php

namespace console\controllers;

use yii\console\Controller;
// 引入curl库
use api\components\Mycurl;
use api\components\Myfun;
use api\components\MyLog;
use console\models\M_pushinfo;
use console\models\M_pushinfo_history;
use Yii;

//define(DEBUG_LOG, '/opt/logs/debug/L_other-' . date('Y-m-d', time()) . '.log');


class TaskController extends Controller
{

    public function actionIndex()
    {
        $result = M_pushinfo::getOldMessage();
        if (empty($result)) {
            echo '没有数据需要删除！';
            exit;
        }
        foreach ($result as $key => $value) {
            $temp = $value->toArray();
            $boolear = M_pushinfo_history::savePushInfo($temp);
            if($boolear) {
                echo "id: {$value['id']} 入历史表成功！";
                $temparr = array('id' => $value['id']);
                $res = M_pushinfo::deleteByArray($temparr);
                if(empty($res)) {
                    file_put_contents('/opt/logs/debug/L_qianyi-' . date('Y-m-d', time()) . '.log', Myfun::generateLogTime().' DeleteQuery => query_res => '. json_encode($temp) ."\n", FILE_APPEND);
                }else{
                    echo "\n--原表数据删除成功！！---\n";
                }
            }
            //exit;
        }
        echo "\n";
        echo '迁移到历史表结束！！';
    }

}