<?php

namespace api\components;

use Yii;
use yii\db\ActiveRecord;

class YQTracer
{

    private $start_time;

    private $end_time;

    public $caller_user_name;

    private $action;

    private $response;

    /**
     * Constructor.
     *
     * @param string $id the ID of this action
     * @param Controller $controller the controller that owns this action
     * @param array $config name-value pairs that will be used to initialize the object properties
     */
    public function __construct($action = '')
    {
        $this->action = $action;
        $this->start_time = microtime(true);
    }

    /*
     * 记录日志
     */
    public function addTraceLog($response = array())
    {
        $user_name = empty($this->caller_user_name) ? '' : $this->caller_user_name;
        $this->end_time = microtime(true);
        if(is_object($response)){
            if($response instanceof ActiveRecord){
                $response = $response->toArray();
            }else{
                $response = (array)$response;
            }
        }
        $this->response = $this->json($response);
        $duration = ($this->end_time - $this->start_time);
        $round = number_format($duration, 2, '.', '');
        $message = "\t{$this->response}\t{$user_name}\t{$this->action}\t{$round}";
        Yii::info($message, 'info');
    }

    /*
    * 记录错误日志
    */
    public function addErrorLog($response = array())
    {
        $user_name = empty($this->caller_user_name) ? '' : $this->caller_user_name;
        $this->end_time = microtime(true);
        if(is_object($response)){
            if($response instanceof ActiveRecord){
                $response = $response->toArray();
            }else{
                $response = (array)$response;
            }
        }
        $this->response = $this->json($response);
        $duration = ($this->end_time - $this->start_time);
        $round = number_format($duration, 2, '.', '');
        $message = "\t{$this->response}\t{$user_name}\t{$this->action}\t{$round}";
//var_dump($message);
		//Yii::info($message, 'info');
        Yii::error($message, 'error');
    }

    /**************************************************************
     *
     *  将数组转换为JSON字符串（兼容中文）
     *  @param  array   $array      要转换的数组
     *  @return string      转换得到的json字符串
     *  @access public
     *
     *************************************************************/
    public function json($array) {
        $this->arrayRecursive($array, 'urlencode', false);
        $json = json_encode($array);
        return urldecode($json);
    }


    /**************************************************************
     *
     *  使用特定function对数组中所有元素做处理
     *  @param  string  &$array     要处理的字符串
     *  @param  string  $function   要执行的函数
     *  @return boolean $apply_to_keys_also     是否也应用到key上
     *  @access public
     *
     *************************************************************/
    public function arrayRecursive(&$array, $function, $apply_to_keys_also = false){
        static $recursive_counter = 0;
        if (++$recursive_counter > 1000) {
            die('possible deep recursion attack');
        }
        foreach ($array as $key => $value) {
            if(is_object($value)){
                if($value instanceof ActiveRecord){
                    $array[$key] = $value->toArray();
                }else{
                    $array[$key] = (array)$value;
                }

                $this->arrayRecursive($array[$key], $function, $apply_to_keys_also);
            }else if (is_array($value)) {
                $this->arrayRecursive($array[$key], $function, $apply_to_keys_also);
            } else {
                $array[$key] = $function($value);
            }

            if ($apply_to_keys_also && is_string($key)) {
                $new_key = $function($key);
                if ($new_key != $key) {
                    $array[$new_key] = $array[$key];
                    unset($array[$key]);
                }
            }
        }
        $recursive_counter--;
    }
} 