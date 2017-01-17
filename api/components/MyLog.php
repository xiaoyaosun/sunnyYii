<?php

namespace api\components;


class MyLog
{
    private static $debug = true;
//    public static $logArr = array();
    public static $logByFileArr = array();
    public static $logErrorArr = array();
    //普通日志
    //先简单处理，最后实现更高级功能，比如自动识别controller和action，行数等等
    /* public static function log($content)
     {
         if ($content) {
             self::$logArr[] =UNIQUE_ID .'-'. $content . "\n";
         }
     }*/

    public static function log( $content)
    {
        if ($content) {
            $backtraceArr = debug_backtrace();
            if ($backtraceArr && isset($backtraceArr[1])) {
                $temp = explode("\\",$backtraceArr[1]['class']);
                $fileName = end($temp);
                $function = $backtraceArr[1]['function'];
            }
            if (!isset(self::$logByFileArr[$fileName])) {
                self::$logByFileArr[$fileName] = array();
            }
            self::$logByFileArr[$fileName][] = UNIQUE_ID . "-".$function ."-". $content ."\n";

        }
    }
    //指定output filename
    public static function logSpec($fileName,$content){
        if ($content) {
            if (!isset(self::$logByFileArr[$fileName])) {
                self::$logByFileArr[$fileName] = array();
            }
            self::$logByFileArr[$fileName][] = UNIQUE_ID  ."-". $content ."\n";

        }
    }

    //严重错误日志
    public static function logError($content)
    {
        if ($content) {
            $backtraceArr = debug_backtrace();
            if ($backtraceArr && isset($backtraceArr[1])) {
                $temp = explode("\\",$backtraceArr[1]['class']);
                $fileName = end($temp);
                $function = $backtraceArr[1]['function'];
            }
            if (!isset(self::$logErrorArr[$fileName])) {
                self::$logErrorArr[$fileName] = array();
            }
            self::$logErrorArr[$fileName][] = UNIQUE_ID . "-".$function ."-". $content ."\n";
        }
    }

    //请求周期结束后调用
    public static function logEnd()
    {
        if (self::$debug) {
            /*if (self::$logArr) {
                file_put_contents('/opt/logs/debug/' . date('Y-m-d', time()) . '.log', implode('', self::$logArr), FILE_APPEND);
            }*/
            if (self::$logByFileArr) {
                foreach (self::$logByFileArr as $key => $logByFile) {
                    file_put_contents('/opt/logs/debug/--' . $key . '--' . date('Y-m-d', time()) . '.log', implode('', $logByFile), FILE_APPEND);
                }
            }
            if (self::$logErrorArr) {
                foreach (self::$logErrorArr as $key => $logByFile) {
                    file_put_contents('/opt/logs/debug/--' . $key . 'error--' . date('Y-m-d', time()) . '.log', implode('', $logByFile), FILE_APPEND);
                }
            }
        }


    }

}